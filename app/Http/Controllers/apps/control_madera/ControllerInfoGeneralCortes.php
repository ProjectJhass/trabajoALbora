<?php

namespace App\Http\Controllers\apps\control_madera;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\ModelConsecutivosMadera;
use App\Models\apps\control_madera\ModelCortesPiezaFavor;
use App\Models\apps\control_madera\ModelCortesPlanificados;
use App\Models\apps\control_madera\ModelInfoTablasCortadas;
use App\Models\apps\control_madera\ModelPiezasPlanificadasCorte;
use App\Models\apps\control_madera\ModelPlannerTabla;
use Illuminate\Http\Request;

class ControllerInfoGeneralCortes extends Controller
{
    public function index()
    {
        $cortes_p = ModelCortesPlanificados::where("estado", "Pendiente")->orderBy("created_at")->get();
        return view('apps.control_madera.app.planner.cortes_planificados.planificados', ['estado' => 'Pendientes', 'cortes' => $cortes_p]);
    }

    public function piezasPlanificadas(Request $request)
    {
        $id_corte = $request->id_corte;
        $cortes_planificados = ModelCortesPlanificados::find($id_corte);
        $piezas_planificadas = ModelPiezasPlanificadasCorte::where("id_plan", $id_corte)->get();

        $series = view('apps.control_madera.app.planner.cortes_planificados.info.seriesCortes', ['planner' => $cortes_planificados])->render();
        $piezas = view('apps.control_madera.app.planner.cortes_planificados.info.tables', ['piezas' => $piezas_planificadas])->render();
        return view('apps.control_madera.app.planner.cortes_planificados.infoCortesGeneral', ['series_cortes' => $series, 'piezas_series_planeadas' => $piezas]);
    }

    public function cortesTerminados()
    {
        $fecha_i = date("Y-m-d");
        $fecha_f = date("Y-m-d", strtotime($fecha_i . "+ 1 day"));
        $cortes_p = ModelCortesPlanificados::where("estado", "Completado")->whereBetween("created_at", [$fecha_i, $fecha_f])->get();
        $table = view('apps.control_madera.app.planner.cortes_terminados.tables.tableInfo', ['cortes' => $cortes_p])->render();
        return view('apps.control_madera.app.planner.cortes_terminados.infoGeneral', ['tableCorteTerminado' => $table]);
    }

    public function piezasTerminadas(Request $request)
    {
        $id_corte = $request->id_corte;
        $cortes_planificados = ModelCortesPlanificados::find($id_corte);
        $piezas_planificadas = ModelPiezasPlanificadasCorte::where("id_plan", $id_corte)->get();

        $piezas_a_favor_planificada = ModelCortesPiezaFavor::join("cortes_piezas_wood as cpw", "cpw.id", '=', 'cortes_pieza_a_favor.id_a_favor')
        ->where("cortes_pieza_a_favor.id_plan", $id_corte)->get();

        $pulgadas_cortadas_a_favor = 0;

        foreach ($piezas_a_favor_planificada as $key => $val) {

            if($val->madera=="Pino Cipres" || $val->madera=="Flormorado") {
                $pulgadas_cortadas_a_favor += round(((($val->ancho * $val->grueso * $val->largo) * $val->cantidad) / 1550));
            } else {
                // $info_g = ModelInfoTablasCortadas::where("id_corte",$id_corte)->get();
                // foreach ($info_g as $key => $madera_v) {
                //     $pulgadas_cortadas_a_favor += round(((($madera_v->ancho_tabla)*1.9*($madera_v->cantidad_tabla)*300)/1550));
                // }
            }

        }

        return view('apps.control_madera.app.planner.cortes_terminados.infoCortesTerminados', ['planner' => $cortes_planificados, 'piezas' => $piezas_planificadas, "pulgadas_cortadas_a_favor" => $pulgadas_cortadas_a_favor]);
    }

    public function filtrarCortesTerminados(Request $request)
    {
        $fecha_i = $request->fecha_i;
        $fecha_f = date("Y-m-d", strtotime($request->fecha_f . "+ 1 day"));
        $reporte = $request->reporte;

        switch ($reporte) {
            case 'series':
                $cortes_p = ModelCortesPlanificados::where("estado", "Completado")->whereBetween("created_at", [$fecha_i, $fecha_f])->get();
                $table = view('apps.control_madera.app.planner.cortes_terminados.tables.tableInfo', ['cortes' => $cortes_p])->render();
                break;
            case 'tablas':
                $tablas_p = ModelPlannerTabla::where("estado", "Terminado")->whereBetween("created_at", [$fecha_i, $fecha_f])->get();
                $table = view('apps.control_madera.app.planner.cortes_terminados.tables.corteTabla', ['info' => $tablas_p])->render();
                break;
        }


        return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function getinfoTroncosUtilizados(Request $request)
    {
        $id_pieza = $request->id_pieza;
        $piezas_ = ModelPiezasPlanificadasCorte::find($id_pieza);
        $dataTable = '<div class="row">
                        <div class="col-md-6">
                            <div class="card-box table-responsive">
                                <p class="text-muted font-13 m-b-30">
                                    Bloques planeados
                                </p>
                                <table id="datatableMadera" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr class="text-center">
                                        <th>Consecutivo</th>
                                        <th>Pulgadas</th>
                                        <th>Largo</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-center">';

        $troncos = array_filter(array_map('trim', explode(",", $piezas_->troncos)));
        sort($troncos);
        foreach ($troncos as $key => $value) {
            $pulgadas_ = ModelConsecutivosMadera::find($value);
            if ($pulgadas_) {
                $pulgadas = $pulgadas_->pulgadas;
                $dataTable .= '<tr>
                                        <td>' . $value . '</td>
                                        <td>' . number_format($pulgadas) . '</td>
                                        <td>' . $pulgadas_->largo . 'm</td>
                                        </tr>';
            }
        }
        $dataTable .= '</tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-box table-responsive">
                                <p class="text-muted font-13 m-b-30">
                                    Bloques utilizados
                                </p>
                                <table id="datatableMadera" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr class="text-center">
                                        <th>Consecutivo</th>
                                        <th>Pulgadas</th>
                                        <th>Largo</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-center">';

        $troncos = array_filter(array_map('trim', explode(",", $piezas_->troncos_utilizados)));
        sort($troncos);
        foreach ($troncos as $key => $value) {
            $pulgadas_ = ModelConsecutivosMadera::find($value);
            if ($pulgadas_) {
                $pulgadas = $pulgadas_->pulgadas;
                $dataTable .= '<tr>
                                        <td>' . $value . '</td>
                                        <td>' . number_format($pulgadas) . '</td>
                                        <td>' . $pulgadas_->largo . 'm</td>
                                        </tr>';
            }
        }
        $dataTable .= '</tbody>
                                </table>
                            </div>
                        </div>
                    </div>';
        return response()->json(['status' => true, 'table' => $dataTable], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

}
