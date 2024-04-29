<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelEvaluacionDepartamentos;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerEvaluacionDepartamentos extends Controller
{
    public function formularioEvaluacion(Request $request)
    {
        $id = $request->input('id');
        $codigo = $request->input('codigos');
        if ($codigo == '2696') {
            // $id = $request->id_pregunta;
            $datos = ModelEvaluacionDepartamentos::getObtenerPreguntas($id);
            $coordinadores = ModelEvaluacionDepartamentos::getObtenerCoordinadores();
            return view('apps.intranet.evaluacionRegional.evaluacion', ['datos' => $datos, 'coordinadores' => $coordinadores, 'idDepartamentoEvaluacion' => $id]);
        } else {
            return back()->with('error', '¡Código incorrecto!');
        }
    }

    public function centrosCoordinadores(Request $request)
    {
        $coordinador = $request->coordinador;
        $centros = ModelEvaluacionDepartamentos::getObtenerCentroOperacionesCoordinadorActivo($coordinador);

        return response()->json(['status' => true, 'info' => $centros->toArray()], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }


    public function historialEvaluaciones(Request $request)
    {
        $año = date("Y");
        $resultados_totales = [];
        $dias = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $coordinadores = ModelEvaluacionDepartamentos::getObtenerCoordinadores();
        foreach ($dias as $dia) {
            $resultado = ModelEvaluacionDepartamentos::buscarHistoriales($dia, $año);
            $resultados_totales[] = $resultado;
        }
        return view('apps.intranet.evaluacionRegional.historial_evaluaciones', ['datos' => $resultados_totales, 'coordinadores' => $coordinadores]);
    }


    public function obetnerCentrosEvaluados(Request $request)
    {
        $cedula = $request->input('cedula');
        $mes = $request->input('mes');
        $año = $request->input('año');
        $resultado = ModelEvaluacionDepartamentos::departamentosEvaluados($cedula, $mes, $año);
        return $resultado;
    }

    public function buscarHistorail(Request $request)
    {
        $año = $request->fecha;
        $resultados_totales = [];
        $dias = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $coordinadores = ModelEvaluacionDepartamentos::getObtenerCoordinadores();
        foreach ($dias as $dia) {
            $resultado = ModelEvaluacionDepartamentos::buscarHistoriales($dia, $año);
            $resultados_totales[] = $resultado;
        }
        return view('apps.intranet.evaluacionRegional.cuerpoTablaHistorial', ['datos' => $resultados_totales, 'coordinadores' => $coordinadores]);
    }


    //valida que el formulario este completo y se agrega los objtos que se van a guardar en la base de datos
    public function validarFormulario(Request $request)
    {
        $data = $request->except('_token');
        $evaluaciones = [];
        $porcentajeEvaluacion = [];
        $total = $data['sumas'];
        $coordinador = $data['coordinador'];
        $centro = $data['centro'];
        $fechaActual = new DateTime(date('Y-m'));
        $fechaIngresadaV = new DateTime($data['fecha']);

        if ($fechaIngresadaV <= $fechaActual) {
            $fecha_ingresada = $data['fecha'];
            $fechaIngresada = date('Y-m', strtotime($fecha_ingresada)) . "-01";
            if (isset($coordinador) && !empty($coordinador) && isset($centro) && !empty($centro) && isset($fechaIngresada) && !empty($fechaIngresada)) {
                foreach ($data as $key => $value) {
                    if (preg_match('/^(\D+)(\d+)$/', $key, $matches)) {
                        $prefix = $matches[1];
                        $index = $matches[2];
                        if (!isset($evaluaciones[$index])) {
                            $evaluaciones[$index] = [];
                        }
                        $evaluaciones[$index][$prefix] = $value;
                    }
                }
                $guardarEvaluaciones  = [];

                foreach ($evaluaciones as $evaluacionData) {
                    $guardarEvaluacion = [
                        'id_departamento' => $evaluacionData['departamento_id'],
                        'id_pregunta' => $evaluacionData['id_pregunta'],
                        'id_usuario' => $evaluacionData['usuario'],
                        'porcentaje_pregunta' => $evaluacionData['porcentajeResultado'],
                        'fecha' => $fechaIngresada,
                        'usuario_evaluado' => $coordinador,
                        'id_centro_operacion' => $centro,
                    ];
                    $guardarEvaluaciones[] = $guardarEvaluacion;
                    $porcentajeEvaluacion = [
                        'id_departamento' => $evaluacionData['departamento_id'],
                        'id_usuario' => $evaluacionData['usuario'],
                        'fecha' => $fechaIngresada,
                        'porcentaje_total' => $total,
                        'usuario_evaluado' => $coordinador,
                        'id_centro_operacione' => $centro,
                    ];
                }
                $resultado = self::verificarFechas($porcentajeEvaluacion, $guardarEvaluaciones);
                return $resultado;
            } else {
                return response()->json(['mensaje' => "¡Complete los campos del formulario!", 'icono' => 'error'], 500);
            }
        } else {
            return response()->json(['mensaje' => "fecha incorrecta / seleccione una fecha no mayor a la actual", 'icono' => 'error'], 500);
        }
    }

    //verifica que el formulario no halla sido registrado para guardarlo
    public function verificarFechas($porcentajeEvaluacion, $guardarEvaluaciones)
    {
        $id_departamento = $porcentajeEvaluacion['id_departamento'];
        $usuario_evaluado = $porcentajeEvaluacion['usuario_evaluado'];
        $centro = $porcentajeEvaluacion['id_centro_operacione'];
        $fechaI = Carbon::parse($porcentajeEvaluacion['fecha']);
        $fechaFinal = $fechaI->endOfMonth()->format('Y-m-d');
        $fechaInicial = Carbon::parse($porcentajeEvaluacion['fecha'])->format('Y-m-d');
        $consulta = ModelEvaluacionDepartamentos::bucarFechasingresadas($fechaInicial, $fechaFinal, $id_departamento, $usuario_evaluado, $centro);
        if ($consulta == 0) {
            ModelEvaluacionDepartamentos::addEvaluuacionResultado($guardarEvaluaciones, $porcentajeEvaluacion);
            return response()->json(['mensaje' => "Guardado Con Exito", 'icono' => 'success', 'evaluacion' => $guardarEvaluaciones, 'porcentaje' => $porcentajeEvaluacion], 200);
        } else {
            return response()->json(['mensaje' => "¡Ya tiene un registro en este Mes!", 'icono' => 'error'], 500);
        }
    }

    public function obtenerDatos(Request $request)
    {
        $dato = $request->datos;
        $departamentos = ModelEvaluacionDepartamentos::bucarResultadosEvaluacion($request['cedula'], $request['fecha'], $request['id_centro']);
        $parametros = ModelEvaluacionDepartamentos::buscarParametrosEvaluados($request['cedula'], $request['fecha'], $request['id_centro']);
        $datos = ['departamentos' => $departamentos, 'parametros' => $parametros];
        return $datos;
    }



    // -------------------- historial personal evaluado -------------------------------------

    public function historialPersonalEvaluado(Request $request)
    {
        $fecha = $request->fecha;
        $id_departamento = $request->idDepartamento;
        if ($id_departamento != '1') {
            $coordinadores = ModelEvaluacionDepartamentos::getObtenerCoordinadores();
        } else {
            $coordinadores =  ModelEvaluacionDepartamentos::coordinadoresEvaludoPorUsuario(Auth::user()->id);
        }
        $resultadosPorCoordinador = [];
        foreach ($coordinadores as $coordinador) {
            if ($id_departamento != '1') {
                $centrosCoordinador = ModelEvaluacionDepartamentos::getObtenerCentroOperacionesCoordinador($coordinador->id);
            } else {
                $centrosCoordinador = ModelEvaluacionDepartamentos::obtenerCentroOperacionEvaluador($coordinador->id, Auth::user()->id);
            }
            $resultados = [];
            foreach ($centrosCoordinador as $centro) {
                $fechaDb = new DateTime($centro->fecha_deshabilitado);
                $fechaAsignacion = new DateTime($centro->fecha_asignacion);
                $resultadosCentro = [];
                foreach (range(1, 12) as $mes) {
                    $fechaFormateada = date('Y-m', strtotime("$fecha-$mes"));
                    $resultadoMes = ModelEvaluacionDepartamentos::obtenerDatoEvaluacion($coordinador->id, $centro->id, $fechaFormateada, $id_departamento);
                    $resultadosCentro[] = [
                        'resultado' => $resultadoMes ? true : false,
                    ];
                }

                if ($fechaAsignacion->format('Y') <= $fecha && (empty($fechaDb) || $fechaDb->format('Y') >= $fecha)) {
                    $centro->resultado = $resultadosCentro;
                    $resultados[] = $centro;
                }
            }
            $coordinadorCentro = [
                'coordinador' => $coordinador->nombre,
                'centros' => $resultados,
            ];
            $resultadosPorCoordinador[] = $coordinadorCentro;
        }

        $tabla = view('apps.intranet.evaluacionRegional.cargarTablaHistorialEvaluado', ['datos' => $resultadosPorCoordinador])->render();
        return response()->json(['tabla' => $tabla], 200);
    }


    // ------------------ buscar historial de resultados en años ---------------------------

    public function buscarHistorialAnos(Request $request)
    {
        $fechaInicialOriginal = $request->fechaInicial;
        $fechaFinal = $request->fechaFinal;
        $resultadosTotales = [];

        foreach (ModelEvaluacionDepartamentos::getObtenerCoordinadores() as $coordinador) {
            $fechaInicial = $fechaInicialOriginal;

            $resultadosPorCoordinador = [
                'id_coordinador' => $coordinador->id,
                'nombre' => $coordinador->nombre,
                'resultados' => [], // Array para resultados y fechas
            ];

            while ($fechaInicial <= $fechaFinal) {
                $resultadosPorAño = ModelEvaluacionDepartamentos::resultadoPorAño($coordinador->id, $fechaInicial);

                // Almacenar el resultado para cada año
                $resultadosPorCoordinador['resultados'][$fechaInicial] = $resultadosPorAño ?? 0;

                // Incrementar la fechaInicial en un año
                $fechaInicial = $fechaInicial + 1;
            }

            $resultadosTotales[] = $resultadosPorCoordinador;
        }

        return view('apps.intranet.evaluacionRegional.cargarTablaPorAño', compact('resultadosTotales'));
    }


    // ----------------------- obtenr coordinadores -----------------------------
    public function obtenerCoordinadores(Request $request)
    {
        $coordinadores = ModelEvaluacionDepartamentos::getObtenerCoordinadores();
        return response()->json(['coordinadores' => $coordinadores], 200);
    }


    public function obtenerCentroCoordinadores(Request $request)
    {
        $coordinador = $request->coordinador;
        $centrosOperaciones = ModelEvaluacionDepartamentos::centrosOperacionesAsignados($coordinador);
        return view('apps.intranet.evaluacionRegional.tablaCentroOperacion', compact('centrosOperaciones'));
    }


    public function actualizarCentroCoordinadores(Request $request)
    {
        $id = $request->idCentroAsignado;
        $estado = $request->estado;
        $idCoordinador = $request->idCoordinador;
        $idCentroOperacion = $request->idCentroOperacion;
        $fechaActual = ($estado == 'Deshabilitado') ? date("Y-m-d") : null ;
        if ($estado == 'Deshabilitado') {
            $fechaBuscar = date('Y');
            $cantidaResgistro = ModelEvaluacionDepartamentos::cantidadRegistrosEvaluacion($idCoordinador, $idCentroOperacion, $fechaBuscar);
            if ($cantidaResgistro->total == 0) {
                $fechaActual = date('Y-m-d', strtotime('first day of December last year'));
            }
        }
        $actualizarEstado = ModelEvaluacionDepartamentos::actualizarEstadoCentroAsignado($id, $estado, $fechaActual);
        if ($actualizarEstado) {
            return response()->json(['mensaje' => 'Se actualalizo correctamente'], 200);
        } else {
            return response()->json(['error' => 'ocurrio un error al actualizar'], 500);
        };
    }


    public function formularioAsignacionCentroOperacion(Request $request)
    {
        $coordinadores = ModelEvaluacionDepartamentos::getObtenerCoordinadores();
        $centrosOpeaciones = ModelEvaluacionDepartamentos::getObtenerCentroOperaciones();
        $formulario = view('apps.intranet.evaluacionRegional.cargarFormularioAsiganacionCentro', ['coordinadores' => $coordinadores, 'centrosOperaciones' => $centrosOpeaciones])->render();
        return response()->json(['formulario' => $formulario], 200);
    }


    public function asignacionCentroOperacion(Request $request)
    {
        $request->validate([
            'idCoordinador' => 'required',
            'idCentroOperacion' => 'required',
            'idEvaluador' => 'required',
        ]);

        $data = [
            'id_cedula' => $request->idCoordinador,
            'id_centro' => $request->idCentroOperacion,
            'id_evaluador' =>  $request->idEvaluador,
            'estado' => 'Activo',
            'fecha_asignacion' => date("Y-m-d"),
        ];
        $asignarCentro =  ModelEvaluacionDepartamentos::asignarCentroOperacion($data);
        if ($asignarCentro) {
            return response()->json(['mensaje' => 'Asignacion exitosa'], 200);
        } else {
            return response()->json(['error' => 'error al asignar'], 500);
        }
    }
}
