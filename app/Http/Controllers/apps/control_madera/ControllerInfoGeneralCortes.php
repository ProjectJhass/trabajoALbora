<?php

namespace App\Http\Controllers\apps\control_madera;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\ModelConsecutivosMadera;
use App\Models\apps\control_madera\ModelCortesPlanificados;
use App\Models\apps\control_madera\ModelPiezasPlanificadasCorte;
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
        $cortes_p = ModelCortesPlanificados::where("estado", "Completado")->orderBy("created_at")->get();
        return view('apps.control_madera.app.planner.cortes_planificados.planificados', ['estado' => 'Completados', 'cortes' => $cortes_p]);
    }

    public function getinfoTroncosUtilizados(Request $request)
    {
        $id_pieza = $request->id_pieza;
        $dataTable = '<table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>Consecutivo</th>
                <th>Pulgadas</th>
            </tr>
        </thead>
        <tbody class="text-center">';
        $piezas_ = ModelPiezasPlanificadasCorte::find($id_pieza);
        $troncos = explode(",", $piezas_->troncos_utilizados);
        sort($troncos);
        foreach ($troncos as $key => $value) {
            $pulgadas_ = ModelConsecutivosMadera::find($value);
            $pulgadas = $pulgadas_->pulgadas;
            $dataTable .= '<tr>
           <td>' . $value . '</td>
           <td>' . number_format($pulgadas) . '</td>
           </tr>';
        }
        $dataTable .= '</tbody>
        </table>';

        return response()->json(['status' => true, 'table' => $dataTable], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
