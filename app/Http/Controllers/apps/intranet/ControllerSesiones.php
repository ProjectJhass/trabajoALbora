<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControllerSesiones extends Controller
{
    public function index(Request $request)
    {
        session(['centro_operacion' => $request->co, 'fecha_i_ingresos' => $request->fecha_i, 'fecha_f_ingresos' => $request->fecha_f]);
        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
