<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarDeliveryLocationRequest;
use App\Http\Requests\UpdateCarDeliveryLocationRequest;
use App\Models\CarDeliveryLocation;
use App\Models\Car;
use App\Models\Location;

class CarDeliveryLocationController extends Controller
{
    public function index()
    {
        // Eager load car and location relationships for better performance
        $carDeliveries = CarDeliveryLocation::with(['car', 'location'])->get();

        return view('admin.car_delivery_locations.index', compact('carDeliveries'));
    }

    public function create()
    {
        // Retrieve cars and locations for dropdown options
        $cars = Car::all();
        $locations = Location::all();

        return view('admin.car_delivery_locations.create', compact('cars', 'locations'));
    }

    public function store(StoreCarDeliveryLocationRequest $request)
    {
        // Create a new CarDeliveryLocation using Eloquent
        CarDeliveryLocation::create([
            'car_id' => $request->car_id,
            'location_id' => $request->location_id,
        ]);

        return redirect()->route('car_delivery_locations.index')->with('success', 'Delivery location assigned.');
    }

    public function show($id)
    {
        // Retrieve a single CarDeliveryLocation with its car and location
        $carDelivery = CarDeliveryLocation::with(['car', 'location'])->findOrFail($id);

        return view('admin.car_delivery_locations.show', compact('carDelivery'));
    }

    public function edit($id)
    {
        // Retrieve a single delivery location with cars and locations
        $delivery = CarDeliveryLocation::findOrFail($id);
        $cars = Car::all();
        $locations = Location::all();

        return view('admin.car_delivery_locations.edit', compact('delivery', 'cars', 'locations'));
    }

    public function update(UpdateCarDeliveryLocationRequest $request, $id)
    {
        // Find and update the CarDeliveryLocation using Eloquent
        $delivery = CarDeliveryLocation::findOrFail($id);
        $delivery->update([
            'car_id' => $request->car_id,
            'location_id' => $request->location_id,
        ]);

        return redirect()->route('car_delivery_locations.index')->with('success', 'Delivery location updated.');
    }

    public function destroy($id)
    {
        // Delete a CarDeliveryLocation using Eloquent
        $delivery = CarDeliveryLocation::findOrFail($id);
        $delivery->delete();

        return redirect()->route('car_delivery_locations.index')->with('success', 'Delivery location deleted.');
    }
}
