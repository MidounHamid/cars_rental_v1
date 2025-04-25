<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storecar_typeRequest;
use App\Http\Requests\Updatecar_typeRequest;
use App\Models\CarType;

class CarTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carTypes = CarType::paginate(10);
        return view('admin.car_types.index', compact('carTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.car_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storecar_typeRequest $request)
    {
        CarType::create($request->validated());
        return redirect()->route('car_types.index')->with('success', 'Le type de voiture a été créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CarType $carType)
    {
        return view('admin.car_types.show', compact('carType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarType $carType)
    {
        return view('admin.car_types.edit', compact('carType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatecar_typeRequest $request, CarType $carType)
    {
        $carType->update($request->validated());
        return redirect()->route('car_types.index')->with('success', 'Le type de voiture a été mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarType $carType)
    {
        $carType->delete();
        return redirect()->route('car_types.index')->with('success', 'Le type de voiture a été supprimé avec succès.');
    }
}
