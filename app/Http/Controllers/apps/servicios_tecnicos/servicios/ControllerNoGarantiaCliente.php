<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios;

use App\Http\Controllers\Controller;
use App\Mail\NotificacionNoGarantiaCliente;
use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ControllerNoGarantiaCliente extends Controller
{
    public function enviarNotificacion(Request $request)
    {
        $id_ost = $request->id_st;
        $ost = ModelNuevaSolicitud::find($id_ost);
        Mail::to($ost->email)->later(now()->addSeconds(5), new NotificacionNoGarantiaCliente($id_ost, $ost->nombre, $ost->articulo));

        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
