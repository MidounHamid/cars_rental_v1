<?php

namespace App\Http\Controllers;

use App\Models\specification;
use App\Http\Requests\StorespecificationRequest;
use App\Http\Requests\UpdatespecificationRequest;

class SpecificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specifications = specification::paginate(10);
        return view('admin.specifications.index', compact('specifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.specifications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorespecificationRequest $request)
    {
        specification::create($request->validated());
        return redirect()->route('specifications.index')->with('success', 'La spécification a été créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(specification $specification)
    {
        return view('admin.specifications.show', compact('specification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(specification $specification)
    {
        return view('admin.specifications.edit', compact('specification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatespecificationRequest $request, specification $specification)
    {
        $specification->update($request->validated());
        return redirect()->route('specifications.index')->with('success', 'La spécification a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(specification $specification)
    {
        $specification->delete();
        return redirect()->route('specifications.index')->with('success', 'La spécification a été supprimée avec succès.');
    }
}
