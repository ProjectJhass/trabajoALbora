<?php

namespace App\Http\Controllers\apps\control_madera;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\ModelConsecutivosMadera;
use Illuminate\Http\Request;

class ControllerMaderaDisponible extends Controller
{
    public function index()
    {
        $madera = ModelConsecutivosMadera::where('estado', 'Activo')->get();
        return view('apps.control_madera.app.planner.madera.madera_disponible', ['madera' => $madera]);
    }

    public function updateEstadoMadera(Request $request)
    {
        $estado = $request->valor;
        $id = $request->id;

        $info_ = ModelConsecutivosMadera::find($id);
        $info_->estado = $estado;
        $info_->save();

        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
