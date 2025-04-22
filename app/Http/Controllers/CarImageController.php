<?php

namespace App\Http\Controllers;

use App\Models\car_image;
use Illuminate\Http\Request;

class CarImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carImages = car_image::with('car')->paginate(10);
        return view('admin.car_images.index', compact('carImages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.car_images.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $imagePath = $request->file('image_path')->store('car_images', 'public');

        car_image::create([
            'car_id' => $request->car_id,
            'image_path' => $imagePath,
            'is_primary' => $request->is_primary ?? false,
        ]);

        return redirect()->route('car_images.index')->with('success', 'L\'image de la voiture a été ajoutée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(car_image $car_image)
    {
        return view('admin.car_images.show', compact('car_image'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(car_image $car_image)
    {
        return view('admin.car_images.edit', compact('car_image'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, car_image $car_image)
    {
        $formFields = [
            'car_id' => $request->car_id,
            'is_primary' => $request->is_primary ?? false,
        ];

        if ($request->hasFile('image_path')) {
            $formFields['image_path'] = $request->file('image_path')->store('car_images', 'public');
        }

        $car_image->update($formFields);

        return redirect()->route('car_images.index')->with('success', 'L\'image de la voiture a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(car_image $car_image)
    {
        $car_image->delete();
        return redirect()->route('car_images.index')->with('success', 'L\'image de la voiture a été supprimée avec succès.');
    }
}
