<?php

namespace App\Http\Controllers\apps\intranet;

use App\Exports\ExportEventos;
use App\Exports\ExportIngresos;
use App\Exports\ExportIngresosNovedades;
use App\Exports\ExportNovedades;
use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelDominicales;
use App\Models\apps\intranet\ModelIngresosSalidas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ControllerIngresosSalidas extends Controller
{
    protected $id;
    protected $zona;

    public function __construct()
    {
        $this->id = session('id');
        $this->zona = session('zona');
    }

    protected static function HoraIngreso($co)
    {
        switch ($co) {
            case '020':
                $hora = '07:00:00';
                break;
            default:
                $hora = '07:00:00';
                break;
        }
        return $hora;
    }

    protected static function diasPasados($fecha_inicial, $fecha_final)
    {
        $dias = (strtotime($fecha_inicial) - strtotime($fecha_final)) / 86400;
        $dias = abs($dias);
        $dias = floor($dias);
        return $dias;
    }

    protected static function ObtenerInasistencias($co, $fecha_i, $fecha_f)
    {
        $asistencia = 0;
        $inasistencia = 0;

        $usuarios = ModelIngresosSalidas::ObtenerListadoEmpleadosIngresoI($co);
        $dias = self::diasPasados($fecha_i, $fecha_f);

        foreach ($usuarios as $key => $value) {
            $cedula_u = $value->id;

            $fecha_c_i = $fecha_i;

            for ($i = 0; $i <= $dias; $i++) {
                $fecha_c = $fecha_c_i;
                $valor = ModelIngresosSalidas::ConsultarAsistenciaEmpleados($cedula_u, $co, $fecha_c);
                if ($valor == 0) {
                    $inasistencia += 1;
                } else {
                    $asistencia += 1;
                }
                $fecha_c_i = date("Y-m-d", strtotime($fecha_c . "+ 1 days"));
            }
        }

        return array(['asistencia' => $asistencia, 'inasistencia' => $inasistencia]);
    }

    public function index()
    {
        $hora_ingreso = self::HoraIngreso('020');
        $co = session('centro_operacion') != '' ? session('centro_operacion') : '020';
        $fecha_i = session('fecha_i_ingresos') != '' ? session('fecha_i_ingresos') : date('Y-m-d');
        $fecha_f = session('fecha_f_ingresos') != '' ? session('fecha_f_ingresos') : date('Y-m-d');

        $i_diarios = ModelIngresosSalidas::ObtenerIngresosDiarios($co, $fecha_i, $fecha_f);

        $tarde = ModelIngresosSalidas::ObtenerListadoLlegadasTarde($co, $hora_ingreso, $fecha_i, $fecha_f);
        $temprano = ModelIngresosSalidas::ObtenerListadoATiempo($co, $hora_ingreso, $fecha_i, $fecha_f);

        $inasistencias = self::ObtenerInasistencias($co, $fecha_i, $fecha_f); // devuelve un array

        $novedades = ModelIngresosSalidas::ObtenerNovedadesRealizadas($fecha_i, $fecha_f, $co);

        $empleados = ModelIngresosSalidas::ObtenerCantidadEmpleados();

        return view('apps.intranet.ingresos.estadisticas', ['fecha_i' => $fecha_i, 'fecha_f' => $fecha_f, 'co_' => $co, 'diarios' => $i_diarios, 'tarde' => $tarde, 'temprano' => $temprano, 'inasistencias' => $inasistencias, 'novedades' => $novedades, 'empleados' => $empleados]);
    }
    public function ingresos()
    {
        $co = session('centro_operacion') != '' ? session('centro_operacion') : '020';
        $fecha_i = session('fecha_i_ingresos') != '' ? session('fecha_i_ingresos') : date('Y-m-d');
        $fecha_f = session('fecha_f_ingresos') != '' ? session('fecha_f_ingresos') : date('Y-m-d');

        $data = ModelIngresosSalidas::ObtenerDataIngresosDiarios($fecha_i, $fecha_f, $co);
        return view('apps.intranet.ingresos.diarios', ['fecha_i' => $fecha_i, 'fecha_f' => $fecha_f, 'co_' => $co, 'info' => $data]);
    }

    public function tarde()
    {
        $hora_ingreso = self::HoraIngreso('020');

        $co = session('centro_operacion') != '' ? session('centro_operacion') : '020';
        $fecha_i = session('fecha_i_ingresos') != '' ? session('fecha_i_ingresos') : date('Y-m-d');
        $fecha_f = session('fecha_f_ingresos') != '' ? session('fecha_f_ingresos') : date('Y-m-d');

        $data = ModelIngresosSalidas::ObtenerDataLlegadasTarde($fecha_i, $fecha_f, $co, $hora_ingreso);
        return view('apps.intranet.ingresos.tarde', ['fecha_i' => $fecha_i, 'fecha_f' => $fecha_f, 'co_' => $co, 'info' => $data]);
    }

    protected static function ObtenerListadoInasistenciasUsuarios($co, $fecha_i, $fecha_f)
    {
        $inasistencia = array();

        $usuarios = ModelIngresosSalidas::ObtenerListadoEmpleadosIngresoI($co);
        $dias = self::diasPasados($fecha_i, $fecha_f);

        foreach ($usuarios as $key => $value) {
            $cedula_u = $value->id;
            $nombre_  = $value->nombre;

            $fecha_c = $fecha_i;

            for ($i = 0; $i <= $dias; $i++) {
                $validar_evento = ModelIngresosSalidas::ValidarEventosUsuarios($cedula_u, $fecha_c);
                if ($validar_evento == 0) {
                    $valor = ModelIngresosSalidas::ConsultarAsistenciaEmpleados($cedula_u, $co, $fecha_c);
                    if ($valor == 0) {
                        array_push($inasistencia, (['cedula' => $cedula_u, 'nombre' => $nombre_, 'fecha' => $fecha_c]));
                    }
                }
                $fecha_c = date("Y-m-d", strtotime($fecha_c . "+ 1 days"));
            }
        }

        return $inasistencia;
    }

    public function inasistencias()
    {
        $co = session('centro_operacion') != '' ? session('centro_operacion') : '020';
        $fecha_i = session('fecha_i_ingresos') != '' ? session('fecha_i_ingresos') : date('Y-m-d');
        $fecha_f = session('fecha_f_ingresos') != '' ? session('fecha_f_ingresos') : date('Y-m-d');

        $data = self::ObtenerListadoInasistenciasUsuarios($co, $fecha_i, $fecha_f);
        return view('apps.intranet.ingresos.inasistencias', ['fecha_i' => $fecha_i, 'fecha_f' => $fecha_f, 'co_' => $co, 'info' => $data]);
    }

    public function novedades()
    {
        $data = array();

        $co = session('centro_operacion') != '' ? session('centro_operacion') : '020';
        $fecha_i = session('fecha_i_ingresos') != '' ? session('fecha_i_ingresos') : date('Y-m-d');
        $fecha_f = session('fecha_f_ingresos') != '' ? session('fecha_f_ingresos') : date('Y-m-d');

        $novedades = ModelIngresosSalidas::ObtenerInformacionNovedades($co, $fecha_i, $fecha_f);
        foreach ($novedades as $key => $value) {
            $data_nov = ModelIngresosSalidas::ObtenerInformacionEmpleadosNovedades($value->id);
            array_push($data, (['cedula' => $value->id, 'nombre' => $value->nombre, 'novedades' => $data_nov]));
        }
        return view('apps.intranet.ingresos.novedades', ['fecha_i' => $fecha_i, 'fecha_f' => $fecha_f, 'co_' => $co, 'info' => $data]);
    }

    public function registrarNovedad()
    {
        $asesores = ModelIngresosSalidas::ObtenerListadoEmpleadosIngreso();
        return view('apps.intranet.ingresos.registrar_novedad', ['asesores' => $asesores]);
    }

    public function dominicales()
    {
        $zona = session('zona_calendario') != '' ? session('zona_calendario') : $this->zona;
        $asesores = ModelDominicales::ObtenerAsesoresZona($zona);
        $eventos = ModelDominicales::ObtenerEventos($zona);
        $t_asesores = ModelIngresosSalidas::ObtenerListadoEmpleadosIngreso();
        return view('apps.intranet.ingresos.dominicales', ['asesores' => $asesores, 'eventos' => $eventos, 'zona_' => $zona, 'asesores_' => $t_asesores]);
    }

    public function exportar()
    {
        return view('apps.intranet.ingresos.exportar');
    }

    public function descargarExcel(Request $request)
    {
        if ($request->has('dominicales')) {
            return Excel::download(new ExportEventos($request->fecha_i, $request->fecha_f), 'informacion-dominicales-y-descansos.xlsx');
        }
        if ($request->has('novedades')) {
            return Excel::download(new ExportNovedades($request->fecha_i, $request->fecha_f), 'reporte-novedades-' . date('Y-m-d') . '.xlsx');
        }
        if ($request->has('ingresos')) {
            return Excel::download(new ExportIngresos($request->fecha_i, $request->fecha_f), 'reporte-ingresos-diarios-' . date('Y-m-d') . '.xlsx');
        }
        if ($request->has('ingresosNovedades')) {
            return Excel::download(new ExportIngresosNovedades($request->fecha_i, $request->fecha_f), 'reporte-ingresos-diarios-' . date('Y-m-d') . '.xlsx');
        }
    }
}
