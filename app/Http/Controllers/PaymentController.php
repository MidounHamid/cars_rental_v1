<?php

namespace App\Http\Controllers;

use App\Models\payment;
use App\Http\Requests\StorepaymentRequest;
use App\Http\Requests\UpdatepaymentRequest;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = payment::with(['booking', 'modePayment'])->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.payments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorepaymentRequest $request)
    {
        payment::create($request->validated());
        return redirect()->route('payments.index')->with('success', 'Le paiement a été créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(payment $payment)
    {
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(payment $payment)
    {
        return view('admin.payments.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepaymentRequest $request, payment $payment)
    {
        $payment->update($request->validated());
        return redirect()->route('payments.index')->with('success', 'Le paiement a été mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Le paiement a été supprimé avec succès.');
    }
}
