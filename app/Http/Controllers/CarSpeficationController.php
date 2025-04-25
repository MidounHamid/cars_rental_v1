<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storecar_speficationRequest;
use App\Http\Requests\Updatecar_speficationRequest;
use App\Models\Car_spefication;
use App\Models\Car;
use App\Models\CarSpefication;
use App\Models\Specification;
use Illuminate\Http\Request;

class CarSpeficationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carSpecifications = CarSpefication::with(['car', 'specification'])->paginate(10);
        return view('admin.car_spefications.index', compact('carSpecifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch the collections needed for dropdowns
        $cars = Car::all();
        $specifications = Specification::all();

        return view('admin.car_spefications.create', compact('cars', 'specifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storecar_speficationRequest $request)
    {
        CarSpefication::create($request->validated());

        return redirect()->route('car_spefications.index')
            ->with('success', 'La spécification de la voiture a été ajoutée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CarSpefication $car_spefication)
    {
        return view('admin.car_spefications.show', compact('car_spefication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarSpefication $car_spefication)
    {
        // Again, pass the needed collections for the dropdowns
        $cars = Car::all();
        $specifications = Specification::all();

        return view('admin.car_spefications.edit', compact('car_spefication', 'cars', 'specifications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatecar_speficationRequest $request, CarSpefication $car_spefication)
    {
        $car_spefication->update($request->validated());

        return redirect()->route('car_spefications.index')
            ->with('success', 'La spécification de la voiture a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarSpefication $car_spefication)
    {
        $car_spefication->delete();

        return redirect()->route('car_spefications.index')
            ->with('success', 'La spécification de la voiture a été supprimée avec succès.');
    }
}
