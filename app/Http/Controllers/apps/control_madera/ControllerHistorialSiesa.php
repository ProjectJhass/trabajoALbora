<?php

namespace App\Http\Controllers\apps\control_madera;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\ModelHistorialOpsCreadas;
use Illuminate\Http\Request;

class ControllerHistorialSiesa extends Controller
{
    public function index()
    {
        $fecha = date("Y-m-d");
        $table = self::getInfoHistorial($fecha, $fecha);
        return view('apps.control_madera.app.siesa.historialOps', ['table' => $table]);
    }

    public function getInfoHistorial($fecha_i, $fecha_f)
    {
        $fecha_f = date("Y-m-d", strtotime($fecha_f . "+1 day"));
        $info = ModelHistorialOpsCreadas::join("codigos_siesa as c", "c.codigo", "=", "codigo_item")
            ->select('historial_ops_creadas.*', 'c.nombre as tipo')
            ->whereBetween("historial_ops_creadas.created_at", [$fecha_i, $fecha_f])
            ->get();
        return view('apps.control_madera.app.siesa.tables.tableOpCreada', ['info' => $info])->render();
    }

    public function getInfoRangoFecha(Request $request)
    {
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $table = self::getInfoHistorial($fecha_i, $fecha_f);
        return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
