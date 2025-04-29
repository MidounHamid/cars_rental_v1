<?php

namespace App\Http\Controllers\client;

use App\Models\Car;
use App\Models\Location;

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
}
