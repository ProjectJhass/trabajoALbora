<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios\plantilla;

use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\servicios\infoAlmacenes;
use Illuminate\Http\Request;

class ControllerAlmacenes extends Controller
{
    public function ObtenerInfoAlmacenes()
    {
        $data = '<option value="">Seleccionar...</option>';
        $info = infoAlmacenes::where('estado', '1')->orderBy('almacen')->get();
        foreach ($info as $key => $value) {
            $data .= '<option value="' . $value->numero . '">' . $value->almacen . '</option>';
        }
        return response()->json(['options' => $data], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
