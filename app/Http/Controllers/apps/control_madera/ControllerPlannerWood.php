<?php

namespace App\Http\Controllers\apps\control_madera;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\ModelCantidadesFavor;
use App\Models\apps\control_madera\ModelConsecutivosMadera;
use App\Models\apps\control_madera\ModelCortesPlanificados;
use App\Models\apps\control_madera\ModelInfoMadera;
use App\Models\apps\control_madera\ModelInfoMueble;
use App\Models\apps\control_madera\ModelInfoPiezasMueble;
use App\Models\apps\control_madera\ModelInfoSerie;
use App\Models\apps\control_madera\ModelInfoTablasCortadas;
use App\Models\apps\control_madera\ModelLogs;
use App\Models\apps\control_madera\ModelPiezasMaderaFavor;
use App\Models\apps\control_madera\ModelPiezasPlanificadasCorte;
use App\Models\apps\control_madera\ModelPlannerTabla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerPlannerWood extends Controller
{
    public function index()
    {
        $cortes_p = ModelCortesPlanificados::where("estado", "Pendiente")->orderBy("created_at")->get();
        $tablas_p = ModelPlannerTabla::where("estado", "Pendiente")->orderBy("created_at")->get();
        $view = self::renderCortes($cortes_p);
        $tablas = view('apps.control_madera.app.wood.tableCorteTabla', ['info' => $tablas_p])->render();
        return view("apps.control_madera.app.wood.cortes", ["cortes" => $view, 'tablas' => $tablas]);
    }

    public function renderCortes($cortes)
    {
        return view("apps.control_madera.app.wood.cortes_p", ["cortes" => $cortes])->render();
    }

    public function infoPiezasCorte(Request $request)
    {
        $id_corte = $request->id_corte;
        $series = ModelInfoSerie::all();
        $cortes_planificados = ModelCortesPlanificados::find($id_corte);
        $piezas_planificadas = ModelPiezasPlanificadasCorte::where("id_plan", $id_corte)->get();
        $val_t = 0;
        $can_tablas = ModelInfoTablasCortadas::where("id_corte", $id_corte)->get();
        foreach ($can_tablas as $key => $value) {
            $val_t += $value->cantidad_tabla;
        }
        $view = self::renderPiezasInfo($piezas_planificadas);

        $info_g = ModelPiezasMaderaFavor::where("id_corte", $id_corte)->get();
        $view_p = view("apps.control_madera.app.wood.iniciar_corte.tablePiezasMadera", ["info" => $info_g])->render();

        return view("apps.control_madera.app.wood.iniciar_corte.piezas", ['planner' => $cortes_planificados, 'piezas_corte' => $view, 'series' => $series, 'cant_tablas' => $val_t, 'table_info' => $view_p, 'id_corte'=>$id_corte]);
    }

    public function renderPiezasInfo($piezas)
    {
        return view("apps.control_madera.app.wood.iniciar_corte.piezas_info", ['piezas' => $piezas])->render();
    }

    public function addTroncoUtilizado(Request $request)
    {
        $id_pieza = $request->id_pieza;
        $tronco = $request->tronco;
        $pulgadas_cortadas = 0;

        $info_tronco = ModelConsecutivosMadera::find($tronco);

        if ($info_tronco->estado == "Activo") {

            $info_ = ModelPiezasPlanificadasCorte::find($id_pieza);
            $tronco_db = $info_->troncos_utilizados;
            $info_->troncos_utilizados = empty($tronco_db) ? $tronco : $tronco_db . "," . $tronco;
            $info_->save();

            $pulgadas_tronco = $info_tronco->pulgadas;
            $pulgadas_restantes =  $info_->pulgadas_resta;

            $info_tronco->estado = "En corte";
            $info_tronco->save();

            $info_p = ModelPiezasPlanificadasCorte::where("id_plan", $info_->id_plan)->get();
            foreach ($info_p as $key => $val) {
                $bloques = explode(",", $val->troncos_utilizados);
                foreach ($bloques as $key => $bloque) {
                    $info_c = ModelConsecutivosMadera::find($bloque);
                    $pulgadas_cortadas += $info_c->pulgadas;
                }
            }

            $data_c = ModelCortesPlanificados::find($info_->id_plan);
            $data_c->pulgadas_cortadas = $pulgadas_cortadas;
            $data_c->save();

            ModelLogs::create([
                'accion' => 'El usuario ' . Auth::user()->nombre . ' utilizó el bloque #' . $tronco . ' para corte de serie en la woodniser',
                'usuario' => Auth::user()->nombre
            ]);

            return response()->json(['status' => true, 'tronco' => number_format($tronco), 'pulgadas' => number_format($pulgadas_tronco), 'utilizables' => number_format($pulgadas_restantes)], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function deleteTroncoUtilizado(Request $request)
    {
        $id_pieza = $request->id_pieza;
        $tronco = $request->tronco;
        $pulgadas_cortadas = 0;

        $info_ = ModelPiezasPlanificadasCorte::find($id_pieza);
        $tronco_db = $info_->troncos_utilizados;

        $troncos_all = explode(",", $tronco_db);
        if (($key = array_search($tronco, $troncos_all)) !== false) {
            unset($troncos_all[$key]);
        }

        $troncos_all = array_values($troncos_all);
        $tronco_db_updated = implode(",", $troncos_all);

        $info_->troncos_utilizados = $tronco_db_updated;
        $info_->save();

        $info_tronco = ModelConsecutivosMadera::find($tronco);
        $info_tronco->estado = "Activo";
        $info_tronco->save();

        $info_p = ModelPiezasPlanificadasCorte::where("id_plan", $info_->id_plan)->get();
        foreach ($info_p as $key => $val) {
            $bloques = explode(",", $val->troncos_utilizados);
            foreach ($bloques as $key => $bloque) {
                $info_c = ModelConsecutivosMadera::find($bloque);
                $pulgadas_cortadas += $info_c->pulgadas;
            }
        }

        $data_c = ModelCortesPlanificados::find($info_->id_plan);
        $data_c->pulgadas_cortadas = $pulgadas_cortadas;
        $data_c->save();

        ModelLogs::create([
            'accion' => 'El usuario ' . Auth::user()->nombre . ' eliminó el bloque #' . $tronco . ' utilizado para corte de serie en la woodniser',
            'usuario' => Auth::user()->nombre
        ]);

        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function addPiezasCortadas(Request $request)
    {
        $id_pieza = $request->id_pieza;
        $cantidad_ = $request->cantidad;

        $restante = '';
        $clase = 'text-danger';

        $info_ = ModelPiezasPlanificadasCorte::find($id_pieza);

        $cantidad_solicitada = $info_->cantidad;

        //Validamos la tolerancia de las piezas cortadas
        $tolerancia = round($cantidad_solicitada * 0.1);
        //Rango de cortes admitidos según la tolerancia
        $rango_i = round($cantidad_solicitada - $tolerancia);
        //Tolerancia superior
        $rango_s = round($cantidad_solicitada + $tolerancia);

        //Cantidad actualmente cortada
        $cantidad_cortada = $info_->cantidad_cortada;
        //Cantidad ingresada por usuario
        $cantidad_total = $cantidad_cortada + $cantidad_;

        if ($cantidad_total > $rango_s) {
            return response()->json(['status' => false, 'mensaje' => 'ERROR: Está superando la tolerancia exigida '.$rango_s.', ingresa un valor inferior'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        if ($cantidad_total >= $cantidad_solicitada) {
            // $restante = $cantidad_total - $cantidad_solicitada;
            // $cantidad_total = $cantidad_solicitada;
            $info_->estado = 'Completado';
            $clase = 'text-success';
            self::updateInfoTroncos($info_->troncos, $info_->troncos_utilizados);
        }

        $info_->cantidad_cortada = $cantidad_total;
        $info_->save();

        self::checkStatusPlanCorte($info_->id_plan);

        ModelLogs::create([
            'accion' => 'El usuario ' . Auth::user()->nombre . ' ha cortado #' . $info_->cantidad_cortada . ' piezas para la serie: ' . $info_->mueble . ' ' . $info_->serie . ' ' . $info_->madera,
            'usuario' => Auth::user()->nombre
        ]);

        return response()->json(['status' => true, 'estado' => $info_->estado, 'cantidad' => $info_->cantidad_cortada, 'resta' => $restante, 'clase' => $clase], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function updateInfoTroncos($troncos_db, $troncos_utilizados)
    {
        $troncos_1 = explode(",", $troncos_db);
        $troncos_2 = explode(",", $troncos_utilizados);

        $troncos_no_utilizados_array = [];

        foreach ($troncos_1 as $tronco) {
            if (!in_array($tronco, $troncos_2)) {
                $troncos_no_utilizados_array[] = $tronco;
            }
        }

        ModelConsecutivosMadera::whereIn('id', $troncos_no_utilizados_array)->where('estado', 'En corte')->update(["estado" => "Activo"]);
        ModelConsecutivosMadera::whereIn('id', $troncos_2)->update(["estado" => "Procesado"]);
    }

    public function checkStatusPlanCorte($id_plan)
    {
        $bandera_ = 0;
        $cantidad_piezas = ModelPiezasPlanificadasCorte::where("id_plan", $id_plan)->get();
        foreach ($cantidad_piezas as $key => $value) {
            $cantidad = $value->cantidad;
            $tolerancia = round(($cantidad*0.1));
            $inferior = $cantidad-$tolerancia;
            $superior = $cantidad+$tolerancia;
            if($value->cantidad_cortada>=$inferior && $value->cantidad_cortada<=$superior){
                $bandera_++;
            }
        }

        $cantidad_completadas = ModelPiezasPlanificadasCorte::where("estado", "Completado")->where("id_plan", $id_plan)->count();

        if (count($cantidad_piezas) == $bandera_) {
            $ancho_tabla = 0;
            $pulgadas_cortadas = 0;

            $tablas_cortadas = ModelInfoTablasCortadas::where("id_corte", $id_plan)->get();
            foreach ($tablas_cortadas as $key => $value) {
                $ancho_tabla += $value->ancho_tabla;
            }
            $pulgadas_no_utilizadas = round(($ancho_tabla / 2.54) * 0.75);

            foreach ($cantidad_piezas as $key => $val) {
                $bloques = explode(",", $val->troncos_utilizados);
                foreach ($bloques as $key => $bloque) {
                    $info_ = ModelConsecutivosMadera::find($bloque);
                    $pulgadas_cortadas += $info_->pulgadas;
                }
            }

            $data_c = ModelCortesPlanificados::find($id_plan);
            $data_c->estado = "Completado";
            $data_c->pulgadas_cortadas = $pulgadas_cortadas;
            $data_c->pulgadas_no_utilizadas = $pulgadas_no_utilizadas;
            $data_c->save();

            ModelLogs::create([
                'accion' => 'El usuario ' . Auth::user()->nombre . ' ha completado el corte # ' . $id_plan,
                'usuario' => Auth::user()->nombre
            ]);
        }
    }

    public function getDataTableCortes(Request $request)
    {
        $id_pieza = $request->id_pieza;
        $bandera = $request->bandera;
        $dataTable = '<table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>Consecutivo</th>
                <th>Pulgadas</th>
                <th>Largo</th>
                <th>Utilizar</th>
            </tr>
        </thead>
        <tbody class="text-center">';
        $piezas_ = ModelPiezasPlanificadasCorte::find($id_pieza);
        $troncos = explode(",", $piezas_->troncos);
        sort($troncos);
        foreach ($troncos as $key => $value) {
            $pulgadas_ = ModelConsecutivosMadera::find($value);
            $pulgadas = $pulgadas_->pulgadas;
            $dataTable .= '<tr id="' . $id_pieza . $bandera . trim($value) . '">
           <td>' . $value . '</td>
           <td>' . number_format($pulgadas) . '</td>
           <td>' . $pulgadas_->largo . 'm</td>
           <td><button class="btn btn-sm btn-success" onclick="utilizarTroncoPLan(\'' . trim($value) . '\',\'' . $bandera . '\', \'' . $id_pieza . '\')" ><i class="fas fa-check"></i></button></td>
           </tr>';
        }
        $dataTable .= '</tbody>
        </table>';

        return response()->json(['status' => true, 'table' => $dataTable], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function getDataObsCortes(Request $request)
    {
        $id_pieza = $request->id_pieza;
        $piezas_ = ModelPiezasPlanificadasCorte::find($id_pieza);
        $obs = $piezas_->obs;

        return response()->json(['status' => true, 'obs' => $obs], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function getInfoDataPiezasMadera(Request $request)
    {
        $serie = $request->serie;
        $madera = $request->madera;
        $mueble =  $request->mueble;

        $piezas_ = ModelInfoPiezasMueble::where("id_mueble", $mueble)
            ->where("id_serie", $serie)
            ->where("id_madera", $madera)
            ->where("estado", "1")->get();

        $view = view("apps.control_madera.app.wood.iniciar_corte.formPiezasFavor", ["data" => $piezas_])->render();

        return response()->json(['status' => true, 'view' => $view], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function saveInformacionPiezasFavor(Request $request)
    {
        $cantidad = $request->valor;

        for ($i = 1; $i < $cantidad; $i++) {

            $id_pieza = $request["idPieza" . $i];
            $cantidad_ = $request["piezasFavorNum" . $i];

            if (!empty($cantidad_) && $cantidad_ > 0) {
                $info = ModelInfoPiezasMueble::find($id_pieza);
                $info_fav = ModelCantidadesFavor::where("id_pieza", $id_pieza)->where("estado", "Pendiente")->first();
                if ($info_fav) {
                    $cantidad_db = $info_fav->cantidad;
                    $info_fav->cantidad = ($cantidad_db + $cantidad_);
                    $info_fav->save();
                } else {
                    ModelCantidadesFavor::create([
                        'id_pieza' => $id_pieza,
                        'nom_pieza' => $info->pieza,
                        'cantidad' => $cantidad_,
                        'estado' => 'Pendiente'
                    ]);
                }
            }
        }

        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function saveInformacionTablasCortes(Request $request)
    {
        $id_corte = $request->id_corte;
        $cantidad_tabla = $request->cant_tablas;
        $ancho = $request->ancho;

        ModelInfoTablasCortadas::create([
            'cantidad_tabla' => $cantidad_tabla,
            'ancho_tabla' => $ancho,
            'id_corte' => $id_corte,
            'usuario_registro' => Auth::user()->nombre
        ]);

        $val_t = 0;
        $can_tablas = ModelInfoTablasCortadas::where("id_corte", $id_corte)->get();
        foreach ($can_tablas as $key => $value) {
            $val_t += $value->cantidad_tabla;
        }

        ModelLogs::create([
            'accion' => 'El usuario ' . Auth::user()->nombre . ' ha agregado #' . $val_t . ' tablas para el corte de serie #' . $id_corte,
            'usuario' => Auth::user()->nombre
        ]);

        return response()->json(['status' => true, 'tablas' => $val_t], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function getInfoTablaMadera()
    {
    }

    //Se guardan las piezas según el tipo de madera - esto se realizada en los cortes de la wood
    public function saveInformationPiezasMadera(Request $request)
    {
        $largo = $request->largoOtraSerie;
        $ancho = $request->anchoOtraSerie;
        $grueso = $request->gruesoOtraSerie;
        $cantidad = $request->cantidadOtraSerie;
        $madera = $request->maderaOtraSerie;
        $id_corte = $request->id_corte;

        $info_madera = ModelInfoMadera::where("nombre_madera", $madera)->first();
        $id_madera = isset($info_madera->id_madera) ? $info_madera->id_madera : 0;

        ModelPiezasMaderaFavor::create([
            'largo' => $largo,
            'ancho' => $ancho,
            'grueso' => $grueso,
            'cantidad_inicial' => $cantidad,
            'cantidad_disponible' => $cantidad,
            'id_madera' => $id_madera,
            'madera' => $madera,
            'id_corte' => $id_corte,
            'estado' => 'Pendiente'
        ]);

        $info_g = ModelPiezasMaderaFavor::where("id_corte", $id_corte)->get();
        $tabla = view("apps.control_madera.app.wood.iniciar_corte.tablePiezasMadera", ["info" => $info_g])->render();

        return response()->json(['status' => true, 'tabla' => $tabla], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
