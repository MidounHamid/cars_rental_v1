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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'nullable|unique:users',
            'driver_license' => 'nullable|unique:users',
            'address' => 'nullable',
            'image' => 'nullable|image|max:2048',
            'is_admin' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('users', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);

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
            'phone' => 'nullable|unique:users,phone,' . $user->id,
            'driver_license' => 'nullable|unique:users,driver_license,' . $user->id,
            'address' => 'nullable',
            'image' => 'nullable|image|max:2048',
            'is_admin' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($user->image) Storage::disk('public')->delete($user->image);
            $validated['image'] = $request->file('image')->store('users', 'public');
        }

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password); // Only update password if provided
        } else {
            unset($validated['password']); // Do not overwrite password if not provided
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->image) Storage::disk('public')->delete($user->image);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
