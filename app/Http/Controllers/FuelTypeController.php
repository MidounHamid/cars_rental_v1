<?php

namespace App\Http\Controllers;

use App\Models\fuel_type;
use App\Http\Requests\Storefuel_typeRequest;
use App\Http\Requests\Updatefuel_typeRequest;

class FuelTypeController extends Controller
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
    public function store(Storefuel_typeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(fuel_type $fuel_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(fuel_type $fuel_type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatefuel_typeRequest $request, fuel_type $fuel_type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(fuel_type $fuel_type)
    {
        //
    }
}
