<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Http\Requests\StoreagencieRequest;
use App\Http\Requests\UpdateagencieRequest;

class AgencieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agencies = Agency::paginate(10);
        return view('admin.agencies.index', compact('agencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.agencies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreagencieRequest $request)
    {
        $formFields = $request->validated();

        // Handle file upload for the logo
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Agency::create($formFields);

        return redirect()->route("agencies.index")->with("success", "Votre agence a été créée avec succès.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Agency $agency)
    {
        return view('admin.agencies.show', compact('agency'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agency $agency)
    {
        return view('admin.agencies.edit', compact('agency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateagencieRequest $request, Agency $agency)    {
        $formFields = $request->validated();

        // Handle file upload for the logo
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $agency->update($formFields);

        return redirect()->route("agencies.index")->with("success", "Votre agence a été mise à jour avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agency $agency)
    {
        $agency->delete();
        return redirect()->route("agencies.index")->with("success", "Votre agence a été supprimée avec succès.");
    }
}
