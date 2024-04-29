<?php

namespace App\Mail;

use App\Http\Controllers\apps\servicios_tecnicos\servicios\ControllerFormatosPdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionNoGarantiaCliente extends Mailable
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
        $data = new ControllerFormatosPdf();
        $pdf = $data->FormatoRespuesta($this->ost);
        
        return $this->view('apps.servicios_tecnicos.notificaciones.noGarantiaCliente', ['ost' => $this->ost, 'nombre' => $this->nombre, 'articulo' => $this->articulo])
        ->subject('Respuesta de valoración Muebles Albura SAS')
        ->attachData($pdf->Output('S'), 'RESPUESTA VALORACION SERVICIO TECNICO.pdf');
    }
}
