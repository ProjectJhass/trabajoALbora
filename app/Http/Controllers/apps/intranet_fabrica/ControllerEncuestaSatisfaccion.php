<?php

namespace App\Http\Controllers\apps\intranet_fabrica;

use App\Exports\encuestas_satisfaccion\ExportEncuestasSatisfaccionPonderacion;
use App\Http\Controllers\Controller;
use App\Models\apps\intranet_fabrica\ModelEncuestaSatisfaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ControllerEncuestaSatisfaccion extends Controller
{
    public function VisualizarInformacion()
    {
        $procesos = ModelEncuestaSatisfaccion::ObtenerProcesosFabrica();
        return view('apps.intranet_fabrica.fabrica.encuesta_satisfaccion.encuesta', ['procesos' => $procesos]);
    }

    public function ValidarExistenciaDeUsuario(Request $request)
    {
        $cedula_usuario = $request->cedula_usuario;
        $status = false;
        $response = ModelEncuestaSatisfaccion::VerificarExistenciaUsuario($cedula_usuario);
        foreach ($response as $key => $value) {
            $valor = $value->valor;
        }
        if ($valor > 0) {
            $mensaje = '<div class="alert alert-success" role="alert">
            Excelente ! Usuario autenticado <br><br>
            <button class="btn btn-danger" onclick=' . "RealizarEncuestaSatisfaccion('" . url('/realizar-encuesta-satisfaccion') . "')" . '>Realizar encuesta</button>
          </div>';
        } else {
            $mensaje = '<div class="alert alert-danger" role="alert">
            El usuario no se encuentra registrado
          </div>';
        }
        return response()->json(['status' => true, 'mensaje' => $mensaje], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function ObtenerSeccionesFabricaEnc(Request $request)
    {
        $secciones = ModelEncuestaSatisfaccion::ObtenerSeccionesFabrica($request->id_proceso);
        $valores = '<option value="">Seleccionar...</option>';
        foreach ($secciones as $key => $value) {
            $valores .= '<option value="' . $value->id_seccion_fab . '">' . $value->nombre_seccion . '</option>';
        }
        return response()->json(['status' => true, 'data' => $valores], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function RealizarEncuestaSatisfaccion($proceso, $seccion)
    {
        $proceso_ = ModelEncuestaSatisfaccion::ObtenerNombreProceso($proceso);
        $seccion_ = ModelEncuestaSatisfaccion::ObtenerNombreSeccion($seccion);
        $preguntas = ModelEncuestaSatisfaccion::ObtenerPreguntasEncuesta();

        return view('apps.intranet_fabrica.fabrica.encuesta_satisfaccion.realizar_encuesta', ['proceso' => $proceso_, 'seccion' => $seccion_, 'preguntas' => $preguntas]);
    }

    public function GuardarInformacionEncuestaCliente(Request $request)
    {
        $nombre_u = $request->nombre_u ?? "";
        $data = ([
            'nombre_usuario' => $request->nombre_u ?? "",
            'proceso' => $request->proceso,
            'seccion' => $request->seccion,
            'comentario1' => $request->actividad_participacion,
            'comentario2' => $request->actividad_integracion,
            'comentario3' => $request->habilidad,
            'comentario4' => $request->mejoras,
            'tiem_empresa' => $request->tiempo_en_empresa,
            'fecha_realizacion' => date('Y-m-d')
        ]);
        $respuesta = ModelEncuestaSatisfaccion::InsertarInformacionUsuarioEncuesta($data);
        if ($respuesta > 0) {
            for ($i = 1; $i <= 31; $i++) {
                $respuesta_p = str_replace(array(',', ';'), '.', $request['p' . $i]);
                $respuesta_p = ($respuesta_p > 5) ? '5' : (($respuesta_p < 1) ? '1' : $respuesta_p);
                ModelEncuestaSatisfaccion::InsertarRespuestasPreguntas($i, $respuesta_p, date('Y-m-d'), $respuesta);
            }

            $infoPersonal = ModelEncuestaSatisfaccion::ObtenerInformacionUsuarioAlm($respuesta);
            $respuestas_user = ModelEncuestaSatisfaccion::ObtenerRepuestasUsuarioEncuestaSatisfaccion($respuesta);

            $pdf = Pdf::loadView('apps.intranet_fabrica.fabrica.encuesta_satisfaccion.formato_pdf', array('info' => $infoPersonal, 'preguntas' => $respuestas_user));

            $to = (['sgc@mueblesalbura.com.co', 'diana.mora@mueblesalbura.com.co']);
            // $to = (['albura.development@gmail.com']);
            $subject = 'Encuesta de satisfacción No° ' . $respuesta;

            Mail::send('apps.intranet_fabrica.emails.encuesta_satisfaccion', [], function ($mensaje) use ($to, $subject, $pdf, $respuesta) {
                $mensaje->to($to);
                $mensaje->subject($subject);
                $mensaje->attachData($pdf->output(), 'ENCUESTA_DE_SATISFACCIÓN_CLIENTE_INTERNO_No. ' . $respuesta . '.pdf');
            });

            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function TraerFiltrosParaPonderacionEncuestasSatisfaccion(Request $request)
    {
        $code_admin = $request->code_fabrica_admin;

        if ($code_admin == '48654') {

            $procesos = ModelEncuestaSatisfaccion::ObtenerProcesosFabrica();
            $view_filters_ponderacion = view('apps.intranet_fabrica.fabrica.encuesta_satisfaccion.ponderacion.filtros', ["procesos" => $procesos])->render();

            return response()->json(['status' => true, "message" => "Acceso concedido!", "view_filter_ponderacion" => $view_filters_ponderacion], 200);
        } else {
            return response()->json(['status' => false, "message" => "Acceso denegado!"], 403);
        }
    }

    public function CargarPonderacionEncuestasSatisfaccion(Request $request)
    {
        $desde = $request->filters_desde_ponderacion;
        $hasta = $request->filters_hasta_ponderacion ?? date('Y-m-d');
        $proceso = $request->filter_proceso_ponderacion ?? "";

        if (!empty($desde) && !empty($proceso)) {

            $id_proccess = ModelEncuestaSatisfaccion::ObtenerIdProceso($proceso)->id_proceso;

            $secciones = ModelEncuestaSatisfaccion::ObtenerSeccionesFabricaNombre($id_proccess);

            $preguntas_ponderacion = [
                "1" => "ÁREA DE TRABAJO",
                "2" => "COMUNICACIÓN",
                "3" => "LIDERAZGO",
                "4" => "TRABAJO EN EQUIPO",
                "5" => "CONDICIONES AMBIENTALES",
                "6" => "MOTIVACIÓN Y ÉTICA EMPRESARIAL"
            ];

            $seccion_ponderacion = [];

            for ($i = 0; $i < count($secciones); $i++) {
                $seccion_ponderacion[$secciones[$i]->nombre_seccion] = [];
            }

            foreach ($seccion_ponderacion as $key_sec_pon => $value_sec_pon) {
                foreach ($preguntas_ponderacion as $key_peg_pon => $value_peg_pon) {
                    $respuestas_ponderacion = ModelEncuestaSatisfaccion::obtener_respuestas_orden_proceso($proceso, $key_sec_pon, $desde, $hasta, $key_peg_pon);
                    foreach ($respuestas_ponderacion as $value_res_pon) {
                        if (!isset($seccion_ponderacion[$key_sec_pon][$value_peg_pon][$value_res_pon->pregunta])) {
                            $seccion_ponderacion[$key_sec_pon][$value_peg_pon][$value_res_pon->pregunta] = ["respuestas" => []];
                        }
                        $seccion_ponderacion[$key_sec_pon][$value_peg_pon][$value_res_pon->pregunta]["respuestas"][] = $value_res_pon->respuesta;
                    }
                }
            }

            $result_ponderacion = self::resultados_ponderacion_($seccion_ponderacion, $proceso, $desde, $hasta);

            $view_table_ponderacion = view(
                'apps.intranet_fabrica.fabrica.encuesta_satisfaccion.ponderacion.visualizar_ponderacion',
                [
                    "proceso_seleccionados" => $proceso,
                    "desde" => $desde,
                    "hasta" => $hasta,
                    "secciones" => $secciones,
                    "preguntas_ponderacion" => $preguntas_ponderacion,
                    "result_ponderacion" => $result_ponderacion

                ]
            )->render();

            return response()->json(["status" => true, "message" => "Ponderación de fechas filtradas realizado!", "view_data_ponderacion" => $view_table_ponderacion], 200);
        } else {
            return response()->json(['status' => false, "message" => "Datos insuficientes para realizar la consulta."], 400);
        }
    }

    public function resultados_ponderacion_($datos_ponderacion, $proceso, $desde, $hasta)
    {

        $data_final_pondera = [];

        foreach ($datos_ponderacion as $key_pon => $value_pon) {
            $cantidad_personas_respondieron = ModelEncuestaSatisfaccion::obtener_cantidad_personas_respondieron($proceso, $key_pon, $desde, $hasta);
            foreach ($value_pon as $key_sec => $value_sec) {

                $conteo_cantidad_preguntas = count($value_sec);

                foreach ($value_sec as $key_peg => $value_peg) {
                    $total_respuestas = array_sum($value_peg['respuestas']);
                    $conteo_respuestas = count($value_peg['respuestas']);
                    $promedio = $total_respuestas / $conteo_respuestas;
                    $porcentaje_respuestas = 0;
                    $porcentaje_seccion_pregunta = 0;

                    if ($conteo_cantidad_preguntas == 5) {
                        $porcentaje_respuestas = $promedio * 20 / 100;
                        $porcentaje_seccion_pregunta = $promedio * 3.333333333333334 / 100;
                    } else {
                        $porcentaje_respuestas = $promedio * 16.66666666666667 / 100;
                        $porcentaje_seccion_pregunta = $promedio * 3.333333333333334 / 100;
                    }

                    $data_final_pondera[$key_pon][$key_sec][$key_peg] =
                        [
                            "total_respuestas" => array_sum($value_peg['respuestas']),
                            "conteo_respuestas" => count($value_peg['respuestas']),
                            "promedio_respuestas" => $promedio,
                            "conteo_cantidad_preguntas" => $conteo_cantidad_preguntas,
                            "porcentaje_respuestas" => $porcentaje_respuestas,
                            "porcentaje_seccion_pregunta" => $porcentaje_seccion_pregunta,
                            "personas_respondieron_encuesta" => count($cantidad_personas_respondieron)
                        ];
                }
            }
        }

        $data_final_pondera_resumen = [];

        foreach ($data_final_pondera as $key_proceso_pon => $value_proceso_pon) {
            foreach ($value_proceso_pon as $key_sec_peg_pon => $value_sec_peg_pon) {
                $porcentaje_respuestas_sumado = 0;
                $porcentaje_seccion_pregunta_sumado = 0;
                foreach ($value_sec_peg_pon as $key_peg_pon => $value_peg_pon) {
                    $conteo_cantidad_preguntas_sumado = $value_peg_pon['conteo_cantidad_preguntas'];
                    $cantidad_personas_respondieron_encuesta = $value_peg_pon['personas_respondieron_encuesta'];
                    $porcentaje_respuestas_sumado += $value_peg_pon['porcentaje_respuestas'];
                    $porcentaje_seccion_pregunta_sumado += $value_peg_pon['porcentaje_seccion_pregunta'];
                    $data_final_pondera_resumen[$key_proceso_pon][$key_sec_peg_pon] = ["resultados" => [
                        "porcentaje_respuestas_sumado" => $porcentaje_respuestas_sumado,
                        "porcentaje_seccion_pregunta_sumado" => (($porcentaje_seccion_pregunta_sumado * 100) / $conteo_cantidad_preguntas_sumado),
                        "cantidad_personas_respondieron_encuesta" => $cantidad_personas_respondieron_encuesta
                    ]];
                }
            }
        }

        return ["data_final_pondera" => $data_final_pondera, "data_final_pondera_resumen" => $data_final_pondera_resumen];
    }

    public function resultados_ponderacion_excel_export(Request $request) {

        $data_request = $request->data_exception[0] ?? array();

        $data_seccion_preguntas = [];

        if(!empty($data_request)) {
            foreach ($data_request as $key_excp => $value_excp) {
                foreach ($value_excp as $key_sec_peg => $value_sec_peg) {
                    foreach ($value_sec_peg as $key_peg => $value_peg) {
                        $data_seccion_preguntas[$key_sec_peg][$key_peg] = ["cantidad_preguntas" => $value_peg['conteo_cantidad_preguntas']];
                    }
                }
            }
        }


        // dd(array_values($data_seccion_preguntas));

        return Excel::download(new ExportEncuestasSatisfaccionPonderacion($request->data_exception[0] ?? array(), $request->proceso ?? "", $data_seccion_preguntas ?? array(), $request->data_exception[1] ?? array()), 'ponderacion_encuesta.xlsx');

        // return response()->json(['status' => true, 'message' => $request->data_exception[0], 'proceso' => $request->proceso], 200);
    }
}
