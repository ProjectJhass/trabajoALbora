<?php

namespace App\Http\Controllers\apps\automoviles;

use App\Http\Controllers\Controller;
use App\Models\apps\automoviles\ModelAutomoviles;
use App\Models\apps\automoviles\ModelKmRecorridos;
use App\Models\soap\autos_ModelConsultas;
use Illuminate\Http\Request;

class ControllerComparativo extends Controller
{
    public function index()
    {
        $autos = ModelAutomoviles::all();
        return view('apps.automoviles.comparativo.comparativo', ['autos' => $autos]);
    }

    public function informacionAutos(Request $request)
    {
        $imagen = '';
        $rowid = $request->placa;
        if (!empty($rowid)) {

            $info_auto_ = ModelAutomoviles::where('row_id', $rowid)->first();

            $fecha_f_ = !empty($request->fecha_f) ? $request->fecha_f : date('Y-m-d');
            $data_fecha_f = date('Y-m-d', strtotime($fecha_f_ . " + 1 month"));

            $fecha_i = !empty($request->fecha_i) ? $request->fecha_i . "-01" : date('Y-m-d');
            $fecha_f = date('Y-m-d', strtotime($data_fecha_f . " - 1 day"));

            $km = 0;
            $info_km = ModelKmRecorridos::where('placa', $info_auto_->placa)->whereBetween('fecha', [$fecha_i, $fecha_f])->get();
            foreach ($info_km as $key => $value) {
                $km += str_replace(",", ".", $value->km_recorridos);
            }

            $gasolina = autos_ModelConsultas::ObtenerGastoGasolinaRangoAuto($rowid, $fecha_i, $fecha_f);
            $mantenimiento = autos_ModelConsultas::ObtenerGastosMttoRangoAuto($rowid, $fecha_i, $fecha_f);

            $imagen .= '<div class="card card-outline card-secondary">
                <div class="card-header">
                    <strong>Resumen: </strong> ' . $info_auto_->placa . '
                </div>
                <div class="card-body">
                    <p><strong>Km recorridos:</strong> ' . $km . ' km</p>
                    <p><strong>Gastos en combustible:</strong> $ ' . number_format($gasolina) . '</p>
                    <p><strong>Gastos de mantenimiento:</strong> $ ' . number_format($mantenimiento) . '</p>
                </div>
            </div>';
        }

        return response()->json(['status' => true, 'informacion' => $imagen], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
