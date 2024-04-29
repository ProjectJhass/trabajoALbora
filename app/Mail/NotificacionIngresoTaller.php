<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionIngresoTaller extends Mailable
{
    use Queueable, SerializesModels;

    protected $nombre, $ost, $articulo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre, $ost, $articulo)
    {
        $this->nombre = $nombre;
        $this->ost = $ost;
        $this->articulo = $articulo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('apps.servicios_tecnicos.notificaciones.ingreso_taller', ['nombre' => $this->nombre, 'ost' => $this->ost, 'articulo' => $this->articulo]);
    }
}
