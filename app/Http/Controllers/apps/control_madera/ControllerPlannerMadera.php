<?php

namespace App\Http\Controllers\apps\control_madera;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\ModelCantidadesFavor;
use App\Models\apps\control_madera\ModelConsecutivosMadera;
use App\Models\apps\control_madera\ModelInfoMueble;
use App\Models\apps\control_madera\ModelInfoPiezasMueble;
use App\Models\apps\control_madera\ModelInfoSerie;
use Illuminate\Http\Request;

class ControllerPlannerMadera extends Controller
{
    public function planner()
    {
        $series = ModelInfoSerie::all();
        return view('apps.control_madera.app.planner.planner.planificar', ['series' => $series]);
    }

    public function searchMadera(Request $request)
    {
        $valor = $request->valor;
        $options = '<option value="">Seleccionar...</option>';
        $valores = ModelInfoMueble::join('info_tipo_madera as t', 't.id_madera', '=', 'info_muebles.id_madera')
            ->select(['t.id_madera', 't.nombre_madera'])
            ->where('id_serie', $valor)
            ->distinct()
            ->get();

        foreach ($valores as $key => $value) {
            $options .= '<option value="' . $value->id_madera . '">' . $value->nombre_madera . '</option>';
        }

        return response()->json(['status' => true, 'valores' => $options], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function searchMueble(Request $request)
    {
        $id_serie = $request->serie;
        $id_madera = $request->madera;

        $valores = ModelInfoMueble::where('id_serie', $id_serie)
            ->where('id_madera', $id_madera)
            ->where('estado', '1')
            ->get();

        $options = '<option value="">Seleccionar...</option>';
        foreach ($valores as $key => $value) {
            $options .= '<option value="' . $value->id_mueble . '">' . $value->mueble . '</option>';
        }

        return response()->json(['status' => true, 'valores' => $options], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function createPlanificacionSerie(Request $request)
    {
        $id_serie = $request->serie_planner;
        $id_madera = $request->madera_planner;
        $id_mueble = $request->mueble_planner;
        $cantidad = $request->cantidad_planner;
        $cantidad = $cantidad + ($cantidad * 0.01);
        $form_ = '';
        $ban = 1;

        $data_piezas = ModelInfoPiezasMueble::where('id_mueble', $id_mueble)
            ->where('id_serie', $id_serie)
            ->where('id_madera', $id_madera)
            ->get();

        foreach ($data_piezas as $key => $value) {

            $largo = str_replace(",", ".", $value->largo) + 1;
            $ancho = str_replace(",", ".", $value->ancho) + 1;
            $grueso = str_replace(",", ".", $value->grueso) + 1;

            $cantidad_p = $value->cantidad_pieza;
            $cantidad_requerida = round(($cantidad_p * $cantidad));
            $cantidad_requerida_r = round(($cantidad_p * $cantidad));

            $cantidad_fav = 0;

            $id_pieza =  $value->id;
            $cantidad_favor = ModelCantidadesFavor::where("id_pieza", $id_pieza)->where("estado", "Pendiente")->first();
            if ($cantidad_favor) {
                $cantidad_fav = $cantidad_favor->cantidad;
                if ($cantidad_fav >= $cantidad_requerida) {
                    $cantidad_requerida = 0;
                } else {
                    $cantidad_requerida = $cantidad_requerida - $cantidad_fav;
                }
            } else {
                $cantidad_requerida = $cantidad_requerida;
            }

            $troncos = ModelConsecutivosMadera::where('estado', 'Activo')->get();

            $form_ .= '<div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><strong>' . $value->pieza . '</strong></h2>
                            <input hidden type="text" value="' . $value->pieza . '" name="name_pieza_planner' . $ban . '" id="name_pieza_planner' . $ban . '">
                            <input hidden type="text" value="' . $value->id . '" name="id_pieza_planner' . $ban . '" id="id_pieza_planner' . $ban . '">
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>                        
                        <div class="x_content">
                            <div class="row">
                                <div class="col-md-1 mb-3">
                                    <div class="form-group">
                                        <label for="">Largo</label>
                                        <input type="text" class="form-control" style="background-color: #e3e3e3; text-align: center;" value="' . $largo . '" name="largo_pieza' . $ban . '"
                                            id="largo_pieza' . $ban . '">
                                    </div>
                                </div>
                                <div class="col-md-1 mb-3">
                                    <div class="form-group">
                                        <label for="">Ancho</label>
                                        <input type="text" class="form-control" style="background-color: #e3e3e3; text-align: center;" value="' . $ancho . '" name="ancho_pieza' . $ban . '"
                                            id="ancho_pieza' . $ban . '">
                                    </div>
                                </div>
                                <div class="col-md-1 mb-3">
                                    <div class="form-group">
                                        <label for="">Grueso</label>
                                        <input type="text" class="form-control" style="background-color: #e3e3e3; text-align: center;" value="' . $grueso . '" name="grueso_pieza' . $ban . '" id="grueso_pieza' . $ban . '">
                                    </div>
                                </div>
                                <div class="col-md-1 mb-3">
                                    <div class="form-group">
                                        <label for="">Cant requerida</label>
                                        <input type="text" hidden class="form-control" value="' . $cantidad_requerida_r . '" name="cantidad_pieza_r' . $ban . '" style="color: white; background-color: #248c32; text-align: center;" id="cantidad_pieza_r' . $ban . '">
                                        <input type="text" class="form-control" value="' . $cantidad_requerida . '" name="cantidad_pieza' . $ban . '" style="color: white; background-color: #248c32; text-align: center;" id="cantidad_pieza' . $ban . '">
                                        <span>A favor: ' . $cantidad_fav . '</span>
                                    </div>
                                </div>
                                <div class="col-md-1 mb-3">
                                    <div class="form-group">
                                        <label for="">L. bloque <small>(cm)</small></label>
                                        <input type="number" class="form-control" onchange="consultarPulgadasRequeridas(\'' . $ban . '\',this.value)" name="largo_bloque' . $ban . '" id="largo_bloque' . $ban . '">
                                    </div>
                                </div>
                                <div class="col-md-1 mb-3">
                                    <div class="form-group">
                                        <label for="">Pulgadas total</label>
                                        <input type="text" class="form-control" onchange="buscarTroncosObjetivos(\'' . $ban . '\',this.value)" style="background-color: #e3e3e3; text-align: center;" name="pulgadas_utilizadas' . $ban . '" id="pulgadas_utilizadas' . $ban . '">
                                        <span>Suma: <span class="badge badge-pill badge-danger" id="sumPulg' . $ban . '">0</span></span>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <div class="form-group">
                                        <label for="">Tronco</label>
                                        <select id="troncos' . $ban . '" name="troncos' . $ban . '" onchange="troncoSeleccionado(\'' . $ban . '\', this.value)" class="form-control">
                                            <option value=""></option>';
            foreach ($troncos as $key => $value) {
                $form_ .= '<option value="' . $value->id . ' - ' . number_format($value->pulgadas) . '″ ' . $value->tipo_madera . '">' . $value->id . ' - ' . number_format($value->pulgadas) . '″ ' . $value->tipo_madera . '</option>';
            }
            $form_ .= '</select>
                                     <input type="text" class="form-control" hidden name="troncoNum' . $ban . '" id="troncoNum' . $ban . '">
                                     <div id="troncos_selected' . $ban . '"></div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="">Observaciones</label>
                                        <input type="text" class="form-control" name="obs_plan_generado' . $ban . '" id="obs_plan_generado' . $ban . '">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
            $ban++;
        }
        $form_ .= '<center><button type="button" onclick="CrearPlanCorteMadera()" name="btnCantTotal" id="btnCantTotal" value="' . $ban . '" class="btn btn-danger">Guardar Planificación</button></center>';

        return response()->json(['status' => true, 'planilla' => $form_], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
