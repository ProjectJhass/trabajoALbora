<?php

namespace App\Http\Controllers\apps\intranet_fabrica;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet_fabrica\ModelMaquinasFabrica;
use Illuminate\Http\Request;

class ControllerMaquinasFab extends Controller
{
    public function MaquinasFabrica()
    {
        $maquinas = ModelMaquinasFabrica::ObtenerTodasLasHerramientas();
        return view('apps.intranet_fabrica.fabrica.usuarios.maquinas.maquinas', ['maquinas' => $maquinas]);
    }

    public function AgregarMaquinasFabrica()
    {
        return view('apps.intranet_fabrica.fabrica.usuarios.maquinas.agregar_referencia');
    }

    public function RegistarNuevaMaquinaFab(Request $request)
    {
        if (!empty($request->referencia) && !empty($request->nombre_maquina)) {
            $data = (['referencia' => $request->referencia, 'nombre_maquina' => $request->nombre_maquina]);
            $response = ModelMaquinasFabrica::CrearNuevaMaquinaFab($data);
            if ($response) {
                return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }
    }

    public function EliminarRefMaquinaFabrica(Request $request)
    {
        $response = ModelMaquinasFabrica::EliminarMaquinaFabrica($request->id_maquina);
        if ($response) {
            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
