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
                    'total_price' => $bookingData['total_price'],
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

            // Process direct payment with Stripe
            Stripe::setApiKey(config('services.stripe.secret'));

            // Get payment method ID from the request
            $paymentMethodId = $request->input('payment_method_id');

            if (!$paymentMethodId) {
                return response()->json(['error' => 'Payment method ID is required'], 400);
            }

            // Create a payment intent
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => (int)($bookingData['total_price'] * 100), // Convert to cents
                'currency' => 'usd',
                'payment_method' => $paymentMethodId,
                'payment_method_types' => ['card'],
                'confirmation_method' => 'manual',
                'confirm' => true,
                'description' => ($bookingData['car']['brand'] ?? 'Car') . ' ' . ($bookingData['car']['model'] ?? 'Rental'),
                'metadata' => [
                    'booking_id' => $booking->id,
                    'user_id' => $user->id,
                    'car_id' => $bookingData['car']['id']
                ],
            ]);

            // Create payment record in database
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $booking->total_price ?? $bookingData['total_price'],
                'mode_payment_id' => $paymentMethod->id,
                'transaction_id' => $paymentIntent->id,
                'status' => $paymentIntent->status === 'succeeded' ? 'successful' : 'pending',
                'stripe_payment_id' => $paymentIntent->id,
                'stripe_response' => json_encode($paymentIntent)
            ]);

            // If payment succeeded, update booking status
            if ($paymentIntent->status === 'succeeded') {
                $booking->update(['status' => 'confirmed']);
                return response()->json([
                    'success' => true,
                    'redirect' => route('stripe.success') . '?payment_intent=' . $paymentIntent->id
                ]);
            }

            // If payment requires additional action (3D Secure, etc.)
            if (
                $paymentIntent->status === 'requires_action' &&
                $paymentIntent->next_action &&
                $paymentIntent->next_action->type === 'use_stripe_sdk'
            ) {
                return response()->json([
                    'requires_action' => true,
                    'payment_intent_client_secret' => $paymentIntent->client_secret
                ]);
            }

            return response()->json([
                'success' => true,
                'payment_intent' => $paymentIntent->id
            ]);
        } catch (\Exception $e) {
            report($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function success(Request $request)
    {
        try {
            $paymentIntentId = $request->get('payment_intent');

            if (!$paymentIntentId) {
                return redirect()->route('home')->with('error', 'No payment information found.');
            }

            Stripe::setApiKey(config('services.stripe.secret'));
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

            $payment = Payment::where('transaction_id', $paymentIntentId)->firstOrFail();
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
            return redirect()->route('dashboard')->with('error', 'Failed to process payment confirmation.');
        }
    }

    public function cancel()
    {
        return redirect()->route('dashboard')->with('error', 'Payment was cancelled.');
    }

    public function confirmPayment(Request $request)
    {
        try {
            $paymentIntentId = $request->input('payment_intent_id');

            if (!$paymentIntentId) {
                return response()->json(['error' => 'Payment intent ID is required'], 400);
            }

            Stripe::setApiKey(config('services.stripe.secret'));
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

            // If payment is successful, update records
            if ($paymentIntent->status === 'succeeded') {
                $payment = Payment::where('stripe_payment_id', $paymentIntentId)->first();

                if ($payment) {
                    $payment->update(['status' => 'successful']);

                    $booking = Booking::find($payment->booking_id);
                    if ($booking) {
                        $booking->update(['status' => 'confirmed']);
                    }
                }

                return response()->json([
                    'success' => true,
                    'redirect' => route('stripe.success') . '?payment_intent=' . $paymentIntentId
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Payment was not successful'
            ], 400);
        } catch (\Exception $e) {
            report($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
