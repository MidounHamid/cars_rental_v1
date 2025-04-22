<?php

namespace App\Http\Controllers;

use App\Models\insurance;
use App\Http\Requests\StoreinsuranceRequest;
use App\Http\Requests\UpdateinsuranceRequest;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $insurances = insurance::paginate(10);
        return view('admin.insurances.index', compact('insurances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.insurances.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreinsuranceRequest $request)
    {
        insurance::create($request->validated());
        return redirect()->route('insurances.index')->with('success', 'L\'assurance a été créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(insurance $insurance)
    {
        return view('admin.insurances.show', compact('insurance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(insurance $insurance)
    {
        return view('admin.insurances.edit', compact('insurance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateinsuranceRequest $request, insurance $insurance)
    {
        $insurance->update($request->validated());
        return redirect()->route('insurances.index')->with('success', 'L\'assurance a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(insurance $insurance)
    {
        $insurance->delete();
        return redirect()->route('insurances.index')->with('success', 'L\'assurance a été supprimée avec succès.');
    }
}
