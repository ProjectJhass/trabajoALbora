<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionNoGarantia extends Mailable
{
    use Queueable, SerializesModels;

    protected $id_st, $concepto, $item;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id_st, $concepto, $item)
    {
        $this->id_st = $id_st;
        $this->concepto = $concepto;
        $this->item = $item;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('apps.servicios_tecnicos.notificaciones.valoracion_fab', ['id_st' => $this->id_st, 'concepto' => $this->concepto, 'item' => $this->item])->subject('Respuesta valoración de fábrica');
    }
}
