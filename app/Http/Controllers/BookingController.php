<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Http\Requests\StorebookingRequest;
use App\Http\Requests\UpdatebookingRequest;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'car'])->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.bookings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorebookingRequest $request)
    {
        $formFields = $request->validated();

        Booking::create($formFields);

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
    public function edit(Booking $booking)
    {
        return view('admin.bookings.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatebookingRequest $request, Booking $booking)
    {
        $formFields = $request->validated();

        $booking->update($formFields);

        return redirect()->route('bookings.index')->with('success', 'La réservation a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'La réservation a été supprimée avec succès.');
    }
}
