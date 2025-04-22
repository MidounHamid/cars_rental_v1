<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\StorereviewRequest;
use App\Http\Requests\UpdatereviewRequest;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with(['user', 'car'])->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.reviews.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorereviewRequest $request)
    {
        Review::create($request->validated());
        return redirect()->route('reviews.index')->with('success', 'L\'avis a été créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        return view('admin.reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatereviewRequest $request, Review $review)
    {
        $review->update($request->validated());
        return redirect()->route('reviews.index')->with('success', 'L\'avis a été mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('reviews.index')->with('success', 'L\'avis a été supprimé avec succès.');
    }
}
