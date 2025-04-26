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
use Carbon\Carbon;
use Illuminate\Http\Request;

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


    public function clientHome()
    {
        $cars = Car::with(['brand', 'carType', 'fuelType', 'agency', 'insurance'])
            ->with(['carImages' => function ($query) {
                $query->where('is_primary', true);
            }])
            ->get();

        // Filter out cars with no primary image (if necessary)
        foreach ($cars as $car) {
            $car->primaryImage = $car->carImages->first(); // Get the first primary image (if any)
        }

        $brands = Brand::all();
        return view('client.home.home', compact('cars', 'brands'));
    }
    public function carListing(Request $request)
    {
        // Fetch search inputs from the request
        $from = $request->input('from');
        $to = $request->input('to');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Query cars with filters
        $query = Car::query();

        if ($from) {
            // Use 'city' instead of 'location'
            $query->where('city', 'like', '%' . $from . '%');
        }


        if ($to) {
            // Assuming 'destination' is a column in the cars table
            $query->where('destination', 'like', '%' . $to . '%');
        }

        if ($start_date) {
            // Convert start_date to date format and filter
            $query->whereDate('available_from', '>=', Carbon::parse($start_date));
        }

        if ($end_date) {
            // Convert end_date to date format and filter
            $query->whereDate('available_to', '<=', Carbon::parse($end_date));
        }

        // Get the filtered cars with pagination
        $cars = $query->paginate(10);  // Adding pagination for better performance

        // Return the view with the filtered cars
        return view('client.cars.listing', compact('cars'));  // Use the correct view path
    }
}
