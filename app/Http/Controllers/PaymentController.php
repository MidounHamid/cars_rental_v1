<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Mode_payment;
use App\Models\Payment;
use App\Http\Requests\StorepaymentRequest;
use App\Http\Requests\UpdatepaymentRequest;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with(['booking', 'modePayment'])->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all bookings and mode payments to populate the dropdowns
        $bookings = Booking::all(); // Make sure you have a Booking model
        $modePayments = Mode_payment::all(); // Ensure you have a ModePayment model

        return view('admin.payments.create', compact('bookings', 'modePayments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorepaymentRequest $request)
    {
        Payment::create($request->validated());
        return redirect()->route('payments.index')->with('success', 'Le paiement a été créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $bookings = Booking::all();
        $modePayments = Mode_payment::all(); // Fetch all payment modes
        return view('admin.payments.edit', compact('payment', 'modePayments', 'bookings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepaymentRequest $request, Payment $payment)
    {
        $payment->update($request->validated());
        return redirect()->route('payments.index')->with('success', 'Le paiement a été mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Le paiement a été supprimé avec succès.');
    }
}
