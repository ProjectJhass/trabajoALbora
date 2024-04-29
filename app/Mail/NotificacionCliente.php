<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionCliente extends Mailable
{
    use Queueable, SerializesModels;

    protected $id, $item, $concepto;

    public function __construct($id, $item, $concepto)
    {
        $this->id = $id;
        $this->item = $item;
        $this->concepto = $concepto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('apps.servicios_tecnicos.notificaciones.cliente', ['id_st' => $this->id, 'item' => $this->item, 'concepto' => $this->concepto])
            ->subject('Valoración del servicio técnico');
    }
}
