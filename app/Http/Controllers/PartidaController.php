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
use Illuminate\Support\Str;

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
            ->orderBy('fecha')
            ->get()
            ->filter(fn($p) => $p->jugadores->count() < $p->max_jugadores);

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
            'nombre' => 'required|string',
            'juego_id' => 'required|exists:juegos,id',
            'fecha' => 'required|date|after:now',
            'min_jugadores' => 'required|integer|min:1',
            'max_jugadores' => 'required|integer|gte:min_jugadores',
            'descripcion' => 'required|string',
        ], [
            'nombre.required' => 'El nombre de la partida es obligatorio.',
            'juego_id.required' => 'Debes seleccionar un juego.',
            'juego_id.exists' => 'El juego seleccionado no existe.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe tener un formato válido.',
            'fecha.after' => 'La fecha debe ser posterior al momento actual.',
            'min_jugadores.required' => 'El número mínimo de jugadores es obligatorio.',
            'min_jugadores.integer' => 'El número mínimo debe ser un número entero.',
            'min_jugadores.min' => 'Debe haber al menos un jugador mínimo.',
            'max_jugadores.required' => 'El número máximo de jugadores es obligatorio.',
            'max_jugadores.integer' => 'El número máximo debe ser un número entero.',
            'max_jugadores.gte' => 'El número máximo debe ser mayor o igual al mínimo.',
            'descripcion.required' => 'La descripción de la partida es obligatoria.',
            'descripcion.string' => 'La descripción debe ser un texto válido.',
        ]);

        $validated['nombre'] = Str::title($validated['nombre']);

        $partida = Partida::create([
            ...$validated,
            'creador_id' => Auth::id(),
        ]);

        $partida->jugadores()->attach(Auth::id());

        $juego = $partida->juego;
        $creador = Auth::user();

        Mail::to($creador->email)->send(
            new GenericMail(
                'Partida creada - Ludus Alea',
                "Has creado la partida '{$partida->nombre}' con éxito."
            )
        );

        $mensajeUsuarios = "Se ha creado la partida '{$partida->nombre}' del juego '{$juego->nombre}', "
            . "programada para el día {$partida->fecha->format('d/m/Y H:i')}.\n\n"
            . "Descripción: {$partida->descripcion}\n"
            . "Mínimo de jugadores: {$partida->min_jugadores}\n"
            . "Máximo de jugadores: {$partida->max_jugadores}";

        User::where('id', '!=', $creador->id)
            ->where('activo', true)
            ->where('quiere_correos', true)
            ->each(function ($user) use ($mensajeUsuarios) {
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
            'fecha.required' => 'La nueva fecha es obligatoria.',
            'fecha.date' => 'La fecha debe tener un formato válido.',
            'fecha.after' => 'La nueva fecha debe ser posterior al momento actual.',
        ]);

        $partida->update($validated);

        $creador = $partida->creador;
        $juego = $partida->juego;

        foreach ($partida->jugadores as $jugador) {
            if ($jugador->id !== $partida->creador_id && $jugador->quiere_correos) {
                Mail::to($jugador->email)->send(
                    new GenericMail(
                        'Cambio de fecha - Ludus Alea',
                        "La partida '{$partida->nombre}' del juego '{$juego->nombre}' ha cambiado de fecha a {$partida->fecha->format('d/m/Y H:i')}."
                    )
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

        $creador = $partida->creador;
        $juego = $partida->juego;
        $fecha = $partida->fecha->format('d/m/Y');

        foreach ($partida->jugadores as $jugador) {
            if ($jugador->quiere_correos) {
                Mail::to($jugador->email)->send(
                    new GenericMail(
                        'Partida cancelada - Ludus Alea',
                        "La partida '{$partida->nombre}' del juego '{$juego->nombre}' programada para el día {$fecha}, organizada por {$creador->nombre}, ha sido cancelada."
                    )
                );
            }
        }

        $partida->delete();
        return redirect()->route('home');
    }

    public function join(Partida $partida)
    {
        if (!Auth::check()) return redirect()->route('login');

        if (!$partida->jugadores->contains(Auth::id())) {
            $partida->jugadores()->attach(Auth::id());

            $jugador = Auth::user();
            $juego = $partida->juego;
            $creador = $partida->creador;

            if ($jugador->quiere_correos) {
                Mail::to($jugador->email)->send(
                    new GenericMail(
                        'Unido a partida - Ludus Alea',
                        "Te has unido a la partida '{$partida->nombre}' del juego '{$juego->nombre}' el día {$partida->fecha->format('d/m/Y')} organizada por {$creador->nombre}."
                    )
                );
            }

            if ($creador->quiere_correos) {
                $plazasLibres = $partida->max_jugadores - $partida->jugadores->count() - 1;

                Mail::to($creador->email)->send(
                    new GenericMail(
                        'Nuevo jugador en tu partida - Ludus Alea',
                        "El usuario {$jugador->nombre} se ha unido a tu partida '{$partida->nombre}'. Quedan {$plazasLibres} plazas libres."
                    )
                );
            }
        }

        return redirect()->route('home');
    }

    public function leave(Partida $partida)
    {
        if (!Auth::check()) return redirect()->route('login');

        if ($partida->jugadores->contains(Auth::id())) {
            $jugador = Auth::user();
            $partida->jugadores()->detach($jugador->id);

            $juego = $partida->juego;
            $creador = $partida->creador;

            if ($jugador->quiere_correos) {
                Mail::to($jugador->email)->send(
                    new GenericMail(
                        'Salida de partida - Ludus Alea',
                        "Te has salido de la partida '{$partida->nombre}' del juego '{$juego->nombre}' programada para el día {$partida->fecha->format('d/m/Y')}."
                    )
                );
            }

            if ($creador->quiere_correos) {
                $plazasLibres = $partida->max_jugadores - $partida->jugadores->count() + 1;

                Mail::to($creador->email)->send(
                    new GenericMail(
                        'Jugador se ha salido de tu partida - Ludus Alea',
                        "El usuario {$jugador->nombre} se ha salido de tu partida '{$partida->nombre}'. Quedan {$plazasLibres} plazas libres."
                    )
                );
            }
        }

        return redirect()->route('home');
    }
}
