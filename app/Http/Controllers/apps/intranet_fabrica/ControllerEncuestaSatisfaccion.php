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
                $mensaje->attachData($pdf->output(), $respuesta . '.pdf');
            });

            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
