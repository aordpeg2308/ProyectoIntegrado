<?php

namespace App\Http\Controllers;

use App\Mail\GenericMail;
use App\Models\Juego;
use App\Models\Partida;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;

class PartidaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $partidas = Partida::with('juego', 'jugadores')
            ->where('fecha', '>', now())
            ->whereDoesntHave('jugadores', fn($q) => $q->where('user_id', $user->id))
            ->where('creador_id', '!=', $user->id)
            ->whereHas('creador', fn($q) => $q->where('activo', true))
            ->get()
            ->filter(fn($p) => $p->jugadores->count() < $p->juego->max_jugadores);

        if ($request->filled('buscar')) {
            $partidas = $partidas->filter(fn($p) =>
                str_contains(strtolower($p->nombre), strtolower($request->buscar))
            );
        }

        return view('partidas.index', compact('partidas'));
    }

    public function creadas()
    {
        if (!Auth::check()) return redirect()->route('login');

        $partidas = Partida::with('juego', 'jugadores')
            ->where('creador_id', Auth::id())
            ->whereHas('creador', fn($q) => $q->where('activo', true))
            ->get();

        return view('partidas.organizadas', compact('partidas'));
    }

    public function participadas()
    {
        if (!Auth::check()) return redirect()->route('login');

        $partidas = Auth::user()->partidas()
            ->where('creador_id', '!=', Auth::id())
            ->with('juego', 'jugadores')
            ->get();

        return view('partidas.participadas', compact('partidas'));
    }

    public function create()
    {
        if (!Gate::allows('create', Partida::class)) {
            return redirect()->route('acceso.denegado');
        }

        $juegos = Juego::all();
        return view('partidas.create', compact('juegos'));
    }

    public function store(Request $request)
    {
        if (!Gate::allows('create', Partida::class)) {
            return redirect()->route('acceso.denegado');
        }

        $validated = $request->validate([
            'nombre' => 'required',
            'juego_id' => 'required|exists:juegos,id',
            'fecha' => 'required|date|after:now',
        ], [
            'nombre.required' => 'El nombre de la partida es obligatorio.',
            'juego_id.required' => 'Debes seleccionar un juego.',
            'juego_id.exists' => 'El juego seleccionado no existe.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe tener un formato válido.',
            'fecha.after' => 'La fecha debe ser posterior al momento actual.',
        ]);

        $partida = Partida::create([
            ...$validated,
            'creador_id' => Auth::id(),
        ]);

        $partida->jugadores()->attach(Auth::id());

        Mail::to(Auth::user()->email)->send(
            new GenericMail('Partida creada - Ludus Alea', "Has creado la partida '{$partida->nombre}' para el día {$validated['fecha']}.")
        );

        $mensajeUsuarios = "Se ha creado la partida '{$partida->nombre}', que se jugará el {$validated['fecha']}. Puedes unirte desde la sección de partidas disponibles.";

        User::where('id', '!=', Auth::id())->where('activo', true)->each(function ($user) use ($mensajeUsuarios) {
            Mail::to($user->email)->send(new GenericMail('Nueva partida disponible - Ludus Alea', $mensajeUsuarios));
        });

        return redirect()->route('home');
    }

    public function edit(Partida $partida)
    {
        if (!Gate::allows('update', $partida)) {
            return redirect()->route('acceso.denegado');
        }

        return view('partidas.edit', compact('partida'));
    }

    public function update(Request $request, Partida $partida)
    {
        if (!Gate::allows('update', $partida)) {
            return redirect()->route('acceso.denegado');
        }

        $validated = $request->validate([
            'fecha' => 'required|date|after:now',
        ], [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe tener un formato válido.',
            'fecha.after' => 'La fecha debe ser posterior al momento actual.',
        ]);

        $partida->update($validated);

        foreach ($partida->jugadores as $jugador) {
            if ($jugador->id !== $partida->creador_id) {
                Mail::to($jugador->email)->send(
                    new GenericMail('Cambio de fecha - Ludus Alea', "La partida '{$partida->nombre}' ha cambiado de fecha a {$validated['fecha']}.")
                );
            }
        }

        return redirect()->route('home');
    }

    public function destroy(Partida $partida)
    {
        if (!Gate::allows('delete', $partida)) {
            return redirect()->route('acceso.denegado');
        }

        foreach ($partida->jugadores as $jugador) {
            Mail::to($jugador->email)->send(
                new GenericMail('Partida cancelada - Ludus Alea', "La partida '{$partida->nombre}' ha sido cancelada.")
            );
        }

        $partida->delete();
        return redirect()->route('home');
    }

    public function join(Partida $partida)
    {
        if (!Auth::check()) return redirect()->route('login');

        if (!$partida->jugadores->contains(Auth::id())) {
            $partida->jugadores()->attach(Auth::id());
            Mail::to(Auth::user()->email)->send(
                new GenericMail('Unido a partida - Ludus Alea', "Te has unido a la partida '{$partida->nombre}'")
            );
        }

        return redirect()->route('home');
    }

    public function leave(Partida $partida)
    {
        if (!Auth::check()) return redirect()->route('login');

        if ($partida->jugadores->contains(Auth::id())) {
            $partida->jugadores()->detach(Auth::id());
            Mail::to(Auth::user()->email)->send(
                new GenericMail('Salida de partida - Ludus Alea', "Te has salido de la partida '{$partida->nombre}'")
            );
        }

        return redirect()->route('home');
    }
}
