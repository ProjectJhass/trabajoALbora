<?php

namespace App\Http\Controllers\apps\control_madera;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\ModelCantidadesFavor;
use App\Models\apps\control_madera\ModelConsecutivosMadera;
use App\Models\apps\control_madera\ModelCortesPiezaFavor;
use App\Models\apps\control_madera\ModelInfoMueble;
use App\Models\apps\control_madera\ModelInfoPiezasMueble;
use App\Models\apps\control_madera\ModelInfoSerie;
use App\Models\apps\control_madera\ModelLogs;
use App\Models\apps\control_madera\ModelPiezasMaderaFavor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerPlannerMadera extends Controller
{
    public function planner()
    {
        $series = ModelInfoSerie::all();
        $piezas_favor = ModelPiezasMaderaFavor::whereIn("estado", ["En uso","Por confirmar"])->get();
        foreach ($piezas_favor as $key => $value) {
            $pf = ModelPiezasMaderaFavor::find($value->id);
            $pf->cantidad_disponible = $pf->cantidad_inicial;
            $pf->estado = "Pendiente";
            $pf->pieza = null;
            $pf->save();
            ModelCortesPiezaFavor::where("estado", "Por confirmar")->where("id_a_favor", $value->id)->delete();
        }
        ModelConsecutivosMadera::where("estado","En uso")->update(["estado"=>"Activo"]);
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

        $madera_a_favor = ModelPiezasMaderaFavor::where("id_madera", $id_madera)->where("estado", "Pendiente")->count();

        $options = '<option value="">Seleccionar...</option>';
        foreach ($valores as $key => $value) {
            $options .= '<option value="' . $value->id_mueble . '">' . $value->mueble . '</option>';
        }

        return response()->json(['status' => true, 'valores' => $options, 'vlr_madera' => $madera_a_favor], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
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

        $arrayFlormorado = array(['clave' => '1.5-1.8', 'valor' => '1.50m - 1.80m'], ['clave' => '1.81-2.2', 'valor' => '1.81m - 2.20m'], ['clave' => '2.21-2.70', 'valor' => '2.21m - 2.70m'], ['clave' => '2.71-3', 'valor' => '2.71m - 3m']);
        $arrayVP = array(['clave' => '2.8-3', 'valor' => '2.8m - 3m']);

        switch ($id_madera) {
            case '1':
                $arrayRango = $arrayVP;
                break;
            case '2':
                $arrayRango = $arrayFlormorado;
                break;
            case '3':
                $arrayRango = $arrayVP;
                break;
        }

        $data_piezas = ModelInfoPiezasMueble::where('id_mueble', $id_mueble)
            ->where('id_serie', $id_serie)
            ->where('id_madera', $id_madera)
            ->where('estado', '<>', 0)
            ->get();

        if (count($data_piezas) > 0) {
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

                $troncos = ModelConsecutivosMadera::where('estado', 'Activo')->where("id_info_madera", $id_madera)->get();

                $form_ .= '<div class="bd-example mb-4">
                    <div class="accordion" id="accordionPlanner' . $ban . '">
                        <div class="accordion-item">
                            <h4 class="accordion-header" id="headingPlanner' . $ban . '">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePlanner' . $ban . '" aria-expanded="true" aria-controls="collapsePlanner' . $ban . '">
                                ' . $value->pieza . '
                                </button>
                                <input hidden type="text" value="' . $value->pieza . '" name="name_pieza_planner' . $ban . '" id="name_pieza_planner' . $ban . '">
                                <input hidden type="text" value="' . $value->id . '" name="id_pieza_planner' . $ban . '" id="id_pieza_planner' . $ban . '">
                            </h4>
                            <div id="collapsePlanner' . $ban . '" class="accordion-collapse collapse show" aria-labelledby="headingPlanner' . $ban . '" data-bs-parent="#accordionPlanner' . $ban . '">
                                <div class="accordion-body">
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
                                        <label for="">Cantidad</label>
                                        <input type="text" hidden class="form-control" value="' . $cantidad_requerida_r . '" name="cantidad_pieza_r' . $ban . '" style="color: white !important; background-color: #248c32; text-align: center;" id="cantidad_pieza_r' . $ban . '">
                                        <input type="text" class="form-control" value="' . $cantidad_requerida . '" name="cantidad_pieza' . $ban . '" style="color: white !important; background-color: #248c32; text-align: center;" id="cantidad_pieza' . $ban . '">
                                        <span style="cursor:pointer" onclick="addPiezasFavorPlanificacionGenerada(\'' . $ban . '\')">A favor: <i class="fas fa-plus-circle text-danger"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <div class="form-group">
                                        <label class="text-danger">Largo del bloque<small></small></label>
                                        <select class="form-control" onchange="consultarPulgadasRequeridas(\'' . $ban . '\',this.value)" name="largo_bloque' . $ban . '" id="largo_bloque' . $ban . '">
                                        <option value=""></option>';
                foreach ($arrayRango as $key => $value) {
                    $form_ .= '<option value="' . $value['clave'] . '">' . $value['valor'] . '</option>';
                }
                $form_ .= '</select>
                                    </div>
                                </div>
                                <div class="col-md-1 mb-3">
                                    <div class="form-group">
                                        <label class="text-danger">Calidad</label>
                                        <select class="form-control" name="calidad_corte' . $ban . '" id="calidad_corte' . $ban . '">
                                        <option value=""></option>
                                        <option value="Excelente">Excelente</option>
                                        <option value="Buena">Buena</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1 mb-3">
                                    <div class="form-group">
                                        <label for="">Pulgadas</label>
                                        <input type="text" class="form-control" onchange="buscarTroncosObjetivos(\'' . $ban . '\',this.value)" style="background-color: #e3e3e3; text-align: center;" name="pulgadas_utilizadas' . $ban . '" id="pulgadas_utilizadas' . $ban . '">
                                        <span>Suma: <span class="badge badge-pill bg-danger" id="sumPulg' . $ban . '">0</span></span>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <div class="form-group">
                                        <label class="text-danger">Bloque</label>
                                        <select id="troncos' . $ban . '" name="troncos' . $ban . '" onchange="troncoSeleccionado(\'' . $ban . '\', this.value)" class="form-control">
                                            <option value=""></option>
                                        </select>
                                     <input type="text" class="form-control" hidden name="troncoNum' . $ban . '" id="troncoNum' . $ban . '">
                                     <div id="troncos_selected' . $ban . '"></div>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <div class="form-group">
                                        <label class="text-danger">Observaciones</label>
                                        <textarea class="form-control" name="obs_plan_generado' . $ban . '" id="obs_plan_generado' . $ban . '" cols="30" rows="1"></textarea>
                                    </div>
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
        } else {
            $form_ .= 'No hay información para esta serie, intenta con una diferente';
        }

        ModelLogs::create([
            'accion' => 'El usuario ' . Auth::user()->nombre . ' generó una nueva planificación para corte de serie',
            'usuario' => Auth::user()->nombre
        ]);

        return response()->json(['status' => true, 'planilla' => $form_], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function getInfoPiezasPorTipoDeMadera(Request $request)
    {
        $id_madera = $request->id_madera;
        $madera_a_favor = ModelPiezasMaderaFavor::select('largo', 'ancho', 'grueso', 'cantidad_disponible as cantidad_inicial', 'madera')->where("id_madera", $id_madera)->where("estado", "Pendiente")->get();
        $table = view("apps.control_madera.app.wood.iniciar_corte.tablePiezasMadera", ["info" => $madera_a_favor])->render();

        return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function getInfoUtilizarPiezasMadera(Request $request)
    {
        $id_madera = $request->id_madera;
        $cantidad = $request->cantidad;
        $consecutivo = $request->consecutivo;

        $madera_a_favor = ModelPiezasMaderaFavor::select('id', 'largo', 'ancho', 'grueso', 'cantidad_disponible as cantidad', 'madera')->where("id_madera", $id_madera)->whereIn("estado",["Pendiente","Por confirmar"])->get();
        $table = view("apps.control_madera.app.planner.planner.tableModificarFavor", ["info" => $madera_a_favor, "cantidad_pieza" => $cantidad, 'consecutivo'=>$consecutivo])->render();

        return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function updateInfoPiezasDisponibles(Request $request) {
        $bandera = $request->cantidad_ciclo_maderas_;
        $cantidad_requerida = 0;
        $id_pieza_frm = $request->id_pieza_form;

        for ($i=1; $i <= $bandera ; $i++) { 
            $id_pieza_wood = $request["item_id_$i"];
            $cantidad = !empty($request["cantidad_utilizar$i"])?$request["cantidad_utilizar$i"]:0;
            
            $cantidad_requerida += $cantidad;

             $getPiezaWood = ModelPiezasMaderaFavor::find($id_pieza_wood);
             $cant_dispo = $getPiezaWood->cantidad_disponible;

             $cantidad_final = $cant_dispo - $cantidad;
             if($cantidad_final==0){
                 $getPiezaWood->estado = "En uso";
                 $getPiezaWood->pieza = $id_pieza_frm;
             }else{
                $getPiezaWood->estado = "Por confirmar";
             }

             $getPiezaWood->cantidad_disponible = $cantidad_final;
             $getPiezaWood->save(); 
             self::insertInfoPiezasUsed($id_pieza_frm, $id_pieza_wood, $cantidad);
        }

         return response()->json(["status" => true, "cantidad_requerida"=>$cantidad_requerida], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function insertInfoPiezasUsed( $id_pieza, $id_pieza_a_favor, $cantidad ){
        if($cantidad != 0 ) {
            ModelCortesPiezaFavor::create([
                'id_pieza' => $id_pieza,
                'id_a_favor' => $id_pieza_a_favor,
                'cantidad' => $cantidad,
                'estado' => "Por confirmar"
            ]);
        }
    }
}
