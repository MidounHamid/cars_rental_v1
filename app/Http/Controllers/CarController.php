<?php

namespace App\Http\Controllers;
use App\Models\CarType;
use App\Models\FuelType;
use App\Models\Agency;
use App\Models\Brand;
use App\Models\Insurance;
use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car_type;
use App\Models\Fuel_type;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::with(['carType', 'fuelType', 'agency', 'brand', 'insurance'])->paginate(10);
        return view('admin.cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $carTypes = Car_type::all();
        $fuelTypes = Fuel_type::all();
        $agencies = Agency::all();
        $brands = Brand::all();
        $insurances = Insurance::all();

        return view('admin.cars.create', compact('carTypes', 'fuelTypes', 'agencies', 'brands', 'insurances'));
    }
        
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {
        Car::create($request->validated());
        return redirect()->route('cars.index')->with('success', 'La voiture a été créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return view('admin.cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {         
              $carTypes = Car_type::all();
              $fuelTypes = Fuel_type::all();
              $agencies = Agency::all();
              $brands = Brand::all();
              $insurances = Insurance::all();
    
             return view('admin.cars.edit', compact('car', 'carTypes', 'fuelTypes', 'agencies', 'brands', 'insurances'));
            
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        $car->update($request->validated());
        return redirect()->route('cars.index')->with('success', 'La voiture a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('cars.index')->with('success', 'La voiture a été supprimée avec succès.');
    }
}
