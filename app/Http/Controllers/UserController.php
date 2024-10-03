<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::all();

        $users = User::where('name', 'like', "%{$request->search}%")
            ->orWhere('last_name', 'like', "%{$request->search}%")
            ->orWhere('email', 'like', "%{$request->search}%")
            ->paginate(10);

        return view('users.index', compact('users', 'roles'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');

        $user->syncRoles($request->input('role'));

        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }
    public function updatePhoto(Request $request, $id)
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($id);

        if ($request->hasFile('photo')) {
            if ($user->getFirstMediaUrl('userGallery')) {
                $user->clearMediaCollection('userGallery');
            }
            $user->addMedia($request->file('photo'))->toMediaCollection('userGallery');
        }

        return redirect()->route('users.index')->with('success', 'Foto de usuario actualizada correctamente.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if ($request->hasFile('photo')) {
            $user->addMedia($request->file('photo'))->toMediaCollection('userGallery');
        }

        $user->assignRole($validated['role']);

        return redirect()->route('users.index')->with('success', 'Usuario registrado correctamente.');
    }
}
