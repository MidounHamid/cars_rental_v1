<?php

namespace App\Http\Controllers;

use App\Models\agencie;
use App\Http\Requests\StoreagencieRequest;
use App\Http\Requests\UpdateagencieRequest;

class AgencieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agencies = agencie::paginate(10);
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

        agencie::create($formFields);

        return redirect()->route("agencies.index")->with("success", "Votre agence a été créée avec succès.");
    }

    /**
     * Display the specified resource.
     */
    public function show(agencie $agencie)
    {
        return view('admin.agencies.show', compact('agencie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(agencie $agencie)
    {
        return view('admin.agencies.edit', compact('agencie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateagencieRequest $request, agencie $agencie)
    {
        $formFields = $request->validated();

        // Handle file upload for the logo
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $agencie->update($formFields);

        return redirect()->route("agencies.index")->with("success", "Votre agence a été mise à jour avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(agencie $agencie)
    {
        $agencie->delete();
        return redirect()->route("agencies.index")->with("success", "Votre agence a été supprimée avec succès.");
    }
}
