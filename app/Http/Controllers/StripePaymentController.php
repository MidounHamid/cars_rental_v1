<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\ModePayment; // Use PascalCase for model name
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Validator;
use App\Models\Payment;
use App\Models\Booking; // Add Booking model
use App\Models\Mode_payment;

class StripePaymentController extends Controller
{



    public function index()
    {
        $bookingData = session('booking_data', []);
        if (empty($bookingData)) {
            return redirect()->route('home')->with('error', 'No booking information found.');
        }

        return view('stripe.payment', compact('bookingData'));
    }

    public function checkout(Request $request)
    {
        $bookingData = session('booking_data', []);
        $user = auth()->user();

        // Validate session data structure
        $validator = Validator::make($bookingData, [
            'total_price' => 'required|numeric|min:0.01',
            'car.id' => 'required|exists:cars,id',
            'booking_id' => 'required|exists:bookings,id',
            'car.brand' => 'required|string',
            'car.model' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard')->withErrors($validator);
        }

        try {
            // Verify booking exists and belongs to user
            $booking = Booking::where('id', $bookingData['booking_id'])
                ->where('user_id', $user->id)
                ->firstOrFail();

            // Get payment method
            $paymentMethod = Mode_payment::where('mode_payment', 'stripe')->firstOrFail();

            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentIntent = PaymentIntent::create([
                'amount' => $bookingData['total_price'] * 100,
                'currency' => 'usd',
                'payment_method' => $request->payment_method_id,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'metadata' => [
                    'booking_id' => $booking->id,
                    'user_id' => $user->id,
                    'car_id' => $bookingData['car']['id']
                ],
                'return_url' => route('stripe.success'),
            ]);

            $payment = $this->createPaymentRecord($paymentIntent, $booking, $paymentMethod);

            return $this->handlePaymentStatus($paymentIntent, $payment, $booking);

        } catch (ApiErrorException $e) {
            return $this->handleStripeError($e);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('home')->withErrors(['booking' => 'Invalid booking']);
        } catch (\Exception $e) {
            report($e); // Log exception
            return redirect()->back()->withErrors(['system' => 'An unexpected error occurred']);
        }
    }

    private function createPaymentRecord(PaymentIntent $paymentIntent, Booking $booking, Mode_payment $method): Payment
    {
        return Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_price,
            'mode_payment_id' => $method->id,
            'transaction_id' => $paymentIntent->id,
            'status' => $this->mapStripeStatus($paymentIntent->status),
            'stripe_payment_id' => $paymentIntent->id,
            'stripe_response' => $paymentIntent->toArray()
        ]);
    }

    private function mapStripeStatus(string $status): string
    {
        return match($status) {
            'succeeded' => 'successful',
            'processing', 'requires_action', 'requires_confirmation' => 'pending',
            'canceled', 'requires_payment_method' => 'failed',
            default => 'failed'
        };
    }

    private function handlePaymentStatus(PaymentIntent $paymentIntent, Payment $payment, Booking $booking)
    {
        switch ($paymentIntent->status) {
            case 'succeeded':
                $this->finalizeSuccessfulPayment($payment, $booking);
                return redirect()->route('stripe.success')->with([
                    'payment' => $payment,
                    'booking' => $booking
                ]);

            case 'requires_action':
                return redirect()->away($paymentIntent->next_action->redirect_to_url->url);

            default:
                $payment->update(['status' => 'failed']);
                return redirect()->route('stripe.cancel')->withErrors([
                    'payment' => 'Payment failed. Please try again.'
                ]);
        }
    }

    private function finalizeSuccessfulPayment(Payment $payment, Booking $booking)
    {
        session()->forget('booking_data');

        $payment->update(['status' => 'successful']);
        $booking->update(['status' => 'confirmed']);
    }

    private function handleStripeError(ApiErrorException $e)
    {
        $error = $e->getError();

        return back()->withErrors([
            'payment' => $error->message ?? 'Payment processing failed'
        ]);
    }

    public function success(Request $request)
    {
        if (!$request->hasSession() || !$request->session()->has('payment')) {
            return redirect()->route('home');
        }

        return view('payment.success', [
            'payment' => $request->session()->get('payment'),
            'booking' => $request->session()->get('booking')
        ]);
    }

    public function cancel()
    {
        return view('payment.cancel');
    }
}
