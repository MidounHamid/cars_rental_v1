<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Car;
use App\Models\CarType;
use App\Models\FuelType;
use App\Models\Location;
use App\Models\Feature; // Assuming Feature model is created for the 'features' field
use App\Models\Specification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Livewire;

class HomeController extends Controller
{
    public function index()
    {
        // Paginate the cars instead of fetching all and using take()
        $cars = Car::with(['brand', 'fuelType', 'carType', 'carImages', 'features']) // updated to features
            // ->where('is_available', true)
            // ->latest()
            ->paginate(6);

        // Get all locations
        $locations = Location::orderBy('name')->get();

        return view('client.home.home', compact('cars', 'locations'));
    }

    public function carListing(Request $request)
    {
        // Get search parameters
        $pickup_location = $request->input('pickup_location');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Start building the query
        $query = Car::with(['brand', 'fuelType', 'carType', 'carImages', 'features']); // updated to features

        // Get locations for the search form
        $locations = Location::orderBy('name')->get();

        // For filtering data in the view
        $fuelTypes = FuelType::orderBy('fuel_type')->get();
        $carTypes = CarType::orderBy('name')->get();
        $brands = Brand::orderBy('brand')->get();

        // Filter by delivery location
        if ($pickup_location) {
            $query->whereHas('deliveryLocations', function ($q) use ($pickup_location) {
                $q->where('locations.id', $pickup_location); // ← Explicit table name
            });
        }



        // Filter by availability based on dates
        if ($start_date && $end_date) {
            $start = Carbon::parse($start_date);
            $end = Carbon::parse($end_date);

            $query->whereDoesntHave('bookings', function ($q) use ($start, $end) {
                $q->where(function ($subQuery) use ($start, $end) {
                    $subQuery->whereDate('start_date', '<=', $end)
                        ->whereDate('end_date', '>=', $start);
                });
            });
        }

        // Additional filters that could be added via GET parameters
        if ($request->has('brand')) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('brand', $request->brand);
            });
        }

        if ($request->has('car_type')) {
            $query->where('car_type_id', $request->car_type);
        }

        if ($request->has('fuel_type')) {
            $query->where('fuel_type_id', $request->fuel_type);
        }

        // Get the filtered cars
        $cars = $query->paginate(10)->appends($request->all());

        // Pass search parameters to the view for maintaining state
        $searchParams = [
            'pickup_location' => $pickup_location,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];

        return view('client.cars.listing', compact(
            'cars',
            'locations',
            'fuelTypes',
            'carTypes',
            'brands',
            'searchParams'
        ));
    }

    public function carDetail($id)
    {
        $car = Car::with(['brand', 'fuelType', 'carType', 'features', 'carImages'])
            ->findOrFail($id);

        // Get related cars (same category or brand)
        $relatedCars = Car::where('car_type_id', $car->car_type_id)
            ->orWhere('brand_id', $car->brand_id)
            ->where('id', '!=', $car->id)
            ->take(3)
            ->get();

        // Get specifications for the calculator
        $specifications = Specification::all();

        return view('client.cars.cardetail', compact('car', 'relatedCars', 'specifications'));
    }
}
