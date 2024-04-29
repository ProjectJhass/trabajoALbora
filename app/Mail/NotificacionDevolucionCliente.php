<?php

namespace App\Mail;

use App\Http\Controllers\apps\servicios_tecnicos\servicios\ControllerFormatosPdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionDevolucionCliente extends Mailable
{
    use Queueable, SerializesModels;

    protected $nombre, $item, $ost;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre, $item, $ost)
    {
        $this->nombre = $nombre;
        $this->item = $item;
        $this->ost = $ost;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = new ControllerFormatosPdf();
        $pdf = $data->FormatoRespuesta($this->ost);

        return $this->view('apps.servicios_tecnicos.notificaciones.entrega_cliente', ['nombre' => $this->nombre, 'item' => $this->item, 'ost' => $this->ost])
            ->subject('Notificación de Servicio Técnico - Producto listo para entrega')
            ->attachData($pdf->Output('S'), 'RESPUESTA SOLICITUD SERVICIO TECNICO.pdf');
    }
}