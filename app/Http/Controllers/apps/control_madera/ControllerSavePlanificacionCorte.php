<?php

namespace App\Http\Controllers\apps\control_madera;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\ModelCantidadesFavor;
use App\Models\apps\control_madera\ModelConsecutivosMadera;
use App\Models\apps\control_madera\ModelCortesPlanificados;
use App\Models\apps\control_madera\ModelLogs;
use App\Models\apps\control_madera\ModelPiezasPlanificadasCorte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerSavePlanificacionCorte extends Controller
{
    public function savePlanificacion(Request $request)
    {
        $serie = $request->serie;
        $madera = $request->madera;
        $mueble = $request->mueble;
        $cantidad = $request->cantidad;

        $cantidad_piezas = $request->inputs;

        $pulgadas_solicitadas = 0;

        $data_ = ModelCortesPlanificados::create([
            'serie' => $serie,
            'madera' => $madera,
            'mueble' => $mueble,
            'cantidad' => $cantidad,
            'planificador' => Auth::user()->nombre,
            'op_creada_p1' => 'No',
            'op_creada_p2' => 'No',
            'estado' => 'Pendiente'
        ]);

        if ($data_) {
            $id_plan = $data_->id;

            ModelLogs::create([
                'accion' => 'El usuario ' . Auth::user()->nombre . ' ha creado la planificación #' . $id_plan . ' serie: ' . $data_->serie . ' madera: ' . $data_->madera . ' mueble: ' . $data_->mueble . 'cantidad: ' . $data_->cantidad,
                'usuario' => Auth::user()->nombre
            ]);

            for ($i = 1; $i < $cantidad_piezas; $i++) {
                if (
                    empty($request['name_pieza_planner' . $i]) ||
                    empty($request['largo_pieza' . $i]) ||
                    empty($request['ancho_pieza' . $i]) ||
                    empty($request['grueso_pieza' . $i]) ||
                    empty($request['cantidad_pieza' . $i]) ||
                    empty($request['largo_bloque' . $i]) ||
                    empty($request['pulgadas_utilizadas' . $i]) ||
                    empty($request['troncoNum' . $i]) ||
                    empty($request['calidad_corte' . $i])
                ) {
                    $info_insert = ModelCortesPlanificados::find($id_plan);
                    $info_insert->delete();
                    return response()->json(['error' => "Error en la información de una pieza"], 406);
                    break;
                }
            }

            ModelConsecutivosMadera::whereNotIn('estado', ['Procesado', 'Pendiente', 'Empezado', 'En corte'])->update(['estado' => 'Activo']);

            for ($i = 1; $i < $cantidad_piezas; $i++) {

                $suma_pulgadas = 0;
                $troncos_utilizados  = [];

                $id_pieza = $request['id_pieza_planner' . $i];

                $calidad_corte = $request['calidad_corte' . $i];

                $pieza = $request['name_pieza_planner' . $i];
                $largo = $request['largo_pieza' . $i];
                $ancho = $request['ancho_pieza' . $i];
                $grueso = $request['grueso_pieza' . $i];

                $cantidad_pieza = $request['cantidad_pieza' . $i];
                $cantidad_pieza_real = $request['cantidad_pieza_r' . $i];

                $largo_bloque = $request['largo_bloque' . $i];
                $pulgadas_utilizadas = $request['pulgadas_utilizadas' . $i];
                $pulgadas_solicitadas += $pulgadas_utilizadas;
                $numero_tronco = $request['troncoNum' . $i];
                $obs = $request['obs_plan_generado' . $i];

                $troncos_limpios = str_replace(["″", "V", "P", "F"], "", $numero_tronco);
                $troncos_limpios = explode(",", trim($troncos_limpios));

                foreach ($troncos_limpios as $key => $value) {
                    if (!empty($value)) {
                        $info_ = explode("-", $value);
                        $suma_pulgadas += trim($info_[1]);
                        if ($suma_pulgadas > $pulgadas_utilizadas) {

                            $pulgadas_extra = ($suma_pulgadas - $pulgadas_utilizadas);

                            $dat_consec = ModelConsecutivosMadera::find(trim($info_[0]));
                            $dat_consec->pulgadas_resta = $info_[1] - $pulgadas_extra;
                            $dat_consec->save();
                        }
                        array_push($troncos_utilizados, trim($info_[0]));
                    }
                }

                ModelConsecutivosMadera::whereIn('id', $troncos_utilizados)->update(['estado' => 'En corte']);

                $cantidad_favor = ModelCantidadesFavor::where("id_pieza", $id_pieza)->where("estado", "Pendiente")->first();
                if ($cantidad_favor) {
                    $cant_favor = $cantidad_favor->cantidad;
                    if ($cant_favor >= $cantidad_pieza_real) {
                        $cantidad_final = $cant_favor - $cantidad_pieza_real;
                        $cantidad_favor->cantidad = $cantidad_final;
                        if ($cantidad_final == 0) {
                            $cantidad_favor->estado = "Completado";
                        }
                    } else {
                        $cantidad_favor->estado = "Completado";
                    }
                    $cantidad_favor->save();
                }

                ModelPiezasPlanificadasCorte::create([
                    'calidad' => $calidad_corte,
                    'pieza' => $pieza,
                    'largo' => $largo,
                    'ancho' => $ancho,
                    'grueso' => $grueso,
                    'cantidad' => $cantidad_pieza,
                    'l_bloque' => $largo_bloque,
                    'pulgadas_t' => $pulgadas_utilizadas,
                    'troncos' => implode(", ", $troncos_utilizados),
                    'obs' => $obs,
                    'estado' => 'Pendiente',
                    'id_plan' => $id_plan
                ]);
            }

            $info_insert = ModelCortesPlanificados::find($id_plan);
            $info_insert->pulgadas_solicitadas = $pulgadas_solicitadas;
            $info_insert->save();

            return response()->json(['status' => true, 'mensaje' => 'Información almacenada correctamente'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
