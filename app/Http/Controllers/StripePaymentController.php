<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Mode_payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Stripe\Exception\ApiErrorException;

class StripePaymentController extends Controller
{
    public function index()
    {
        $bookingData = session('booking_data', []);
        if (empty($bookingData)) {
            return redirect()->route('dashboard')->with('error', 'No booking information found.');
        }

        return view('stripe.payment', compact('bookingData'));
    }

    public function checkout(Request $request)
    {
        $bookingData = session('booking_data', []);
        $user = Auth::user();

        // Validate session data structure
        $validator = Validator::make($bookingData, [
            'total_price' => 'required|numeric|min:0.01',
            'car.id' => 'required|exists:cars,id',
            'car.model' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            // Ensure car brand is set in the booking data
            if (empty($bookingData['car']['brand']) && !empty($bookingData['car']['id'])) {
                $car = Car::find($bookingData['car']['id']);
                if ($car && $car->brand_id) {
                    $brand = \App\Models\Brand::find($car->brand_id);
                    $bookingData['car']['brand'] = $brand ? $brand->brand : 'Unknown Brand';
                    session(['booking_data' => $bookingData]);
                }
            }

            // If no booking_id is present, create a new booking
            if (empty($bookingData['booking_id'])) {
                $booking = Booking::create([
                    'user_id' => $user->id,
                    'car_id' => $bookingData['car']['id'],
                    'start_date' => $bookingData['pickup_date'] ?? now()->format('Y-m-d'),
                    'end_date' => $bookingData['return_date'] ?? now()->addDays(1)->format('Y-m-d'),
                    'start_time' => $bookingData['pickup_time'] ?? '10:00',
                    'end_time' => $bookingData['return_time'] ?? '10:00',
                    'status' => 'pending',
                ]);

                // Update session with booking_id
                $bookingData['booking_id'] = $booking->id;
                session(['booking_data' => $bookingData]);
            } else {
                $booking = Booking::where('id', $bookingData['booking_id'])
                    ->where('user_id', $user->id)
                    ->firstOrFail();
            }

            $paymentMethod = Mode_payment::where('mode_payment', 'stripe')->firstOrFail();

            Stripe::setApiKey(config('services.stripe.secret'));

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => ($bookingData['car']['brand'] ?? 'Car') . ' ' . ($bookingData['car']['model'] ?? 'Rental'),
                        ],
                        'unit_amount' => $bookingData['total_price'] * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('stripe.cancel'),
                'metadata' => [
                    'booking_id' => $booking->id,
                    'user_id' => $user->id,
                    'car_id' => $bookingData['car']['id']
                ],
            ]);

            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $booking->total_price ?? $bookingData['total_price'],
                'mode_payment_id' => $paymentMethod->id,
                'transaction_id' => $session->id,
                'status' => 'pending',
                'stripe_payment_id' => $session->id,
                'stripe_response' => json_encode($session)
            ]);

            return response()->json(['sessionId' => $session->id]);
        } catch (\Exception $e) {
            report($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function success(Request $request)
    {
        try {
            $sessionId = $request->get('session_id');

            if (!$sessionId) {
                return redirect()->route('home')->with('error', 'No session information found.');
            }

            Stripe::setApiKey(config('services.stripe.secret'));
            $session = \Stripe\Checkout\Session::retrieve($sessionId);

            $payment = Payment::where('transaction_id', $sessionId)->firstOrFail();
            $booking = Booking::findOrFail($payment->booking_id);

            $payment->update(['status' => 'successful']);
            $booking->update(['status' => 'confirmed']);

            session()->forget('booking_data');

            return view('payment.success', [
                'payment' => $payment,
                'booking' => $booking
            ]);
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('home')->with('error', 'Failed to process payment confirmation.');
        }
    }

    public function cancel()
    {
        return redirect()->route('dashboard')->with('error', 'Payment was cancelled.');
    }
}
