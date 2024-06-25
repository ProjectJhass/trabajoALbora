<?php

namespace App\Http\Controllers\apps\control_madera;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\ModelCodigosSiesa;
use App\Models\apps\control_madera\ModelCortesPlanificados;
use App\Models\apps\control_madera\ModelHistorialOpsCreadas;
use App\Models\apps\control_madera\ModelLogs;
use App\Models\apps\control_madera\ModelPlannerTabla;
use App\Models\soap\control_madera\ModelConsultarConsecutivo;
use App\Models\soap\st_CrearOP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerProcedimientosSiesa extends Controller
{
    public function index()
    {
        $codigos = ModelCodigosSiesa::where('estado', 'Activo')->get();
        return view('apps.control_madera.app.siesa.crearOp', ['idCodigos' => $codigos]);
    }

    public function getInfocodigos()
    {
        $codigos = ModelCodigosSiesa::all();
        $table = view('apps.control_madera.app.siesa.tables.tableCodigos', ['info' => $codigos])->render();
        return view('apps.control_madera.app.siesa.codigosSiesa', ['infoCodigos' => $table]);
    }

    public function crearInfoCodigos(Request $request)
    {
        $id = $request->id_codigo;
        $nombre = $request->nombre_codigo;
        $codigo = $request->siesa_codigo;
        $estado = $request->estado_codigo;
        if (!empty($id)) {
            $info_c = ModelCodigosSiesa::find($id);
            if ($estado != "Eliminar") {
                $info_c->nombre = $nombre;
                $info_c->codigo = $codigo;
                $info_c->estado = $estado;
                $info_c->save();

                ModelLogs::create([
                    'accion' => 'El usuario ' . Auth::user()->nombre . ' Actualizó la tabla codigos_siesa con número de registro #' . $id . ' del código de SIESA ' . $codigo . ' que hace referencia a ' . $nombre
                ]);
            } else {
                $info_c->delete();

                ModelLogs::create([
                    'accion' => 'El usuario ' . Auth::user()->nombre . ' Eliminó el registro #' . $id . ' de la tabla codigos_siesa del código de SIESA ' . $codigo . ' que hace referencia a ' . $nombre
                ]);
            }
        } else {
            $response =  ModelCodigosSiesa::create([
                'nombre' => $nombre,
                'codigo' => $codigo,
                'estado' => $estado
            ]);

            ModelLogs::create([
                'accion' => 'El usuario ' . Auth::user()->nombre . ' creó en la tabla codigos_siesa el registro #' . $response->id . ' y el código de SIESA ' . $codigo . ' que hace referencia a ' . $nombre
            ]);
        }

        $codigos = ModelCodigosSiesa::all();
        $table = view('apps.control_madera.app.siesa.tables.tableCodigos', ['info' => $codigos])->render();
        return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function searchInfoTodoPlanificacion(Request $request)
    {
        $tipo_corte = $request->tipo_corte;
        $array = [];

        switch ($tipo_corte) {
            case 'tabla':
                $info = ModelPlannerTabla::where("op_creada", "No")->where("estado", "Terminado")->get();
                foreach ($info as $key => $value) {
                    array_push($array, ([
                        'id' => $value->id,
                        'nombre' => strtoupper($value->nombre_corte),
                        'pulgadas' => $value->pulgadas_cortadas,
                        'codigo' => '940'
                    ]));
                }
                break;
            case 'serie':
                $info = ModelCortesPlanificados::where("op_creada_p1", "No")->where("estado", "Completado")->get();
                foreach ($info as $key => $value) {
                    $codigo = $value->madera == 'Flormorado' ? '2666' : ($value->madera == 'Pino Cipres' ? '7360' : '1');
                    array_push($array, ([
                        'id' => $value->id,
                        'nombre' => strtoupper($value->mueble . " " . $value->serie . " " . $value->madera),
                        'pulgadas' => ($value->pulgadas_cortadas - $value->pulgadas_no_utilizadas),
                        'codigo' => $codigo
                    ]));
                }
                break;
            case 'Tserie':
                $info = ModelCortesPlanificados::where("op_creada_p2", "No")->where("estado", "Completado")->get();
                foreach ($info as $key => $value) {
                    array_push($array, ([
                        'id' => $value->id,
                        'nombre' => strtoupper($value->mueble . " " . $value->serie . " " . $value->madera),
                        'pulgadas' => $value->pulgadas_no_utilizadas,
                        'codigo' => '940'
                    ]));
                }
                break;
        }

        $table = view('apps.control_madera.app.siesa.tables.tableInfoOp', ['info' => $array])->render();
        return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function searchInfoPlanificacionValor(Request $request)
    {
        $tipo_corte = $request->tipo_corte;
        $valor_buscado = $request->valor_buscado;
        $keywords = explode(" ", $valor_buscado);
        $array = [];

        switch ($tipo_corte) {
            case 'tabla':
                $info = ModelPlannerTabla::where("nombre_corte", "LIKE", "%$valor_buscado%")->where("op_creada", "No")->where("estado", "Terminado")->get();
                foreach ($info as $key => $value) {
                    array_push($array, ([
                        'id' => $value->id,
                        'nombre' => strtoupper($value->nombre_corte),
                        'pulgadas' => $value->pulgadas_cortadas,
                        'codigo' => '940'
                    ]));
                }
                break;
            case 'serie':
                $info = ModelCortesPlanificados::where("op_creada_p1", "No")->where("estado", "Completado")
                    ->where(function ($query) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $query->orWhere(function ($subQuery) use ($keyword) {
                                $subQuery->where("serie", "LIKE", "%$keyword%")
                                    ->orWhere("madera", "LIKE", "%$keyword%")
                                    ->orWhere("mueble", "LIKE", "%$keyword%");
                            });
                        }
                    })->distinct()->get();

                foreach ($info as $key => $value) {
                    $codigo = $value->madera == 'Flormorado' ? '2666' : ($value->madera == 'Pino Cipres' ? '7360' : '1');
                    array_push($array, ([
                        'id' => $value->id,
                        'nombre' => strtoupper($value->mueble . " " . $value->serie . " " . $value->madera),
                        'pulgadas' => ($value->pulgadas_cortadas - $value->pulgadas_no_utilizadas),
                        'codigo' => $codigo
                    ]));
                }
                break;
            case 'Tserie':
                $info = ModelCortesPlanificados::where("op_creada_p2", "No")->where("estado", "Completado")
                    ->where(function ($query) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $query->orWhere(function ($subQuery) use ($keyword) {
                                $subQuery->where("serie", "LIKE", "%$keyword%")
                                    ->orWhere("madera", "LIKE", "%$keyword%")
                                    ->orWhere("mueble", "LIKE", "%$keyword%");
                            });
                        }
                    })->distinct()->get();
                foreach ($info as $key => $value) {
                    array_push($array, ([
                        'id' => $value->id,
                        'nombre' => strtoupper($value->mueble . " " . $value->serie . " " . $value->madera),
                        'pulgadas' => $value->pulgadas_no_utilizadas,
                        'codigo' => '940'
                    ]));
                }
                break;
        }

        $table = view('apps.control_madera.app.siesa.tables.tableInfoOp', ['info' => $array])->render();
        return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function crearInformacionOpSiesa(Request $request)
    {
        $tipo_corte = $request->tipoCorteBuscado;
        $pulgadas = $request->pulgadas_solicitar;
        $id_corte = $request->id_corte_planificado;
        $codigo_siesa = $request->codigo_siesa_op;
        $planificador = Auth::user()->id;
        $notas = $request->notas_op_siesa;
        //Datos adicionales
        $nombre_ = $request->nombre_corte_planificado;

        if (empty($tipo_corte) || empty($pulgadas) || empty($id_corte) || empty($codigo_siesa) || empty($notas)) {
            return response()->json(['status' => false, 'mensaje' => '¡ERROR! Revisa los campos en rojo y vuelve a intentar'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        $linea2 = self::linea2Madera($notas, $planificador);
        $linea3 = self::linea3Madera($pulgadas, $codigo_siesa);

        $response_ws = st_CrearOP::ejecutarConsultaWs($linea2, $linea3);
        if (is_bool($response_ws) === true && $response_ws === true) {

            $consecutivo_doc = ModelConsultarConsecutivo::ObtenerConsecutivo();

            switch ($tipo_corte) {
                case 'tabla':
                    $info = ModelPlannerTabla::find($id_corte);
                    $info->op_creada = 'Si';
                    $info->consecutivo_op = $consecutivo_doc;
                    $info->usuario_creacion_op = Auth::user()->nombre;
                    $info->save();
                    break;
                case 'serie':
                    $info = ModelCortesPlanificados::find($id_corte);
                    $info->op_creada_p1 = 'Si';
                    $info->consecutivo_op_p1 = $consecutivo_doc;
                    $info->creacion_op_p1 = Auth::user()->nombre;
                    $info->save();
                    break;
                case 'Tserie':
                    $info = ModelCortesPlanificados::find($id_corte);
                    $info->op_creada_p2 = 'Si';
                    $info->consecutivo_op_p2 = $consecutivo_doc;
                    $info->creacion_op_p2 = Auth::user()->nombre;
                    $info->save();
                    break;
            }

            ModelHistorialOpsCreadas::create([
                'tipo_corte' => $tipo_corte,
                'id_corte' => $id_corte,
                'nombre' => $nombre_,
                'pulgadas' => $pulgadas,
                'tipo_doc' => 'OP',
                'codigo_item' => $codigo_siesa,
                'planificador' => Auth::user()->nombre,
                'consecutivo_op' => $consecutivo_doc
            ]);

            ModelLogs::create([
                'accion' => 'El usuario ' . Auth::user()->nombre . ' creó una orden de producción en SIESA con el número de consecutivo #' . $consecutivo_doc
            ]);

            return response()->json(['status' => true, 'mensaje' => '¡Excelente! Orden de producción creada con el consecutivo #' . $consecutivo_doc], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        } else {
            return response()->json(['status' => false, 'mensaje' => $response_ws[0]['f_detalle']], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function linea2Madera($notas, $planificador)
    {
        $word_i = (['á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ']);  //palabras que se eliminan de la nota si están en ella
        $word_f = (['a', 'e', 'i', 'o', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'N']);  //Vocales y N

        $planner = strlen($planificador);
        $user_creacion = $planificador . str_repeat(" ", (15 - $planner));

        //Notas
        $notas_i = trim(str_replace($word_i, $word_f, $notas));
        $notas_i = substr($notas_i, 0, 2000);
        $notas_ = $notas_i . str_repeat(" ", (2000 - strlen($notas_i)));

        $F_NUMERO_REG = '0000002';
        $F_TIPO_REG = '0850';
        $F_SUBTIPO_REG = '00';
        $F_VERSION_REG = '01';
        $F_CIA = '002';
        $F_CONSEC_AUTO_REG = '1';
        $f850_id_co = '001';
        $f850_id_tipo_docto = 'OP ';
        $f850_consec_docto = "00000001";
        $f850_fecha = date('Ymd');
        $f850_ind_estado = '1';
        $f850_ind_impresión = '0';
        $f850_id_clase_docto = '701';
        $f850_tercero_planificador = $user_creacion;
        $f850_id_tipo_docto_op_padre = str_repeat(" ", 3);
        $f850_consec_docto_op_padre = str_repeat("0", 8);
        $f850_id_instalacion = '001';
        $f850_clase_op = 'OP2';
        $f850_referencia_1 = str_repeat(" ", 30);
        $f850_referencia_2 = str_repeat(" ", 30);
        $f850_referencia_3 = str_repeat(" ", 30);
        $f850_notas = $notas_;
        $f850_id_co_pv = str_repeat(" ", 3);
        $f850_id_tipo_docto_pv = str_repeat(" ", 3);
        $f850_consec_docto_pv = str_repeat("0", 8);

        return $F_NUMERO_REG
            . $F_TIPO_REG
            . $F_SUBTIPO_REG
            . $F_VERSION_REG
            . $F_CIA
            . $F_CONSEC_AUTO_REG
            . $f850_id_co
            . $f850_id_tipo_docto
            . $f850_consec_docto
            . $f850_fecha
            . $f850_ind_estado
            . $f850_ind_impresión
            . $f850_id_clase_docto
            . $f850_tercero_planificador
            . $f850_id_tipo_docto_op_padre
            . $f850_consec_docto_op_padre
            . $f850_id_instalacion
            . $f850_clase_op
            . $f850_referencia_1
            . $f850_referencia_2
            . $f850_referencia_3
            . $f850_notas
            . $f850_id_co_pv
            . $f850_id_tipo_docto_pv
            . $f850_consec_docto_pv;
    }


    public function linea3Madera($cantidad_, $item)
    {
        //$item
        $item_ = str_repeat("0", (7 - strlen($item))) . $item;

        $cantidad_ = $cantidad_ > 0 ? $cantidad_ : 1;
        $cantidad_planeada = str_repeat("0", (15 - strlen($cantidad_))) . $cantidad_;
        $cantidad_planeada = $cantidad_planeada . ".0000";

        $F_NUMERO_REG = "0000003";
        $F_TIPO_REG = "0851";
        $F_SUBTIPO_REG = "00";
        $F_VERSION_REG = "01";
        $F_CIA = "002";
        $f851_id_co  = "001";
        $f851_id_tipo_docto = "OP ";
        $f851_consec_docto = "00000001";
        $f851_nro_registro = "0000000001";
        $f851_id_item = $item_;
        $f851_referencia_item = str_repeat(" ", 50);
        $f851_codigo_barras = str_repeat(" ", 20);
        $f851_id_ext1_detalle = str_repeat(" ", 20);
        $f851_id_ext2_detalle = str_repeat(" ", 20);
        $f851_id_unidad_medida = "PGD ";
        $f851_porc_rendimiento = "100.0000";
        $f851_cant_planeada_base = $cantidad_planeada;
        $f851_fecha_inicio = date("Ymd");
        $f851_fecha_terminacion = date("Ymd");
        $f851_id_metodo_lista = "0001";
        $f851_id_bodega_componentes = str_repeat(" ", 5);
        $f851_id_metodo_ruta = "0001";
        $f851_id_lote = str_repeat(" ", 15);
        $f851_notas = str_repeat(" ", 2000);
        $f851_id_bodega = "00130";

        return $F_NUMERO_REG
            . $F_TIPO_REG
            . $F_SUBTIPO_REG
            . $F_VERSION_REG
            . $F_CIA
            . $f851_id_co
            . $f851_id_tipo_docto
            . $f851_consec_docto
            . $f851_nro_registro
            . $f851_id_item
            . $f851_referencia_item
            . $f851_codigo_barras
            . $f851_id_ext1_detalle
            . $f851_id_ext2_detalle
            . $f851_id_unidad_medida
            . $f851_porc_rendimiento
            . $f851_cant_planeada_base
            . $f851_fecha_inicio
            . $f851_fecha_terminacion
            . $f851_id_metodo_lista
            . $f851_id_bodega_componentes
            . $f851_id_metodo_ruta
            . $f851_id_lote
            . $f851_notas
            . $f851_id_bodega;
    }
}
