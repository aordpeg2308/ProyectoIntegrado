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
  





    public function create()
    {
        if (!Gate::allows('create', Pago::class)) {
            return redirect()->route('acceso.denegado');
        }

        $usuarios = User::where('activo', true)->get();
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

    
    $ultimoPago = Pago::where('user_id', $user->id)->orderBy('fecha', 'desc')->get();

    $totalCantidad = $ultimoPago->sum('cantidad');
    $totalMeses = $totalCantidad / $multiploEsperado;

 
    $fechaBase = $ultimoPago->sortBy('fecha')->first()->fecha;
    $proximoPago = Carbon::parse($fechaBase)->addMonths($totalMeses)->format('d/m/Y');

    
    $mensaje = "Gracias por tu pago. Has abonado $totalMeses mes(es) en total. Tu próximo pago será el $proximoPago.";
    Mail::to($user->email)->send(new GenericMail('Confirmación de pago - Ludus Alea', $mensaje));

    return redirect()->route('home');
}
}
