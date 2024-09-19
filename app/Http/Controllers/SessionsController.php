<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        if (!auth()->attempt(request(['email', 'password']))) {
            return back()->withErrors(['message' => 'El correo o la contraseña es incorrecto. Intente de nuevo.']);
        }

        return auth()->user()->role == 'admin'
            ? redirect()->route('admin.index')
            : redirect()->to('/');
    }

    public function destroy()
    {
        auth()->logout();
        return redirect()->to('/');
    }
}
