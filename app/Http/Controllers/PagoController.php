<?php

namespace App\Http\Controllers;

use App\Mail\GenericMail;
use App\Models\Pago;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Date;
use Carbon\Carbon;


class PagoController extends Controller
{
  


public function index()
{
    if (!Gate::allows('viewAny', Pago::class)) {
        return redirect()->route('acceso.denegado');
    }

    $pagos = Pago::with('user')->get();

    $grafica = Pago::with('user')->get()->groupBy(function ($pago) {
        return Carbon::parse($pago->fecha)->format('Y-m');
    })->map(function ($pagosMes) {
        return $pagosMes->groupBy('user_id')->map(function ($pagosUsuario) {
            $usuario = $pagosUsuario->first()->user;
            $multiplo = $usuario->tipo === 'semi' ? 10 : 25;
            $total = $pagosUsuario->sum('cantidad');
            return $total / $multiplo;
        });
    });

    return view('pagos.index', compact('pagos', 'grafica'));
}


    public function create()
    {
        if (!Gate::allows('create', Pago::class)) {
            return redirect()->route('acceso.denegado');
        }

        $usuarios = User::all();
        return view('pagos.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        if (!Gate::allows('create', Pago::class)) {
            return redirect()->route('acceso.denegado');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'cantidad' => 'required|numeric|min:10',
            'fecha' => 'required|date',
        ], [
        'user_id.required' => 'Debes seleccionar un usuario.',
        'user_id.exists' => 'El usuario seleccionado no es válido.',
        'cantidad.required' => 'Debes indicar una cantidad.',
        'cantidad.numeric' => 'La cantidad debe ser un número válido.',
        'cantidad.min' => 'La cantidad mínima es de 10€.',
        'fecha.required' => 'Debes indicar una fecha.',
        'fecha.date' => 'La fecha no tiene un formato válido.',
        ]);

        $user = User::findOrFail($validated['user_id']);

        $multiploEsperado = $user->tipo === 'semi' ? 10 : 25;
        if ($validated['cantidad'] % $multiploEsperado !== 0) {
            return back()->withErrors(['cantidad' => "La cantidad debe ser múltiplo de $multiploEsperado."]);
        }

        $pago = Pago::create($validated);

        $mesesPagados = $validated['cantidad'] / $multiploEsperado;
        $proximoPago = Date::parse($validated['fecha'])->addMonths($mesesPagados)->format('d/m/Y');

        $mensaje = "Gracias por tu pago. Has abonado $mesesPagados mes(es). Tu próximo pago será el $proximoPago.";
        Mail::to($user->email)->send(new GenericMail('Confirmación de pago - Ludus Alea', $mensaje));

        return redirect()->route('home');
    }
}
