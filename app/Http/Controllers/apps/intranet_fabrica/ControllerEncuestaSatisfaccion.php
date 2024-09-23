<?php

namespace App\Http\Controllers\apps\intranet_fabrica;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet_fabrica\ModelEncuestaSatisfaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

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

            // $to = (['sgc@mueblesalbura.com.co', 'diana.mora@mueblesalbura.com.co']);
            $to = (['albura.development@gmail.com']);
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

            $get_encuestas_fecha = ModelEncuestaSatisfaccion::ObtenerEncuestasRealizadasPorFecha($desde, $hasta, $proceso);

            foreach ($get_encuestas_fecha as $valE) {
                $seccion = $valE->seccion;
                if (isset($seccion_ponderacion[$seccion])) {
                    for ($i = 1; $i <= count($preguntas_ponderacion); $i++) {
                        if (!isset($seccion_ponderacion[$seccion][$preguntas_ponderacion[$i]])) {
                            $seccion_ponderacion[$seccion][$preguntas_ponderacion[$i]][] = [
                                ModelEncuestaSatisfaccion::ObtenerRespuestasProcesoSeccionOrdenamiento($proceso, $seccion, $desde, $hasta, $i)
                            ];
                        }
                    }
                    $seccion_ponderacion[$seccion]['datos_elecciones'][] = [
                        "valores" => $valE
                    ];
                }
            }

            $data_ponderacion = self::PonderarAgrupacion($seccion_ponderacion, $preguntas_ponderacion);

            // dd($data_ponderacion);

            $view_table_ponderacion = view(
                'apps.intranet_fabrica.fabrica.encuesta_satisfaccion.ponderacion.visualizar_ponderacion',
                [
                    "proceso_seleccionados" => $proceso,
                    "desde" => $desde,
                    "hasta" => $hasta,
                    "secciones" => $secciones,
                    "preguntas_ponderacion" => $preguntas_ponderacion,
                    "seccion_ponderacion" => $seccion_ponderacion,
                    "get_encuestas_fecha" => $get_encuestas_fecha,
                    "datos_ponderacion_agrupados" => $seccion_ponderacion,
                    "data_ponderacion" => $data_ponderacion
                ]
            )->render();

            return response()->json(["status" => true, "message" => "Ponderación de fechas filtradas realizado!", "view_data_ponderacion" => $view_table_ponderacion], 200);
        } else {
            return response()->json(['status' => false, "message" => "Datos insuficientes para realizar la consulta."], 400);
        }
    }

    public function PonderarAgrupacion($datos_ponderacion_agrupados, $preguntas_ponderacion)
    {
        $ponderacion_totalizada = [];

        foreach ($datos_ponderacion_agrupados as $key_proceso => $value_proceso) {
            $seccion = $key_proceso;
            if (!isset($ponderacion_totalizada[$key_proceso])) {
                // Cambiar el ciclo para recorrer correctamente las preguntas
                for ($i = 1; $i <= count($preguntas_ponderacion); $i++) {
                    $total_media = 0;
                    $total_ponderado = 0;
                    $total_respuesta_ = 0;
                    $total_respuestas_conteo = 0;
                    $seccion_pregunta = $preguntas_ponderacion[$i];
                    $cantidad_personas_respondieron = count($value_proceso['datos_elecciones']);

                    if (isset($value_proceso[$seccion_pregunta])) {
                        // Cambiar el índice del bucle interior para evitar sobrescribir $i
                        foreach ($value_proceso[$seccion_pregunta][0] as $respuesta) {
                            foreach ($respuesta as $res) { // Usar $res en lugar de sobrescribir $i
                                $value_sum = intval($res->respuestas_ordenamiento);
                                $total_respuesta_ += $value_sum;
                            }
                            $total_respuestas_conteo = count($respuesta); // Mover fuera del bucle interior
                        }

                        // Calcular ponderado y media
                        $total_ponderado = $total_respuesta_ * (16.6 / 100);
                        $total_media = $total_respuesta_ / $total_respuestas_conteo;

                        // Guardar en la estructura de salida
                        $ponderacion_totalizada[$key_proceso][$seccion_pregunta] = [
                            "cantidad_personas_respondieron" => $cantidad_personas_respondieron,
                            "total_respuestas_" => $total_respuesta_,
                            "total_respuestas_conteo" => $total_respuestas_conteo,
                            "total_ponderado" => round($total_ponderado, 1),
                            "total_media" => round($total_media, 1),
                            "proceso" => $seccion
                        ];
                    }
                }
            }
        }

        return $ponderacion_totalizada;
    }
}
