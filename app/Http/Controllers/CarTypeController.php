<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storecar_typeRequest;
use App\Http\Requests\Updatecar_typeRequest;
use App\Models\car_type;

class CarTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carTypes = car_type::paginate(10);
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
        car_type::create($request->validated());
        return redirect()->route('car_types.index')->with('success', 'Le type de voiture a été créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(car_type $carType)
    {
        return view('admin.car_types.show', compact('carType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(car_type $carType)
    {
        return view('admin.car_types.edit', compact('carType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatecar_typeRequest $request, car_type $carType)
    {
        $carType->update($request->validated());
        return redirect()->route('car_types.index')->with('success', 'Le type de voiture a été mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(car_type $carType)
    {
        $carType->delete();
        return redirect()->route('car_types.index')->with('success', 'Le type de voiture a été supprimé avec succès.');
    }
}
