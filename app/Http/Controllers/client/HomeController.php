<?php
namespace App\Http\Controllers\client;

use App\Models\Car;

class HomeController
{
    public function index()
    {
        $cars = Car::with(['brand', 'fuelType', 'carType']) // eager load if needed
                    ->latest()
                    ->take(6) // or however many you want
                    ->get();

        return view('client.home.home', compact('cars'));
    }
}
