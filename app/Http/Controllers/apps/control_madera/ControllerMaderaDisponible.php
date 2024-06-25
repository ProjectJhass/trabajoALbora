<?php

namespace App\Http\Controllers\apps\control_madera;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\ModelConsecutivosMadera;
use App\Models\apps\control_madera\ModelLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        ModelLogs::create([
            'accion' => 'El usuario ' . Auth::user()->nombre . ' modificó el estado del bloque #' . $id . ' nuevo estado: ' . $estado,
            'usuario' => Auth::user()->nombre
        ]);

        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
