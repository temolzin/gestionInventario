<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $department = $user->department;

        return view('profiles.index', compact('user','department'));
    }

    public function profileUpdate(Request $request)
    {
        $user = User::find(Auth::id());
        $user->name = $request->input('nameUpdate');
        $user->last_name = $request->input('lastNameUpdate');
        $user->email = $request->input('emailUpdate');

        $user->save();

        return redirect()->route('profiles.index')->with('success', 'Perfil actualizado correctamente.');
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'profileImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::find(Auth::id());

        if ($user->getFirstMedia('userGallery')) {
            $user->clearMediaCollection('userGallery');
        }

        $user->addMedia($request->file('profileImage'))->toMediaCollection('userGallery');

        return redirect()->back()->with('success', 'Foto de perfil actualizada con éxito.');
    }

    public function updatePassword(Request $request)
    {
        $user = User::find(Auth::id());

        if (!Hash::check($request->input('oldPassword'), $user->password)) {
            return redirect()->back()->with('error', 'La contraseña actual es incorrecta.');
        }

        $newPassword = $request->input('updatePassword');
        $confirmPassword = $request->input('passwordConfirmation');

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'La nueva contraseña y la confirmación no coinciden.');
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        return redirect()->route('profiles.index')->with('success', 'Contraseña actualizada correctamente.');
    }
}
