<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelRegistrarNovedades;
use Illuminate\Http\Request;

class ControllerRegistrarNovedades extends Controller
{
    public function index(Request $request)
    {
        if (!empty($request->empleado) && !empty($request->fecha) && !empty($request->comentario) && !empty($request->co)) {
            $data = ([
                'novedad_salida' => $request->novedad_general,
                'novedad_usuario' => $request->comentario,
                'fecha_novedad' => $request->fecha,
                'id_registro' => $request->empleado,
                'co' => $request->co,
                'id_registro_ingreso' => 0
            ]);
            $response = ModelRegistrarNovedades::AgregarNovedades($data);
            if ($response) {
                return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }
    }

    public function consultar(Request $request)
    {
        $sucursal = ModelRegistrarNovedades::ConsultarSucursalUsuario($request->valor);
        if (count($sucursal) > 0) {
            return response()->json(['status' => true, 'sucursal' => $sucursal[0]->sucursal], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
