<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionProdReparado extends Mailable
{
    use Queueable, SerializesModels;
    protected $item, $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item, $id)
    {
        $this->item = $item;
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('apps.servicios_tecnicos.notificaciones.item_reparado', ['item' => $this->item, 'id' => $this->id])->subject('Respuesta a OST reparada');
    }
}
