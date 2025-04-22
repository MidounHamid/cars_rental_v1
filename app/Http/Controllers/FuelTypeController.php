<?php

namespace App\Http\Controllers;

use App\Models\Fuel_type;
use App\Http\Requests\Storefuel_typeRequest;
use App\Http\Requests\Updatefuel_typeRequest;

class FuelTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fuelTypes = Fuel_type::paginate(10);
        return view('admin.fuel_types.index', compact('fuelTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fuel_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storefuel_typeRequest $request)
    {
        Fuel_type::create($request->validated());
        return redirect()->route('fuel_types.index')->with('success', 'Le type de carburant a été créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fuel_type $fuel_type)
    {
        return view('admin.fuel_types.show', compact('fuel_type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fuel_type $fuel_type)
    {
        return view('admin.fuel_types.edit', compact('fuel_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatefuel_typeRequest $request, Fuel_type $fuel_type)
    {
        $fuel_type->update($request->validated());
        return redirect()->route('fuel_types.index')->with('success', 'Le type de carburant a été mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fuel_type $fuel_type)
    {
        $fuel_type->delete();
        return redirect()->route('fuel_types.index')->with('success', 'Le type de carburant a été supprimé avec succès.');
    }
}
