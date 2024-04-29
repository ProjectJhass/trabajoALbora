<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionCambioEstado extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitud, $estado, $prioridad;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($solicitud, $estado, $prioridad)
    {
        $this->solicitud = $solicitud;
        $this->estado = $estado;
        $this->prioridad = $prioridad;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.cambio_estado', ['solicitud' => $this->solicitud, 'estado' => $this->estado, 'prioridad' => $this->prioridad]);
    }
}
