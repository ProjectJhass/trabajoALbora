<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios\seguimiento;

use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\servicios\seguimiento\ModelSeguimientoTiempos;
use Illuminate\Http\Request;

class ControllerSeguimiento extends Controller
{
    public function agregarSeguimiento($id_st, $id_proceso)
    {
        ModelSeguimientoTiempos::create([
            'id_st' => $id_st,
            'id_proceso' => $id_proceso,
            'fecha_inicial' => date('Y-m-d')
        ]);
    }

    public function updateSeguimiento($id_st, $id_proceso)
    {
        $data = ModelSeguimientoTiempos::where('id_st', $id_st)->where('id_proceso', $id_proceso)->first();
        if ($data) {
            $data->fecha_final = date('Y-m-d');
            $data->save();
        }
    }
}
