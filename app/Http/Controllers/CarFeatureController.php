<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarFeatureRequest;
use App\Http\Requests\UpdateCarFeatureRequest;
use App\Models\Car;
use App\Models\CarFeature;
use App\Models\Feature;
use Illuminate\Http\Request;

class CarFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carFeatures = CarFeature::with(['car', 'feature'])->paginate(10);
        return view('admin.car_features.index', compact('carFeatures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cars = Car::all();
        $features = Feature::all();

        return view('admin.car_features.create', compact('cars', 'features'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarFeatureRequest $request)
    {
        CarFeature::create($request->validated());

        return redirect()->route('car_features.index')
            ->with('success', 'Feature assigned to car successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CarFeature $carFeature)
    {
        return view('admin.car_features.show', compact('carFeature'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarFeature $carFeature)
    {
        $cars = Car::all();
        $features = Feature::all();

        return view('admin.car_features.edit', compact('carFeature', 'cars', 'features'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarFeatureRequest $request, CarFeature $carFeature)
    {
        $carFeature->update($request->validated());

        return redirect()->route('car_features.index')
            ->with('success', 'Car feature updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarFeature $carFeature)
    {
        $carFeature->delete();

        return redirect()->route('car_features.index')
            ->with('success', 'Car feature removed successfully.');
    }
}
