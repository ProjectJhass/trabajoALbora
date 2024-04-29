<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios;

use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use Illuminate\Http\Request;

class ControllerInfoDespachos extends Controller
{
    public function solicitudesTable($data_info)
    {
        return view('apps.servicios_tecnicos.servicios_tecnicos.despachos.table', ['st' => $data_info])->render();
    }

    public function procesoData()
    {
        $ingresar = ModelNuevaSolicitud::where('proceso', 'Taller')->where('estado', 'Por ingresar')->count();
        $data_info = ModelNuevaSolicitud::where('proceso', 'Taller')->where('estado', 'Por ingresar')->get();

        $table = self::solicitudesTable($data_info);
        return view('apps.servicios_tecnicos.servicios_tecnicos.despachos.seguimiento', ['table' => $table, 'ingresar' => $ingresar]);
    }
}
