<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios\fabrica;

use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use Illuminate\Http\Request;

class ControllerSeguimientoFab extends Controller
{
    public function infoSolicitudesPorValoracion($data_info)
    {
        return view('apps.servicios_tecnicos.servicios_tecnicos.fabrica.seguimiento.table_seguimiento', ['st' => $data_info])->render();
    }

    public function valoracion()
    {
        $valoracion = ModelNuevaSolicitud::where('proceso', 'fabrica')->where('estado', 'En valoracion')->count();
        $respuesta = ModelNuevaSolicitud::where('proceso', 'fabrica')->where('estado', 'Carta en elaboracion')->count();
        $data_info = ModelNuevaSolicitud::where('proceso', 'Fabrica')->where('estado', 'En valoracion')->get();

        $table = self::infoSolicitudesPorValoracion($data_info);
        return view('apps.servicios_tecnicos.servicios_tecnicos.fabrica.seguimiento.valoracion', ['table' => $table, 'valoracion' => $valoracion, 'respuesta' => $respuesta]);
    }

    public function infoGeneral(Request $request)
    {
        $estado = $request->estado;

        switch ($estado) {
            case 'valoracion':
                $data_info = ModelNuevaSolicitud::where('proceso', 'Fabrica')->where('estado', 'En valoracion')->get();
                break;
            case 'respuesta':
                $data_info = ModelNuevaSolicitud::where('proceso', 'Fabrica')->where('estado', 'Carta en elaboracion')->get();
                break;
        }

        $table = self::infoSolicitudesPorValoracion($data_info);
        return response()->json(['table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
