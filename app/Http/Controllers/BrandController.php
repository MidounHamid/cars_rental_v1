<?php

namespace App\Http\Controllers;

use App\Models\brand;
use App\Http\Requests\StorebrandRequest;
use App\Http\Requests\UpdatebrandRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = brand::paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorebrandRequest $request)
    {
        brand::create($request->validated());
        return redirect()->route('brands.index')->with('success', 'La marque a été créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(brand $brand)
    {
        return view('admin.brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatebrandRequest $request, brand $brand)
    {
        $brand->update($request->validated());
        return redirect()->route('brands.index')->with('success', 'La marque a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(brand $brand)
    {
        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'La marque a été supprimée avec succès.');
    }
}
