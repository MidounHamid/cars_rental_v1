<?php

namespace App\Http\Controllers\client;

use App\Models\Brand;
use App\Models\Car;
use App\Models\CarType;
use App\Models\FuelType;
use App\Models\Location;
use App\Models\Specification;
use Carbon\Carbon;
use Illuminate\Http\Request;


class HomeController
{
    public function index()
    {
        // Paginate the cars instead of fetching all and using take()
        $cars = Car::with(['brand', 'fuelType', 'carType']) // eager load if needed
            ->latest()
            ->paginate(6); // Paginate the results

        // Get all locations
        $locations = Location::orderBy('name')->get();

        return view('client.home.home', compact('cars', 'locations'));
    }

    public function carListing(Request $request)
    {
        $from = $request->input('from');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query = Car::query();
        $locations = Location::orderBy('name')->get();

        // Filter by delivery location
        if ($from) {
            $query->whereHas('deliveryLocations', function ($q) use ($from) {
                $q->where('name', 'like', '%' . $from . '%');
            });
        }

        // Filter by availability
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

        $cars = $query->paginate(10);

        return view('client.cars.listing', compact('cars', 'locations'));
    }

    public function carDetail($id)
    {
        $car = Car::with(['brand', 'fuelType', 'carType', 'specifications', 'carImages'])
            ->findOrFail($id);

        // Get related cars (same category or brand)
        $relatedCars = Car::where('car_type_id', $car->car_type_id)
            ->orWhere('brand_id', $car->brand_id)
            ->where('id', '!=', $car->id)
            ->take(2)
            ->get();

        return view('client.cars.cardetail', compact('car', 'relatedCars'));
    }
}
