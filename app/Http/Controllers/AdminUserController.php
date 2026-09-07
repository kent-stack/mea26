<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function setup()
    {
        abort_if(User::query()->exists(), 404);

        return view('auth.setup');
    }

    public function storeSetup(Request $request)
    {
        abort_if(User::query()->exists(), 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', 'alpha_dash', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'password' => $validated['password'],
            'is_admin' => true,
            'is_superadmin' => true,
        ]);

        auth()->login($user);

        return redirect()->route('admin.users.create');
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', 'alpha_dash', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:participant,admin'],
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'password' => $validated['password'],
            'is_admin' => $validated['role'] === 'admin',
        ]);

        return redirect()->route('admin.users.create')->with('success', 'User created successfully.');
    }
}