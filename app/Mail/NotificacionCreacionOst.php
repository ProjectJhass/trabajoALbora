<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionCreacionOst extends Mailable
{
    use Queueable, SerializesModels;
    protected $ost, $nombre, $articulo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ost, $nombre, $articulo)
    {
        $this->ost = $ost;
        $this->nombre = $nombre;
        $this->articulo = $articulo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('apps.servicios_tecnicos.notificaciones.creacion', ['ost' => $this->ost, 'nombre' => $this->nombre, 'articulo' => $this->articulo])->subject('Solicitud de servicio técnico');
    }
}
