<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Car_image;
use Illuminate\Http\Request;

class CarImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carImages = Car_image::with('car')->paginate(10);
        return view('admin.car_images.index', compact('carImages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cars = Car::all();
        return view('admin.car_images.create', compact('cars'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if the checkbox for 'is_primary' is checked and convert it to integer (1 for true, 0 for false)
        $isPrimary = $request->has('is_primary') ? 1 : 0;

        // Store the image file
        $imagePath = $request->file('image_path')->store('car_images', 'public');

        // Create the Car_image record
        Car_image::create([
            'car_id' => $request->car_id,
            'image_path' => $imagePath,
            'is_primary' => $isPrimary,  // Use the converted value
        ]);

        return redirect()->route('car_images.index')->with('success', 'L\'image de la voiture a été ajoutée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car_image $car_image)
    {
        return view('admin.car_images.show', compact('car_image'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car_image $car_image)
    {
        $cars = Car::all();
        return view('admin.car_images.edit', compact('car_image', 'cars'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car_image $car_image)
    {
        // Prepare the fields to update
        $formFields = [
            'car_id' => $request->car_id,
            'is_primary' => $request->has('is_primary') ? 1 : 0, // Convert checkbox value
        ];

        // If there's a new image, store it
        if ($request->hasFile('image_path')) {
            $formFields['image_path'] = $request->file('image_path')->store('car_images', 'public');
        }

        // Update the Car_image record
        $car_image->update($formFields);

        return redirect()->route('car_images.index')->with('success', 'L\'image de la voiture a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car_image $car_image)
    {
        $car_image->delete();
        return redirect()->route('car_images.index')->with('success', 'L\'image de la voiture a été supprimée avec succès.');
    }
}
