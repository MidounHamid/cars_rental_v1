<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Mode_payment;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class StripePaymentController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $bookingData = session('booking_data', []);
        if (empty($bookingData)) {
            return redirect()->route('dashboard')->with('error', 'No booking information found.');
        }

        // Ensure all fees are set
        $bookingData = $this->ensureAllFees($bookingData);
        $bookingData = $this->calculateTotalPrice($bookingData);
        session(['booking_data' => $bookingData]);

        return view('stripe.payment', compact('bookingData'));
    }

    public function checkout(Request $request)
    {
        $bookingData = session('booking_data', []);
        $user = Auth::user();

        // Validate and calculate fees
        $bookingData = $this->ensureAllFees($bookingData);
        $bookingData = $this->calculateTotalPrice($bookingData);

        // Handle client-side total price confirmation
        $confirmedTotalPrice = $request->input('confirmed_total_price');
        if (!empty($confirmedTotalPrice)) {
            $confirmedTotalPrice = (float) $confirmedTotalPrice;
            $calculatedTotalPrice = (float) $bookingData['total_price'];

            if (abs($confirmedTotalPrice - $calculatedTotalPrice) > 0.01) {
                $bookingData['total_price'] = $confirmedTotalPrice;
            }
        }

        session(['booking_data' => $bookingData]);

        // Validate booking data
        $validator = Validator::make($bookingData, [
            'total_price' => 'required|numeric|min:0.01',
            'car.id' => 'required|exists:cars,id',
            'car.model' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            // Fetch car brand if missing
            if (empty($bookingData['car']['brand']) && !empty($bookingData['car']['id'])) {
                $car = Car::find($bookingData['car']['id']);
                if ($car->brand_id) {
                    $brand = \App\Models\Brand::find($car->brand_id);
                    $bookingData['car']['brand'] = $brand->brand ?? 'Unknown Brand';
                    session(['booking_data' => $bookingData]);
                }
            }

            // Create or update booking
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
                    'insurance_fee' => $bookingData['insurance_fee'],
                    'service_fee' => $bookingData['service_fee'],
                    'additional_options' => $bookingData['additional_options'],
                ]);

                // Attach specifications
                if (isset($bookingData['specifications'])) {
                    $specIds = collect($bookingData['specifications'])->pluck('id')->toArray();
                    $booking->specifications()->sync($specIds);
                }

                $bookingData['booking_id'] = $booking->id;
                session(['booking_data' => $bookingData]);
            } else {
                $booking = Booking::where('id', $bookingData['booking_id'])
                    ->where('user_id', $user->id)
                    ->firstOrFail();

                $booking->update([
                    'total_price' => $bookingData['total_price'],
                    'insurance_fee' => $bookingData['insurance_fee'],
                    'service_fee' => $bookingData['service_fee'],
                    'additional_options' => $bookingData['additional_options'],
                ]);

                // Sync specifications
                if (isset($bookingData['specifications'])) {
                    $specIds = collect($bookingData['specifications'])->pluck('id')->toArray();
                    $booking->specifications()->sync($specIds);
                }
            }

            // Process Stripe payment
            $paymentMethod = Mode_payment::where('mode_payment', 'stripe')->firstOrFail();
            Stripe::setApiKey(config('services.stripe.secret'));
            $paymentMethodId = $request->input('payment_method_id');

            if (!$paymentMethodId) {
                return response()->json(['error' => 'Payment method ID required'], 400);
            }

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => (int)($bookingData['total_price'] * 100),
                'currency' => 'usd',
                'payment_method' => $paymentMethodId,
                'payment_method_types' => ['card'],
                'confirmation_method' => 'manual',
                'confirm' => true,
                'description' => ($bookingData['car']['brand'] ?? 'Car') . ' ' . ($bookingData['car']['model'] ?? 'Rental'),
                'metadata' => [
                    'booking_id' => $booking->id,
                    'user_id' => $user->id,
                    'car_id' => $bookingData['car']['id'],
                    'base_price' => $bookingData['car']['price_per_day'] * ($bookingData['duration_days'] ?? 1),
                    'insurance_fee' => $bookingData['insurance_fee'],
                    'service_fee' => $bookingData['service_fee'],
                    'additional_options' => $bookingData['additional_options']
                ],
            ]);

            // Record payment
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $bookingData['total_price'],
                'mode_payment_id' => $paymentMethod->id,
                'transaction_id' => $paymentIntent->id,
                'status' => $paymentIntent->status === 'succeeded' ? 'successful' : 'pending',
                'stripe_payment_id' => $paymentIntent->id,
                'stripe_response' => json_encode($paymentIntent)
            ]);

            // Handle payment success
            if ($paymentIntent->status === 'succeeded') {
                $booking->update(['status' => 'confirmed']);
                return response()->json([
                    'success' => true,
                    'redirect' => route('stripe.success') . '?payment_intent=' . $paymentIntent->id
                ]);
            }

            // Handle 3D Secure
            if ($paymentIntent->status === 'requires_action') {
                return response()->json([
                    'requires_action' => true,
                    'payment_intent_client_secret' => $paymentIntent->client_secret
                ]);
            }

            return response()->json(['success' => true, 'payment_intent' => $paymentIntent->id]);
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
                return redirect()->route('home')->with('error', 'Invalid payment');
            }

            Stripe::setApiKey(config('services.stripe.secret'));
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
            $payment = Payment::where('transaction_id', $paymentIntentId)->firstOrFail();
            $booking = Booking::with(['car.brand', 'user', 'specifications'])->findOrFail($payment->booking_id);

            // Update payment and booking status
            $payment->update(['status' => 'successful']);
            $booking->update(['status' => 'confirmed']);

            // Create notification for booking confirmation
            $this->notificationService->createBookingNotification($booking, 'booking_confirmation');

            // Calculate receipt components
            $durationDays = $booking->duration_days ?? \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date);
            $basePrice = $booking->car->price_per_day * $durationDays;
            $insuranceFee = $booking->insurance_fee ?? 0;
            $serviceFee = $booking->service_fee ?? 0;
            $additionalOptions = $booking->additional_options ?? 0;

            // Generate PDF
            $pdf = Pdf::loadView('pdf.booking-receipt', [
                'booking' => $booking,
                'basePrice' => $basePrice,
                'insuranceFee' => $insuranceFee,
                'serviceFee' => $serviceFee,
                'additionalOptions' => $additionalOptions,
                'totalPrice' => $payment->amount
            ]);

            // Save PDF
            $pdfPath = 'receipts/booking-' . $booking->id . '.pdf';
            Storage::put('public/' . $pdfPath, $pdf->output());
            $booking->update(['receipt_path' => $pdfPath]);

            session()->forget('booking_data');

            return view('stripe.success', [
                'payment' => $payment,
                'booking' => $booking,
                'pdfUrl' => Storage::url($pdfPath)
            ]);
        } catch (\Exception $e) {
            report($e);
            return redirect()->route('dashboard')->with('error', 'Payment confirmation failed.');
        }
    }

    // Other methods (cancel, confirmPayment) remain unchanged

    private function calculateTotalPrice(array $bookingData)
    {
        $pricePerDay = $bookingData['car']['price_per_day'] ?? 0;
        $durationDays = $bookingData['duration_days'] ?? 1;
        $rentalSubtotal = $pricePerDay * $durationDays;
        $insuranceFee = $bookingData['insurance_fee'] ?? 0;
        $serviceFee = $bookingData['service_fee'] ?? 15.0;
        $additionalOptions = $bookingData['additional_options'] ?? 0;

        $bookingData['total_price'] = $rentalSubtotal + $insuranceFee + $serviceFee + $additionalOptions;
        return $bookingData;
    }

    private function ensureAllFees(array $bookingData)
    {
        if (!isset($bookingData['insurance_fee'])) $bookingData['insurance_fee'] = 0;
        if (!isset($bookingData['service_fee'])) $bookingData['service_fee'] = 15.0;
        if (!isset($bookingData['additional_options'])) $bookingData['additional_options'] = 0;
        return $bookingData;
    }
}
