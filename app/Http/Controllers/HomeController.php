<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Juego;
use App\Models\Pago;
use App\Models\Partida;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $usuarios = collect();
        $juegos = collect();
        $pagos = collect();
        $grafica = collect();
        $partidasOrganizadas = collect();
        $partidasParticipadas = collect();

        $user = auth()->user();

        if ($user) {
            if (Gate::allows('viewAny', User::class)) {
                $query = User::query()->where('id', '!=', $user->id);

                if ($request->filled('buscar_usuario')) {
                    $query->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($request->buscar_usuario) . '%']);
                }

                $usuarios = $query->get();
            }

            if (Gate::allows('viewAny', Juego::class)) {
                $query = Juego::query();

                if ($request->filled('buscar_juego')) {
                    $query->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($request->buscar_juego) . '%']);
                }

                $juegos = $query->get();
            }

            $query = Partida::where('creador_id', $user->id);

            if ($request->filled('buscar_organizadas')) {
                $query->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($request->buscar_organizadas) . '%']);
            }

            $partidasOrganizadas = $query->get();

            $query = $user->partidas()->where('creador_id', '!=', $user->id);

            if ($request->filled('buscar_participadas')) {
                $query->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($request->buscar_participadas) . '%']);
            }

            $partidasParticipadas = $query->get();

            if (Gate::allows('viewAny', Pago::class)) {
                $pagos = Pago::with('user')->latest()->take(5)->get();

                $grafica = Pago::with('user')->get()
                    ->groupBy(fn($pago) => Carbon::parse($pago->fecha)->format('Y-m'))
                    ->map(function ($pagosMes) {
                        return $pagosMes->groupBy('user_id')->map(function ($pagosUsuario) {
                            $usuario = $pagosUsuario->first()->user;
                            $multiplo = $usuario->tipo === 'semi' ? 10 : 25;
                            return $pagosUsuario->sum('cantidad') / $multiplo;
                        });
                    });
            }
        }

        return view('home', compact(
            'usuarios',
            'juegos',
            'pagos',
            'grafica',
            'partidasOrganizadas',
            'partidasParticipadas'
        ));
    }
}
