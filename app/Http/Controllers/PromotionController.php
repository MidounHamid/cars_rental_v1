<?php

namespace App\Http\Controllers;

use App\Models\promotion;
use App\Http\Requests\StorepromotionRequest;
use App\Http\Requests\UpdatepromotionRequest;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = promotion::paginate(10);
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
        promotion::create($request->validated());
        return redirect()->route('promotions.index')->with('success', 'La promotion a été créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(promotion $promotion)
    {
        return view('admin.promotions.show', compact('promotion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(promotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepromotionRequest $request, promotion $promotion)
    {
        $promotion->update($request->validated());
        return redirect()->route('promotions.index')->with('success', 'La promotion a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(promotion $promotion)
    {
        $promotion->delete();
        return redirect()->route('promotions.index')->with('success', 'La promotion a été supprimée avec succès.');
    }
}
