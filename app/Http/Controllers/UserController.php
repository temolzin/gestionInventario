<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::all();
        $departments = Department::all();

        $users = User::where('name', 'like', "%{$request->search}%")
            ->orWhere('last_name', 'like', "%{$request->search}%")
            ->orWhere('email', 'like', "%{$request->search}%")
            ->paginate(10);

        return view('users.index', compact('users', 'roles', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->department_id = $request->input('department_id');

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

    public function updatePassword(Request $request, $id)
    {
        $user = User::find($id);
        $newPassword = trim($request->input('updatePassword'));
        $confirmPassword = trim($request->input('passwordConfirmation'));

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->withInput()->withErrors(['passwordConfirmation' => 'Las contraseñas no coinciden.']);
        } else {
            $user->password = bcrypt($newPassword);
            $user->save();
            return redirect()->route('users.index')->with('success', 'Contraseña actualizada correctamente.');
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required',
            'department_id' => 'nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $departmentId = $validated['department_id'] ?? null;

        $user = User::create([
            'name' => $validated['name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'department_id' => $departmentId,
        ]);

        if ($request->hasFile('photo')) {
            $user->addMedia($request->file('photo'))->toMediaCollection('userGallery');
        }

        $user->assignRole($validated['role']);

        return redirect()->route('users.index')->with('success', 'Usuario registrado correctamente.');
    }
}
