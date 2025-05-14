<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => 'Estas credenciales no son correctas.'
            ]);
        }
         if (!Auth::user()->activo) {
        Auth::logout();
        throw ValidationException::withMessages([
            'email' => 'Este usuario está dado de baja.'
        ]);
    }

        $request->session()->regenerate();
        return redirect()->route('home');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
