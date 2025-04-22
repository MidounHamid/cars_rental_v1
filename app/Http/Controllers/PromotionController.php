<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Http\Requests\StorepromotionRequest;
use App\Http\Requests\UpdatepromotionRequest;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = Promotion::paginate(10);
        return view('admin.promotions.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.promotions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorepromotionRequest $request)
    {
        Promotion::create($request->validated());
        return redirect()->route('promotions.index')->with('success', 'La promotion a été créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        return view('admin.promotions.show', compact('promotion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepromotionRequest $request, Promotion $promotion)
    {
        $promotion->update($request->validated());
        return redirect()->route('promotions.index')->with('success', 'La promotion a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return redirect()->route('promotions.index')->with('success', 'La promotion a été supprimée avec succès.');
    }
}
