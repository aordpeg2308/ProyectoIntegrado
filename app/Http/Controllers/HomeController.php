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
        $partidasOrganizadas = collect();
        $partidasParticipadas = collect();
        $proximosPagos = collect();

        $user = auth()->user();

        if ($user) {
            if (Gate::allows('viewAny', User::class)) {
                $query = User::query()->where('id', '!=', $user->id);

                if ($user->rol !== 'admin') {
                    $query->where('activo', true);
                }

                if ($request->filled('buscar_usuario')) {
                    $query->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($request->buscar_usuario) . '%']);
                }

                $usuarios = $query->orderBy('nombre')->get();
            }

            if (Gate::allows('viewAny', Juego::class)) {
                $query = Juego::query();

                if ($request->filled('buscar_juego')) {
                    $query->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($request->buscar_juego) . '%']);
                }

                $juegos = $query->orderBy('nombre')->get();
            }

            $query = Partida::where('creador_id', $user->id);

            if ($request->filled('buscar_organizadas')) {
                $query->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($request->buscar_organizadas) . '%']);
            }

            $partidasOrganizadas = $query->orderBy('fecha')->get();

            $query = $user->partidas()->where('creador_id', '!=', $user->id);

            if ($request->filled('buscar_participadas')) {
                $query->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($request->buscar_participadas) . '%']);
            }

            $partidasParticipadas = $query->orderBy('fecha')->get();

            if (Gate::allows('viewAny', Pago::class)) {
                $pagos = Pago::with('user')->latest()->take(5)->get();

                $proximosPagos = User::where('activo', true)->get()->map(function ($user) {
                    $pagos = $user->pagos()->orderBy('fecha', 'asc')->get();

                    if ($pagos->isEmpty()) {
                        return [
                            'nombre' => $user->nombre,
                            'tipo' => $user->tipo,
                            'estado_pago' => 'pendiente',
                            'mensaje' => 'No hay pagos registrados.',
                        ];
                    }

                    $multiplo = $user->tipo === 'semi' ? 10 : 25;
                    $totalPagado = $pagos->sum('cantidad');
                    $mesesPagados = $totalPagado / $multiplo;

                    $fechaPrimerPago = $pagos->first()->fecha;
                    $proximoPago = Carbon::parse($fechaPrimerPago)->addMonths($mesesPagados);

                    if ($proximoPago->isPast()) {
                        return [
                            'nombre' => $user->nombre,
                            'tipo' => $user->tipo,
                            'estado_pago' => 'pendiente',
                            'mensaje' => 'Pago vencido desde el ' . $proximoPago->format('d/m/Y'),
                        ];
                    }

                    return [
                        'nombre' => $user->nombre,
                        'tipo' => $user->tipo,
                        'estado_pago' => 'ok',
                        'proximo_pago' => $proximoPago,
                    ];
                });

                if ($request->filled('buscar_pago_usuario')) {
                    $proximosPagos = $proximosPagos->filter(function ($p) use ($request) {
                        return str_contains(strtolower($p['nombre']), strtolower($request->buscar_pago_usuario));
                    });
                }
            }
        }

        return view('home', compact(
            'usuarios',
            'juegos',
            'pagos',
            'partidasOrganizadas',
            'partidasParticipadas',
            'proximosPagos'
        ));
    }
}