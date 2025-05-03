<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Car;
use App\Models\Promotion;
use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'car', 'promotion'])->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $cars = Car::all();
        $promotions = Promotion::where('expires_at', '>', now())
            ->where('starts_at', '<=', now())
            ->get();

        return view('admin.bookings.create', compact('users', 'cars', 'promotions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        $formFields = $request->validated();

        // Handle empty promotion
        if (empty($formFields['promotion_id'])) {
            $formFields['promotion_id'] = null;
        }

        // Calculate final price if promotion exists
        if ($formFields['promotion_id']) {
            $promotion = Promotion::find($formFields['promotion_id']);
            $formFields['total_price'] = $formFields['total_price'] * (1 - ($promotion->discount_percent / 100));
        }

        // Create the booking
        $booking = Booking::create($formFields);

        // Set the car as unavailable
        $car = Car::find($formFields['car_id']);
        $car->is_available = false;
        $car->save();

        return redirect()->route('bookings.index')->with('success', 'La réservation a été créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $booking = Booking::with('promotion')->findOrFail($id);
        $users = User::all();
        $cars = Car::all();
        $promotions = Promotion::where('expires_at', '>', now())
            ->where('starts_at', '<=', now())
            ->get();

        return view('admin.bookings.edit', compact('booking', 'users', 'cars', 'promotions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $formFields = $request->validated();

        // Handle empty promotion
        if (empty($formFields['promotion_id'])) {
            $formFields['promotion_id'] = null;
        }

        // Recalculate price if promotion changed
        if ($formFields['promotion_id'] != $booking->promotion_id) {
            if ($formFields['promotion_id']) {
                $promotion = Promotion::find($formFields['promotion_id']);
                $formFields['total_price'] = $formFields['total_price'] * (1 - ($promotion->discount_percent / 100));
            } else {
                // Revert to original price if promotion removed
                $formFields['total_price'] = $booking->car->price * Carbon::parse($formFields['end_date'])
                    ->diffInDays(Carbon::parse($formFields['start_date']));
            }
        }

        $booking->update($formFields);

        return redirect()->route('bookings.index')->with('success', 'La réservation a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        // Set the car as available again
        $car = Car::find($booking->car_id);
        $car->is_available = true;
        $car->save();

        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'La réservation a été supprimée avec succès.');
    }
}
