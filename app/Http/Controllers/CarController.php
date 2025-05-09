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
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::with([
            'brand',
            'fuelType',
            'insurance',
            'carImages',
            'carType',
            'agency',
            'deliveryLocations',
            'reviews.user'
        ])->paginate(12);

        return view('admin.cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $carTypes = CarType::all();
        $fuelTypes = FuelType::all();
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
        $carTypes = CarType::all();
        $fuelTypes = FuelType::all();
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


    // public function clientHome()
    // {
    //     $cars = Car::with(['brand', 'carType', 'fuelType', 'agency', 'insurance'])
    //         ->with(['carImages' => function ($query) {
    //             $query->where('is_primary', true);
    //         }])
    //         ->paginate(6); // Show 6 cars per page (adjust number as needed)

    //     // No need to filter out cars with no primary image since we're using the eager loading above

    //     $brands = Brand::all();
    //     return view('client.home.home', compact('cars', 'brands'));
    // }

}
