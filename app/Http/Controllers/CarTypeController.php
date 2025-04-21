<?php

namespace App\Http\Controllers;

use App\Models\car_type;
use App\Http\Requests\Storecar_typeRequest;
use App\Http\Requests\Updatecar_typeRequest;

class CarTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storecar_typeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(car_type $car_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(car_type $car_type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatecar_typeRequest $request, car_type $car_type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(car_type $car_type)
    {
        //
    }
}
