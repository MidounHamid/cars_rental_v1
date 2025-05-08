<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Car;
use App\Models\Promotion;
use App\Models\Booking;
use App\Models\Specification;
use App\Services\NotificationService;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use Carbon\Carbon;

class BookingController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'car', 'car.brand', 'promotion'])->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $cars = Car::where('is_available', true)->get();
        $promotions = Promotion::where('expires_at', '>', now())
            ->where('starts_at', '<=', now())
            ->get();
        $specifications = Specification::all();

        return view('admin.bookings.create', compact('users', 'cars', 'promotions', 'specifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        $formFields = $request->validated();

        // Ensure start_time and end_time are included
        if (!isset($formFields['start_time']) || empty($formFields['start_time'])) {
            return redirect()->back()->withErrors(['start_time' => 'Start time is required'])->withInput();
        }

        if (!isset($formFields['end_time']) || empty($formFields['end_time'])) {
            return redirect()->back()->withErrors(['end_time' => 'End time is required'])->withInput();
        }

        // Handle empty promotion
        if (empty($formFields['promotion_id']) || $formFields['promotion_id'] === "null") {
            $formFields['promotion_id'] = null;
        }

        // Create the booking
        $booking = Booking::create($formFields);

        // Handle specifications if present
        if (isset($formFields['specifications'])) {
            foreach ($formFields['specifications'] as $specId => $spec) {
                if (isset($spec['selected'])) {
                    $booking->specifications()->attach($specId, [
                        'quantity' => $spec['quantity'] ?? 1,
                        'price' => $spec['price'] ?? 0
                    ]);
                }
            }
        }

        // Set the car as unavailable
        $car = Car::find($formFields['car_id']);
        if ($car) {
            $car->is_available = false;
            $car->save();
        }

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'car', 'car.brand', 'promotion', 'specifications']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $booking = Booking::with(['promotion', 'specifications'])->findOrFail($id);
        $users = User::all();
        // Include the current car in the selection, even if not available
        $availableCars = Car::where('is_available', true)->orWhere('id', $booking->car_id)->get();
        $promotions = Promotion::where('expires_at', '>', now())
            ->where('starts_at', '<=', now())
            ->get();
        $specifications = Specification::all();

        return view('admin.bookings.edit', compact('booking', 'users', 'availableCars', 'promotions', 'specifications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $formFields = $request->validated();

        // Ensure start_time and end_time are included
        if (!isset($formFields['start_time']) || empty($formFields['start_time'])) {
            return redirect()->back()->withErrors(['start_time' => 'Start time is required'])->withInput();
        }

        if (!isset($formFields['end_time']) || empty($formFields['end_time'])) {
            return redirect()->back()->withErrors(['end_time' => 'End time is required'])->withInput();
        }

        // Handle empty promotion
        if (empty($formFields['promotion_id']) || $formFields['promotion_id'] === "null") {
            $formFields['promotion_id'] = null;
        }

        // Check if car has changed
        $carChanged = $booking->car_id != $formFields['car_id'];
        $oldCarId = $booking->car_id;

        // Check if status has changed
        $statusChanged = $booking->status != $formFields['status'];

        // Update the booking
        $booking->update($formFields);

        // Handle specifications
        if (isset($formFields['specifications'])) {
            // Detach existing specifications
            $booking->specifications()->detach();

            // Attach new specifications
            foreach ($formFields['specifications'] as $specId => $spec) {
                if (isset($spec['selected'])) {
                    $booking->specifications()->attach($specId, [
                        'quantity' => $spec['quantity'] ?? 1,
                        'price' => $spec['price'] ?? 0
                    ]);
                }
            }
        }

        // Update car availability if car has changed
        if ($carChanged) {
            // Set old car as available
            $oldCar = Car::find($oldCarId);
            if ($oldCar) {
                $oldCar->is_available = true;
                $oldCar->save();
            }

            // Set new car as unavailable
            $newCar = Car::find($formFields['car_id']);
            if ($newCar) {
                $newCar->is_available = false;
                $newCar->save();
            }
        }

        // Create notification if status has changed
        if ($statusChanged) {
            $this->notificationService->createBookingNotification($booking, 'booking_' . $formFields['status']);
        }

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        // Set the car as available again
        $car = Car::find($booking->car_id);
        if ($car) {
            $car->is_available = true;
            $car->save();
        }

        // Create notification for cancellation
        $this->notificationService->createBookingNotification($booking, 'booking_cancellation');

        // Detach specifications
        $booking->specifications()->detach();

        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
    }
}
