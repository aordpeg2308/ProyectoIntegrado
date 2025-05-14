<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\GenericMail;

class ContactoController extends Controller
{
    public function enviar(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email',
            'message' => 'required|string|min:5',
        ]);

        
        $tituloAdmin = 'Nuevo mensaje desde Ludus Alea';
        $contenidoAdmin = "Correo del visitante: {$request->email}\n\nMensaje:\n{$request->message}";

        
        Mail::to('ludusaleavisos@gmail.com')->send(
            new GenericMail($tituloAdmin, $contenidoAdmin)
        );

        
        $tituloUser = 'Hemos recibido tu mensaje en Ludus Alea';
        $contenidoUser = "Gracias por contactarnos. Hemos recibido tu mensaje y te responderemos lo antes posible.\n\nTu mensaje:\n{$request->message}";

        
        Mail::to($request->email)->send(
            new GenericMail($tituloUser, $contenidoUser)
        );

        
        return redirect()->back()->with('success', 'Mensaje enviado correctamente.');
    }
}
