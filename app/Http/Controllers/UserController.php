<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Show the form to create a new user
    public function create()
    {
        // Fetch all roles (Admin, HR, etc.) to show in the dropdown
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    // Save the new user and assign their role
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'exists:roles,name'], // Validate selected role
        ]);

        // 1. Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 2. Assign the chosen role
        $user->assignRole($request->role);

        // 3. Redirect back without logging out the current Admin
        return redirect()->back()->with('success', 'User created successfully with assigned role!');
    }
}
