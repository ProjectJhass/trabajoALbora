<?php

namespace App\Http\Controllers\apps\automoviles;

use App\Http\Controllers\Controller;
use App\Models\apps\automoviles\ModelAutomoviles;
use App\Models\apps\automoviles\ModelKmRecorridos;
use App\Models\soap\autos_ModelConsultas;
use Illuminate\Http\Request;

class ControllerComparativoGeneral extends Controller
{
    public function index(Request $request)
    {
        $fecha_i = (!empty($request->fecha_i_com)) ? $request->fecha_i_com . "-01" : date('Y-m') . "-01";

        $fecha_f_ = !empty($request->fecha_f_com) ? $request->fecha_f_com . "-01" : date('Y-m') . "-01";
        $data_fecha_f = date('Y-m-d', strtotime($fecha_f_ . " + 1 month"));
        $fecha_f = date('Y-m-d', strtotime($data_fecha_f . " - 1 day"));

        $n = 0;

        $tabla = '';
        $tabla .= '<table class="table table-bordered table-sm" id="table-reporte-placas-general">
        <thead>
            <tr class="text-center bg-danger">
                <th>#</th>
                <th>PLACA</th>
                <th>Km Recorridos</th>
                <th>Gastos en combustible</th>
                <th>Gastos de mantenimiento</th>
            </tr>
        </thead>
        <tbody class="text-center"> ';

        $autos = ModelAutomoviles::all();
        foreach ($autos as $key => $value) {
            $n++;
            $rowid = $value->row_id;
            $placa = $value->placa;

            $km = 0;
            $info_km = ModelKmRecorridos::where('placa', $placa)->whereBetween('fecha', [$fecha_i, $fecha_f])->get();
            foreach ($info_km as $key => $value) {
                $km += str_replace(",", ".", $value->km_recorridos);
            }

            $gasolina = autos_ModelConsultas::ObtenerGastoGasolinaRangoAuto($rowid, $fecha_i, $fecha_f);
            $mantenimiento = autos_ModelConsultas::ObtenerGastosMttoRangoAuto($rowid, $fecha_i, $fecha_f);

            $tabla .= '<tr>
            <td>' . $n . '</td>
            <td class="text-left">' . $placa . '</td>
            <td>' . $km . '</td>
            <td>$ ' . number_format($gasolina) . '</td>
            <td>$ ' . number_format($mantenimiento) . '</td>
        </tr>';
        }
        $tabla .= '
        </tbody>
    </table>';

        return response()->json(['status' => true, 'data' => $tabla], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
