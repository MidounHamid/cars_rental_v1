<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Mode_payment;
use App\Models\Specification;
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

        // Get the confirmed total price from the form
        $confirmedTotalPrice = $request->input('confirmed_total_price');

        try {
            // Recalculate total price to ensure consistency
            $bookingData = $this->calculateTotalPrice($bookingData);
            $totalPrice = $bookingData['total_price'];

            // Create or update booking with the calculated total price
            if (empty($bookingData['booking_id'])) {
                $booking = Booking::create([
                    'user_id' => $user->id,
                    'car_id' => $bookingData['car']['id'],
                    'start_date' => $bookingData['pickup_date'] ?? now()->format('Y-m-d'),
                    'end_date' => $bookingData['return_date'] ?? now()->addDays(1)->format('Y-m-d'),
                    'start_time' => $bookingData['pickup_time'] ?? '10:00',
                    'end_time' => $bookingData['return_time'] ?? '10:00',
                    'status' => 'pending',
                    'total_price' => $totalPrice,
                    'promotion_id' => $bookingData['promotion_id'] ?? null
                ]);
            } else {
                $booking = Booking::where('id', $bookingData['booking_id'])
                    ->where('user_id', $user->id)
                    ->firstOrFail();

                $booking->update([
                    'total_price' => $totalPrice,
                    'promotion_id' => $bookingData['promotion_id'] ?? null
                ]);
            }

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

                // Calculate insurance fee
                $car = Car::with('insurance')->find($bookingData['car']['id']);
                $startDate = \Carbon\Carbon::parse($bookingData['pickup_date']);
                $endDate = \Carbon\Carbon::parse($bookingData['return_date']);
                $durationDays = $startDate->diffInDays($endDate);

                // Get insurance fee from car's insurance
                $insuranceFee = 0;
                if ($car->insurance) {
                    $insuranceFee = $car->insurance->price_per_day * $durationDays;
                    $bookingData['insurance_fee'] = $insuranceFee;
                }

                // Calculate promotion discount if any
                $promotionDiscount = 0;
                if (isset($bookingData['promotion_id'])) {
                    $promotion = \App\Models\Promotion::find($bookingData['promotion_id']);
                    if ($promotion) {
                        $basePrice = $car->price_per_day * $durationDays;
                        $promotionDiscount = ($basePrice * $promotion->discount_percent) / 100;
                        $bookingData['promotion_discount'] = $promotionDiscount;
                    }
                }

                // Create or update booking
                if (empty($bookingData['booking_id'])) {
                    // Create new booking with total price
                    $booking = Booking::create([
                        'user_id' => $user->id,
                        'car_id' => $bookingData['car']['id'],
                        'start_date' => $bookingData['pickup_date'] ?? now()->format('Y-m-d'),
                        'end_date' => $bookingData['return_date'] ?? now()->addDays(1)->format('Y-m-d'),
                        'start_time' => $bookingData['pickup_time'] ?? '10:00',
                        'end_time' => $bookingData['return_time'] ?? '10:00',
                        'status' => 'pending',
                        'total_price' => $totalPrice,
                        'promotion_id' => $bookingData['promotion_id'] ?? null
                    ]);

                    // Attach specifications
                    if (isset($bookingData['specifications'])) {
                        foreach ($bookingData['specifications'] as $spec) {
                            $booking->specifications()->attach($spec['id'], [
                                'quantity' => $spec['quantity'] ?? 1,
                                'price' => $spec['price'] ?? 0
                            ]);
                        }
                    }

                    $bookingData['booking_id'] = $booking->id;
                    session(['booking_data' => $bookingData]);
                } else {
                    // Update existing booking
                    $booking = Booking::where('id', $bookingData['booking_id'])
                        ->where('user_id', $user->id)
                        ->firstOrFail();

                    // Update booking with total price
                    $booking->update([
                        'total_price' => $totalPrice,
                        'promotion_id' => $bookingData['promotion_id'] ?? null
                    ]);

                    // Sync specifications
                    if (isset($bookingData['specifications'])) {
                        $specSync = [];
                        foreach ($bookingData['specifications'] as $spec) {
                            $specSync[$spec['id']] = [
                                'quantity' => $spec['quantity'] ?? 1,
                                'price' => $spec['price'] ?? 0
                            ];
                        }
                        $booking->specifications()->sync($specSync);
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
                    'amount' => (int)($totalPrice * 100), // Use the final total price
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
                        'total_price' => $totalPrice
                    ],
                ]);

                // Record payment
                Payment::create([
                    'booking_id' => $booking->id,
                    'amount' => $totalPrice, // Use the final total price
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
            $booking = Booking::with(['car.brand', 'user', 'specifications'])->where('id', $payment->booking_id)->firstOrFail();

            // Ensure the booking has the payment amount as total_price
            if ($booking->total_price != $payment->amount) {
                $booking->update(['total_price' => $payment->amount]);
            }

            // Update payment and booking status
            $payment->update(['status' => 'successful']);
            $booking->update(['status' => 'confirmed']);

            // Create notification for booking confirmation
            $this->notificationService->createBookingNotification($booking, 'booking_confirmation');

            // Generate PDF
            $pdf = Pdf::loadView('pdf.booking-receipt', [
                'booking' => $booking,
                'payment' => $payment,
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

    // Helper method to calculate total price
    protected function calculateTotalPrice($bookingData)
    {
        // Calculate duration
        $startDate = \Carbon\Carbon::parse($bookingData['pickup_date']);
        $endDate = \Carbon\Carbon::parse($bookingData['return_date']);
        $durationDays = $startDate->diffInDays($endDate);

        // Get car and calculate base price
        $car = Car::with('insurance')->find($bookingData['car']['id']);
        $basePrice = $car->price_per_day * $durationDays;

        // Calculate specifications total (additional options)
        $additionalOptions = 0;
        if (isset($bookingData['specifications'])) {
            foreach ($bookingData['specifications'] as $spec) {
                $specification = Specification::find($spec['id']);
                if ($specification) {
                    $additionalOptions += $specification->price * ($spec['quantity'] ?? 1);
                }
            }
        }

        // Calculate insurance fee
        $insuranceFee = 0;
        if ($car->insurance) {
            $insuranceFee = $car->insurance->price_per_day * $durationDays;
        }

        // Service fee
        $serviceFee = 15.0;

        // Get promotion from database
        $promotion = \App\Models\Promotion::first();
        $promotionPercent = $promotion ? $promotion->discount_percent : 0;
        $promotionDiscount = ($basePrice * $promotionPercent) / 100;

        // Calculate total price using the same formula everywhere
        $totalPrice = round(
            $basePrice - $promotionDiscount + $insuranceFee + $serviceFee + $additionalOptions,
            2
        );

        // Update bookingData with all calculated values
        $bookingData['base_price'] = $basePrice;
        $bookingData['additional_options'] = $additionalOptions;
        $bookingData['insurance_fee'] = $insuranceFee;
        $bookingData['service_fee'] = $serviceFee;
        $bookingData['promotion_discount'] = $promotionDiscount;
        $bookingData['total_price'] = $totalPrice;
        $bookingData['duration_days'] = $durationDays;

        return $bookingData;
    }

    private function ensureAllFees(array $bookingData)
    {
        if (!isset($bookingData['insurance_fee'])) $bookingData['insurance_fee'] = 0;
        if (!isset($bookingData['service_fee'])) $bookingData['service_fee'] = 15.0;
        return $bookingData;
    }
}
