<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required|string|unique:users',
            'age' => 'required|numeric|min:18',
            'driver_license' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'cin' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'address' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'is_admin' => 'required|boolean',
        ]);

        // Handling CIN upload
        if ($request->hasFile('cin')) {
            $validated['cin'] = $request->file('cin')->store('cin', 'public');
        }

        // Handling Driver License upload
        if ($request->hasFile('driver_license')) {
            $validated['driver_license'] = $request->file('driver_license')->store('driver_licenses', 'public');
        }

        // Handling Image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('users', 'public');
        }

        // Hashing the password
        $validated['password'] = Hash::make($validated['password']);

        // Create the user with the validated data
        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'age' => 'nullable|numeric|min:18',
            'driver_license' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
            'cin' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
            'address' => 'nullable',
            'image' => 'nullable|image|max:2048',
            'is_admin' => 'required|boolean',
        ]);

        // Handle CIN image
        if ($request->hasFile('cin')) {
            if ($user->cin) Storage::disk('public')->delete($user->cin);
            $validated['cin'] = $request->file('cin')->store('cin', 'public');
        } elseif ($request->has('remove_cin') && $request->remove_cin) {
            if ($user->cin) Storage::disk('public')->delete($user->cin);
            $validated['cin'] = null;
        }

        // Handle Driver License image
        if ($request->hasFile('driver_license')) {
            if ($user->driver_license) Storage::disk('public')->delete($user->driver_license);
            $validated['driver_license'] = $request->file('driver_license')->store('driver_licenses', 'public');
        } elseif ($request->has('remove_driver_license') && $request->remove_driver_license) {
            if ($user->driver_license) Storage::disk('public')->delete($user->driver_license);
            $validated['driver_license'] = null;
        }

        // Handle profile image
        if ($request->hasFile('image')) {
            if ($user->image) Storage::disk('public')->delete($user->image);
            $validated['image'] = $request->file('image')->store('users', 'public');
        } elseif ($request->has('remove_image') && $request->remove_image) {
            if ($user->image) Storage::disk('public')->delete($user->image);
            $validated['image'] = null;
        }

        // Handle password update
        if ($request->filled('password') && $request->password !== 'null') {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        // Update the user with the validated data
        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Delete associated files
        if ($user->image) Storage::disk('public')->delete($user->image);
        if ($user->cin) Storage::disk('public')->delete($user->cin);
        if ($user->driver_license) Storage::disk('public')->delete($user->driver_license);

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
