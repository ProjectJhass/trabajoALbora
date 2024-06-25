<?php

namespace App\Http\Controllers\apps\control_madera;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\ModelConsecutivosMadera;
use App\Models\apps\control_madera\ModelLogs;
use App\Models\apps\control_madera\ModelPlannerTabla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ControllerPlannerTabla extends Controller
{
    public function saveInfoCorteTabla(Request $request)
    {
        $cantidad = $request->cantidad_tablas;
        $nombre = "Corte de tabla x" . $cantidad;
        $medidas = "19";
        $planificador = Auth::user()->nombre;

        if ($cantidad > 0) {
            $request = ModelPlannerTabla::create([
                'nombre_corte' => $nombre,
                'cantidad' => $cantidad,
                'medida_grosor' => $medidas,
                'pulgadas_solicitadas' => round(((($cantidad * ($medidas / 10)) / 2.54) * 0.75)),
                'planificador' => $planificador,
                'cantidad_cortada' => '0',
                'op_creada' => 'No',
                'estado' => "Pendiente"
            ]);

            if ($request) {

                ModelLogs::create([
                    'accion' => 'El usuario ' . Auth::user()->nombre . ' creó una planificación de corte de tablas por una cantidad de: ' . $cantidad,
                    'usuario' => Auth::user()->nombre
                ]);

                return response()->json(['status' => true, 'mensaje' => 'La planificación de corte de tabla fue creada exitosamente'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }

            return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
        return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function formInfoCorteTabla(Request $request)
    {
        $id_corte = $request->id;
        $info = ModelPlannerTabla::find($id_corte);
        return view('apps.control_madera.app.wood.corte_tabla.formCorte', ['info' => $info, 'idT' => $id_corte]);
    }

    public function saveInfoCorteTablas(Request $request)
    {
        $id_corte = $request->id;
        $info = ModelPlannerTabla::find($id_corte);

        if ($request->has('terminar')) {
            $cantidad_ = $info->cantidad_cortada;
            $pulgadas_t = round(((($cantidad_ * (19 / 10)) / 2.54) * 0.75));
            $info->pulgadas_cortadas = $pulgadas_t;
            $info->cortador = Auth::user()->nombre;
            $info->estado = "Terminado";
            $info->save();

            $bloques = explode(",", $info->bloques_utilizados);
            ModelPlannerTabla::whereIn("id", $bloques)->update(["estado" => "Procesado"]);

            return response()->json(['status' => true, 'url' => route('index.wood')], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        } else {

            $cantidad = $request->cantidad;

            $cantidad_ = $info->cantidad_cortada;
            $info->cantidad_cortada = ($cantidad + $cantidad_);
            $info->cortador = Auth::user()->nombre;
            $info->estado = "En corte";
            $info->save();

            $info_ = ModelPlannerTabla::find($id_corte);
            $cantidad_p = ($info_->cantidad - $info_->cantidad_cortada);
            $cant_ = $cantidad_p < 0 ? 0 : $cantidad_p;

            $prop = $cant_ == 0 ? true : false;
            return response()->json(['status' => true, 'estado' => $info_->estado, 'pendiente' => $cant_, 'cortada' => $info_->cantidad_cortada, 'prop' => $prop], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function troncosUtilizarTablas(Request $request)
    {
        $id_bloque = $request->bloque;
        $id_corte = $request->id_corte;

        $info_bloque = ModelConsecutivosMadera::find($id_bloque);

        if ($info_bloque->estado == "Activo") {
            $info_c = ModelPlannerTabla::find($id_corte);
            $tronco_db = $info_c->bloques_utilizados;
            $info_c->bloques_utilizados = empty($tronco_db) ? $id_bloque : $tronco_db . "," . $id_bloque;
            $info_c->cortador = Auth::user()->nombre;
            $info_c->save();

            ModelLogs::create([
                'accion' => 'El usuario ' . Auth::user()->nombre . ' utilizó el bloque #' . $id_bloque . ' para corte de tabla en la woodniser',
                'usuario' => Auth::user()->nombre
            ]);

            $info_corte = ModelPlannerTabla::find($id_corte);
            $bloques = explode(",", $info_corte->bloques_utilizados);
            $span = '';
            foreach ($bloques as $key => $value) {
                $span .= '<span class="badge bg-danger rounded-pill" style="cursor:pointer" onclick="eliminarBloqueUtilizadoTab(\'' . $value . '\')">' . $value . '</span>&nbsp;';
            }
            $info_bloque->estado = "En corte";
            $info_bloque->save();
            return response()->json(['status' => true, 'pulgadas' => number_format($info_bloque->pulgadas), 'bloque' => $id_bloque, 'largo' => $info_bloque->largo . 'm', 'bloques' => $span], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function actualizarBloquesUtilizados(Request $request)
    {
        $id_bloque = $request->bloque;
        $id_corte = $request->id_corte;

        $info_corte = ModelPlannerTabla::find($id_corte);
        $bloques_util =  explode(",", $info_corte->bloques_utilizados);

        if (($key = array_search($id_bloque, $bloques_util)) !== false) {
            unset($bloques_util[$key]);
        }

        $bloques_all = array_values($bloques_util);
        $tronco_db_updated = implode(",", $bloques_all);

        $info_corte->bloques_utilizados = $tronco_db_updated;
        $info_corte->save();

        ModelLogs::create([
            'accion' => 'El usuario ' . Auth::user()->nombre . ' eliminó el bloque #' . $id_bloque . ' utilizado para corte de tablas en la woodniser',
            'usuario' => Auth::user()->nombre
        ]);

        $info_bloque = ModelConsecutivosMadera::find($id_bloque);
        $info_bloque->estado = "Activo";
        $info_bloque->save();

        $info_corte_t = ModelPlannerTabla::find($id_corte);
        $bloques = explode(",", $info_corte_t->bloques_utilizados);
        $span = '';
        foreach ($bloques as $key => $value) {
            $span .= '<span class="badge bg-danger rounded-pill" style="cursor:pointer" onclick="eliminarBloqueUtilizadoTab(\'' . $value . '\')">' . $value . '</span>&nbsp;';
        }

        return response()->json(['status' => true, 'bloques' => $span], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function getInfoTablasTerminadas(Request $request)
    {
        $id = $request->id_corte;
        $info = ModelPlannerTabla::find($id);
        return view('apps.control_madera.app.planner.cortes_terminados.infoCorteTablas', ['info' => $info]);
    }
}
