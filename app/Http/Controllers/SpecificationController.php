<?php

namespace App\Http\Controllers;

use App\Models\Specification;
use App\Http\Requests\StoreSpecificationRequest;
use App\Http\Requests\UpdateSpecificationRequest;

class SpecificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specifications = Specification::paginate(10);
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

    public function store(StoreSpecificationRequest $request)
    {
        Specification::create($request->validated());

        return redirect()->route('specifications.index')
            ->with('success', 'Specification created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Specification $specification)
    {
        return view('admin.specifications.show', compact('specification'));
    }
    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Specification $specification)
    {
        return view('admin.specifications.edit', compact('specification'));
    }
    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateSpecificationRequest $request, Specification $specification)
    {
        $specification->update($request->validated());

        return redirect()->route('specifications.index')
            ->with('success', 'Specification updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Specification $specification)
    {
        $specification->delete();

        return redirect()->route('specifications.index')
            ->with('success', 'Specification deleted successfully.');
    }
}
