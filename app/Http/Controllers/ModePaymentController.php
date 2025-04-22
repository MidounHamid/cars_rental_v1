<?php

namespace App\Http\Controllers;

use App\Models\Mode_payment;
use App\Http\Requests\Storemode_paymentRequest;
use App\Http\Requests\Updatemode_paymentRequest;

class ModePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modePayments = Mode_payment::paginate(10);
        return view('admin.mode_payments.index', compact('modePayments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mode_payments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storemode_paymentRequest $request)
    {
        Mode_payment::create($request->validated());
        return redirect()->route('mode_payments.index')->with('success', 'Le mode de paiement a été créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mode_payment $mode_payment)
    {
        return view('admin.mode_payments.show', compact('mode_payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mode_payment $mode_payment)
    {
        return view('admin.mode_payments.edit', compact('mode_payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatemode_paymentRequest $request, Mode_payment $mode_payment)
    {
        $mode_payment->update($request->validated());
        return redirect()->route('mode_payments.index')->with('success', 'Le mode de paiement a été mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mode_payment $mode_payment)
    {
        $mode_payment->delete();
        return redirect()->route('mode_payments.index')->with('success', 'Le mode de paiement a été supprimé avec succès.');
    }
}
