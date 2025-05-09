<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\StorereviewRequest;
use App\Http\Requests\UpdatereviewRequest;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        // Get all users and cars for the dropdown
        $users = User::all();  // Assuming you have a User model
        $cars = Car::all();    // Assuming you have a Car model

        return view('admin.reviews.create', compact('users', 'cars'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|exists:cars,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ], [
            'rating.required' => 'Please select a rating',
            'rating.min' => 'Please select a rating',
            'comment.required' => 'Please write a review',
            'comment.min' => 'Your review should be at least 10 characters long'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $review = new Review();
            $review->user_id = Auth::id();
            $review->car_id = $request->car_id;
            $review->rating = $request->rating;
            $review->comment = $request->comment;
            $review->save();

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your review!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving your review.'
            ], 500);
        }
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
