<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Car_image;
use App\Models\CarImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carImages = CarImage::with('car')
            ->where('is_primary', true)
            ->get();

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
        // Check if the checkbox for 'is_primary' is checked
        $isPrimary = $request->has('is_primary') ? 1 : 0;

        // Start a database transaction
        DB::beginTransaction();

        try {
            // If this image is set as primary, update all other images for this car to non-primary
            if ($isPrimary) {
                CarImage::where('car_id', $request->car_id)
                    ->where('is_primary', 1)
                    ->update(['is_primary' => 0]);
            }

            // Store the image file
            $imagePath = $request->file('image_path')->store('car_images', 'public');

            // Create the Car_image record
            CarImage::create([
                'car_id' => $request->car_id,
                'image_path' => $imagePath,
                'is_primary' => $isPrimary,
            ]);

            // Commit the transaction
            DB::commit();

            return redirect()->route('car_images.index')->with('success', 'L\'image de la voiture a été ajoutée avec succès.');
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CarImage $car_image)
    {
        return view('admin.car_images.show', compact('car_image'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarImage $car_image)
    {
        $cars = Car::all();
        return view('admin.car_images.edit', compact('car_image', 'cars'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarImage $car_image)
    {
        // Prepare the fields to update
        $formFields = [
            'car_id' => $request->car_id,
            'is_primary' => $request->has('is_primary') ? 1 : 0, // Convert checkbox value
        ];

        // Start a database transaction
        DB::beginTransaction();

        try {
            // If this image is being set as primary and it wasn't primary before,
            // or if the car_id has changed and it's marked as primary,
            // then update all other images for this car to non-primary
            if ($formFields['is_primary'] == 1 &&
                ($car_image->is_primary == 0 || $car_image->car_id != $formFields['car_id'])) {
                CarImage::where('car_id', $formFields['car_id'])
                    ->where('id', '!=', $car_image->id)
                    ->where('is_primary', 1)
                    ->update(['is_primary' => 0]);
            }

            // If there's a new image, store it
            if ($request->hasFile('image_path')) {
                $formFields['image_path'] = $request->file('image_path')->store('car_images', 'public');
            }

            // Update the Car_image record
            $car_image->update($formFields);

            // Commit the transaction
            DB::commit();

            return redirect()->route('car_images.index')->with('success', 'L\'image de la voiture a été mise à jour avec succès.');
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarImage $car_image)
    {
        $car_image->delete();
        return redirect()->route('car_images.index')->with('success', 'L\'image de la voiture a été supprimée avec succès.');
    }

    public function showByCar($carId)
    {
        $car = Car::findOrFail($carId);
        $images = CarImage::where('car_id', $carId)->get();

        return view('admin.car_images.by_car', compact('car', 'images'));
    }
}
