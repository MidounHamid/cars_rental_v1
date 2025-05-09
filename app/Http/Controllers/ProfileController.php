<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Booking;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(Request $request): View
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's reservations.
     */
    public function reservations(Request $request): View
    {
        $reservations = Booking::where('user_id', $request->user()->id)
            ->with('car')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.reservations', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        // Handle driver license upload
        if ($request->hasFile('driver_license')) {
            $driverLicensePath = $request->file('driver_license')->store('driver_licenses', 'public');
            $data['driver_license'] = $driverLicensePath;
        }

        // Handle CIN upload
        if ($request->hasFile('cin')) {
            $cinPath = $request->file('cin')->store('cin', 'public');
            $data['cin'] = $cinPath;
        }

        // Handle profile image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_images', 'public');
            $data['image'] = $imagePath;
        }

        $request->user()->fill($data);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Redirection vers la page de profil au lieu de la page d'édition
        return Redirect::route('profile.show')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
