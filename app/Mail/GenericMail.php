<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericMail extends Mailable
{
    use Queueable, SerializesModels;

    public $titulo;
    public $mensaje;

    public function __construct($titulo, $mensaje)
    {
        $this->titulo = $titulo;
        $this->mensaje = $mensaje;
    }

    public function build()
    {
        return $this->subject($this->titulo)
                    ->view('emails.generic');
    }
}
