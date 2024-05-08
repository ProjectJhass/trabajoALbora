<?php

namespace App\Http\Controllers\apps\intranet;

use App\Exports\ExportInformeFirmasDescansos;
use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelFirmasDescansosCompensatorios;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ControllerFirmasDescansos extends Controller
{
    public function index()
    {
        $fecha_i = date("Y-m-01");
        $fecha_f = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 days"));
        $table = self::tableInfo($fecha_i, $fecha_f);
        return view('apps.intranet.rrhh.descansos', ["table" => $table]);
    }

    public function tableInfo($fecha_i, $fecha_f)
    {
        $fecha_f = date("Y-m-d", strtotime($fecha_f . "+ 1 days"));
        $info_ = ModelFirmasDescansosCompensatorios::whereBetween("created_at", [$fecha_i, $fecha_f])->get();
        return view("apps.intranet.rrhh.tables.tableDescanso", ["info" => $info_])->render();
    }

    public function searchInfoDescansos(Request $request)
    {
        $fecha_i = $request->fecha_i;
        $fecha_f = date("Y-m-d", strtotime($request->fecha_f . "+ 1 days"));
        $table = self::tableInfo($fecha_i, $fecha_f);

        return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function detalleDelaFirma($id)
    {
        $info_ = ModelFirmasDescansosCompensatorios::find($id);
        return view('apps.intranet.rrhh.detalleDescanso', ["info" => $info_]);
    }

    public function export(Request $request)
    {
        return Excel::download(new ExportInformeFirmasDescansos($request->fecha_i, $request->fecha_f), 'firmas-generadas-descansos.xlsx');
    }
}
