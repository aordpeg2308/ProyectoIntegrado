<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class JuegoController extends Controller
{
  

    public function create()
    {
        if (!Gate::allows('create', Juego::class)) {
            return redirect()->route('acceso.denegado');
        }

        $usuarios = User::all();
        return view('juegos.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        if (!Gate::allows('create', Juego::class)) {
            return redirect()->route('acceso.denegado');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:Juego de mesa,Manual de rol',
            'genero' => 'required|string|max:255',
            'edad' => 'required|integer|min:0',
            'user_id' => 'required|exists:users,id',
        ], [
            'nombre.required' => 'El nombre del juego es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 255 caracteres.',
            'tipo.required' => 'El tipo de juego es obligatorio.',
            'tipo.in' => 'El tipo debe ser "Juego de mesa" o "Manual de rol".',
            'genero.required' => 'El género es obligatorio.',
            'genero.max' => 'El género no puede superar los 255 caracteres.',
            'edad.required' => 'La edad recomendada es obligatoria.',
            'edad.integer' => 'La edad debe ser un número.',
            'edad.min' => 'La edad debe ser al menos 0.',
            'user_id.required' => 'Debes asignar un responsable del juego.',
            'user_id.exists' => 'El usuario seleccionado no es válido.',
        ]);

        $validated['nombre'] = Str::title($validated['nombre']);
        $validated['genero'] = Str::title($validated['genero']);
        Juego::create($validated);
        return redirect()->route('home');
    }

    public function edit(Juego $juego)
    {
        if (!Gate::allows('update', $juego)) {
            return redirect()->route('acceso.denegado');
        }

        $usuarios = User::all();
        return view('juegos.edit', compact('juego', 'usuarios'));
    }

    public function update(Request $request, Juego $juego)
    {
        if (!Gate::allows('update', $juego)) {
            return redirect()->route('acceso.denegado');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:Juego de mesa,Manual de rol',
            'genero' => 'required|string|max:255',
            'edad' => 'required|integer|min:0',
            'user_id' => 'required|exists:users,id',
        ], [
            'nombre.required' => 'El nombre del juego es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 255 caracteres.',
            'tipo.required' => 'El tipo de juego es obligatorio.',
            'tipo.in' => 'El tipo debe ser "Juego de mesa" o "Manual de rol".',
            'genero.required' => 'El género es obligatorio.',
            'genero.max' => 'El género no puede superar los 255 caracteres.',
            'edad.required' => 'La edad recomendada es obligatoria.',
            'edad.integer' => 'La edad debe ser un número.',
            'edad.min' => 'La edad debe ser al menos 0.',
            'user_id.required' => 'Debes asignar un responsable del juego.',
            'user_id.exists' => 'El usuario seleccionado no es válido.',
        ]);

        $validated['nombre'] = Str::title($validated['nombre']);
        $validated['genero'] = Str::title($validated['genero']);
        $juego->update($validated);
        return redirect()->route('home');
    }

    public function destroy(Juego $juego)
    {
        if (!Gate::allows('delete', $juego)) {
            return redirect()->route('acceso.denegado');
        }

        $juego->delete();
        return redirect()->route('home');
    }
}
