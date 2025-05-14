<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class JuegoController extends Controller
{
    public function index()
    {
        if (!Gate::allows('viewAny', Juego::class)) {
            return redirect()->route('acceso.denegado');
        }

        $juegos = Juego::all();
        return view('juegos.index', compact('juegos'));
    }

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
            'nombre' => 'required',
            'min_jugadores' => 'required|integer|min:1',
            'max_jugadores' => 'required|integer|gte:min_jugadores',
            'user_id' => 'required|exists:users,id',
        ], [
            'nombre.required' => 'El nombre del juego es obligatorio.',
            'nombre.max' => 'El nombre del juego no puede superar los 255 caracteres.',
            'min_jugadores.required' => 'Debes indicar el número mínimo de jugadores.',
            'min_jugadores.integer' => 'El mínimo de jugadores debe ser un número entero.',
            'min_jugadores.min' => 'Debe haber al menos un jugador mínimo.',
            'max_jugadores.required' => 'Debes indicar el número máximo de jugadores.',
            'max_jugadores.integer' => 'El máximo de jugadores debe ser un número entero.',
            'max_jugadores.gte' => 'El número máximo debe ser mayor o igual al mínimo.',
            'user_id.required' => 'Debes asignar un responsable del juego.',
            'user_id.exists' => 'El usuario seleccionado no es válido.',
        ]);

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
            'nombre' => 'required',
            'min_jugadores' => 'required|integer|min:1',
            'max_jugadores' => 'required|integer|gte:min_jugadores',
            'user_id' => 'required|exists:users,id',
        ], [
            'nombre.required' => 'El nombre del juego es obligatorio.',
            'nombre.max' => 'El nombre del juego no puede superar los 255 caracteres.',
            'min_jugadores.required' => 'Debes indicar el número mínimo de jugadores.',
            'min_jugadores.integer' => 'El mínimo de jugadores debe ser un número entero.',
            'min_jugadores.min' => 'Debe haber al menos un jugador mínimo.',
            'max_jugadores.required' => 'Debes indicar el número máximo de jugadores.',
            'max_jugadores.integer' => 'El máximo de jugadores debe ser un número entero.',
            'max_jugadores.gte' => 'El número máximo debe ser mayor o igual al mínimo.',
            'user_id.required' => 'Debes asignar un responsable del juego.',
            'user_id.exists' => 'El usuario seleccionado no es válido.',
        ]);

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
