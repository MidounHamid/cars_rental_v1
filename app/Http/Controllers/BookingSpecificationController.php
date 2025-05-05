<?php

namespace App\Http\Controllers;

use App\Models\BookingSpecification;
use App\Models\Booking;
use App\Models\Specification;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookingSpecificationRequest;
use App\Http\Requests\UpdateBookingSpecificationRequest;

class BookingSpecificationController extends Controller
{
    public function index()
    {
        $bookingSpecifications = BookingSpecification::with(['booking', 'specification'])->paginate(10);
        return view('admin.booking_specifications.index', compact('bookingSpecifications'));
    }

    public function create()
    {
        $bookings = Booking::all();
        $specifications = Specification::all();
        return view('admin.booking_specifications.create', compact('bookings', 'specifications'));
    }

    public function store(StoreBookingSpecificationRequest $request)
    {
        BookingSpecification::create($request->validated());

        return redirect()->route('booking_specifications.index')
            ->with('success', 'Booking specification created successfully.');
    }

    public function show(BookingSpecification $bookingSpecification)
    {
        return view('admin.booking_specifications.show', compact('bookingSpecification'));
    }

    public function edit(BookingSpecification $bookingSpecification)
    {
        $bookings = Booking::all();
        $specifications = Specification::all();
        return view('admin.booking_specifications.edit', compact('bookingSpecification', 'bookings', 'specifications'));
    }

    public function update(UpdateBookingSpecificationRequest $request, BookingSpecification $bookingSpecification)
    {
        $bookingSpecification->update($request->validated());

        return redirect()->route('booking_specifications.index')
            ->with('success', 'Booking specification updated successfully.');
    }

    public function destroy(BookingSpecification $bookingSpecification)
    {
        $bookingSpecification->delete();

        return redirect()->route('booking_specifications.index')
            ->with('success', 'Booking specification deleted successfully.');
    }
}
