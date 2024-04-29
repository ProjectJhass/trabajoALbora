<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios\admin;

use App\Exports\ExportInfoServiciosTecnicos;
use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use App\Models\apps\servicios_tecnicos\servicios\ModelServiciosEliminados;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ControllerInformes extends Controller
{
    protected function tableInfo()
    {
        $data = ModelNuevaSolicitud::select('id_st', 'almacen', 'nombre', 'articulo', 'inconveniente', 'respuesta_st', 'proceso', 'estado', 'created_at')
            ->where('estado', '<>', 'Definido')
            ->get();

        return view('apps.servicios_tecnicos.servicios_tecnicos.seguimiento.table', ['data' => $data])->render();
    }

    public function getInformes()
    {
        $table = self::tableInfo();
        return view('apps.servicios_tecnicos.servicios_tecnicos.seguimiento.reporte', ['table' => $table]);
    }

    public function exportInfo(Request $request)
    {
        $fecha_i = $request->fecha_i;
        $almacen = $request->id_co_new_ost;

        $fecha_f = date("Y-m-d", strtotime(date('Y-m-d') . "+ 1 days"));

        return Excel::download(new ExportInfoServiciosTecnicos($fecha_i, $fecha_f, $almacen), 'info-solicitudes-servicios-tecnicos.xlsx');
    }

    public function deleteServicioTecnico(Request $request)
    {
        $id = $request->id;
        $data_ =  ModelNuevaSolicitud::find($id);

        if ($data_) {
            ModelServiciosEliminados::create($data_->toArray());
            $data_->delete();
            $table = self::tableInfo();
            return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
        return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
