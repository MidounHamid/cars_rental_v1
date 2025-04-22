<?php

namespace App\Http\Controllers;

use App\Models\booking;
use App\Http\Requests\StorebookingRequest;
use App\Http\Requests\UpdatebookingRequest;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = booking::with(['user', 'car'])->paginate(10);
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

        booking::create($formFields);

        return redirect()->route('bookings.index')->with('success', 'La réservation a été créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(booking $booking)
    {
        return view('admin.bookings.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatebookingRequest $request, booking $booking)
    {
        $formFields = $request->validated();

        $booking->update($formFields);

        return redirect()->route('bookings.index')->with('success', 'La réservation a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'La réservation a été supprimée avec succès.');
    }
}
