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
            case '002':
                $hora = '09:05:00';
                break;
            case '004':
                $hora = '09:05:00';
                break;
            case '006':
                $hora = '10:05:00';
                break;
            case '007':
                $hora = '10:05:00';
                break;
            case '008':
                $hora = '09:05:00';
                break;
            case '010':
                $hora = '09:05:00';
                break;
            case '011':
                $hora = '09:05:00';
                break;
            case '012':
                $hora = '10:05:00';
                break;
            case '014':
                $hora = '07:00:00';
                break;
            case '017':
                $hora = '09:05:00';
                break;
            case '020':
                $hora = '07:05:00';
                break;
            case '025':
                $hora = '10:05:00';
                break;
            case '027':
                $hora = '10:05:00';
                break;
            case '028':
                $hora = '10:05:00';
                break;
            case '036':
                $hora = '08:35:00';
                break;
            default:
                $hora = '07:05:00';
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
        $co = '020';
        $fecha_i = date('Y-m-d');
        $fecha_f = date('Y-m-d');

        $i_diarios = ModelIngresosSalidas::ObtenerIngresosDiarios($co, $fecha_i, $fecha_f);

        $tarde = ModelIngresosSalidas::ObtenerListadoLlegadasTarde($co, $hora_ingreso, $fecha_i, $fecha_f);
        $temprano = ModelIngresosSalidas::ObtenerListadoATiempo($co, $hora_ingreso, $fecha_i, $fecha_f);

        $inasistencias = self::ObtenerInasistencias($co, $fecha_i, $fecha_f); // devuelve un array

        $novedades = ModelIngresosSalidas::ObtenerNovedadesRealizadas($fecha_i, $fecha_f, $co);

        $empleados = ModelIngresosSalidas::ObtenerCantidadEmpleados($co);

        $info = view('apps.intranet.ingresos.tables.estadisticas', ['diarios' => $i_diarios, 'tarde' => $tarde, 'temprano' => $temprano, 'inasistencias' => $inasistencias, 'novedades' => $novedades, 'empleados' => $empleados])->render();

        return view('apps.intranet.ingresos.estadisticas', ['info' => $info]);
    }

    public function actualizarEstadisticas(Request $request)
    {
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $co = $request->co;

        $hora_ingreso = self::HoraIngreso($co);

        $i_diarios = ModelIngresosSalidas::ObtenerIngresosDiarios($co, $fecha_i, $fecha_f);

        $tarde = ModelIngresosSalidas::ObtenerListadoLlegadasTarde($co, $hora_ingreso, $fecha_i, $fecha_f);
        $temprano = ModelIngresosSalidas::ObtenerListadoATiempo($co, $hora_ingreso, $fecha_i, $fecha_f);

        $inasistencias = self::ObtenerInasistencias($co, $fecha_i, $fecha_f); // devuelve un array

        $novedades = ModelIngresosSalidas::ObtenerNovedadesRealizadas($fecha_i, $fecha_f, $co);

        $empleados = ModelIngresosSalidas::ObtenerCantidadEmpleados($co);

        $info = view('apps.intranet.ingresos.tables.estadisticas', ['diarios' => $i_diarios, 'tarde' => $tarde, 'temprano' => $temprano, 'inasistencias' => $inasistencias, 'novedades' => $novedades, 'empleados' => $empleados])->render();
        return response()->json(['status' => true, 'info' => $info], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function ingresos()
    {
        $co = '020';
        $fecha_i = date('Y-m-d');
        $fecha_f = date('Y-m-d');
        $data = ModelIngresosSalidas::ObtenerDataIngresosDiarios($fecha_i, $fecha_f, $co);
        $table = view('apps.intranet.ingresos.tables.infoIngresos', ['info' => $data])->render();
        return view('apps.intranet.ingresos.diarios', ['table' => $table]);
    }

    public function searchInfoIngresos(Request $request)
    {
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $co = $request->co;
        $data = ModelIngresosSalidas::ObtenerDataIngresosDiarios($fecha_i, $fecha_f, $co);
        $table = view('apps.intranet.ingresos.tables.infoIngresos', ['info' => $data])->render();
        return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }


    public function tarde()
    {
        $hora_ingreso = self::HoraIngreso('020');

        $co = session('centro_operacion') != '' ? session('centro_operacion') : '020';
        $fecha_i = session('fecha_i_ingresos') != '' ? session('fecha_i_ingresos') : date('Y-m-d');
        $fecha_f = session('fecha_f_ingresos') != '' ? session('fecha_f_ingresos') : date('Y-m-d');

        $data = ModelIngresosSalidas::ObtenerDataLlegadasTarde($fecha_i, $fecha_f, $co, $hora_ingreso);

        $dataArray = [];

        foreach ($data as $item) {
            $dataArray[] = array(
                "id" => $item->id,
                "nombre" => $item->nombre,
                "fecha_registro" => $item->fecha_registro,
                "hora_ingreso" => $item->hora_ingreso,
                "hora_salida" => $item->hora_salida,
                "hora_reingreso" => $item->hora_reingreso,
                "hora_salida_reingreso" => $item->hora_salida_reingreso,
                "id_row" => self::searchNovedades($item->fecha_registro, $co, $item->id)
            );
        }

        $table = view('apps.intranet.ingresos.tables.infoLlegadasTarde', ['info' => $dataArray])->render();
        return view('apps.intranet.ingresos.tarde', ['table' => $table]);
    }

    public function searchLlegadasTarde(Request $request)
    {
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $co = $request->co;

        $hora_ingreso = self::HoraIngreso($co);
        $data_items = ModelIngresosSalidas::ObtenerDataLlegadasTarde($fecha_i, $fecha_f, $co, $hora_ingreso);

        $dataArray = [];

        foreach ($data_items as $item) {
            $dataArray[] = array(
                "id" => $item->id,
                "nombre" => $item->nombre,
                "fecha_registro" => $item->fecha_registro,
                "hora_ingreso" => $item->hora_ingreso,
                "hora_salida" => $item->hora_salida,
                "hora_reingreso" => $item->hora_reingreso,
                "hora_salida_reingreso" => $item->hora_salida_reingreso,
                "id_row" => self::searchNovedades($item->fecha_registro, $co, $item->id)
            );
        }

        $table = view('apps.intranet.ingresos.tables.infoLlegadasTarde', ['info' => $dataArray])->render();
        return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function searchNovedades($fecha_novedad, $co, $id_cc)
    {
        return ModelIngresosSalidas::ObtenerInformacionNovedadesLlegadasTarde($co, $fecha_novedad, $id_cc);
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
        $co = '020';
        $fecha_i = date('Y-m-d');
        $fecha_f = date('Y-m-d');

        $data = self::ObtenerListadoInasistenciasUsuarios($co, $fecha_i, $fecha_f);
        $table = view('apps.intranet.ingresos.tables.infoInasistencias', ['info' => $data])->render();
        return view('apps.intranet.ingresos.inasistencias', ['table' => $table]);
    }

    public function searchInfoInasistencias(Request $request)
    {
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $co = $request->co;

        $data = self::ObtenerListadoInasistenciasUsuarios($co, $fecha_i, $fecha_f);
        $table = view('apps.intranet.ingresos.tables.infoInasistencias', ['info' => $data])->render();
        return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function novedades()
    {
        $data = array();

        $co = '020';
        $fecha_i = date('Y-m-d');
        $fecha_f = date('Y-m-d');

        $novedades = ModelIngresosSalidas::ObtenerInformacionNovedades($co, $fecha_i, $fecha_f);
        foreach ($novedades as $key => $value) {
            $data_nov = ModelIngresosSalidas::ObtenerInformacionEmpleadosNovedades($value->id);
            array_push($data, (['cedula' => $value->id, 'nombre' => $value->nombre, 'novedades' => $data_nov]));
        }

        $table = view('apps.intranet.ingresos.tables.infoNovedades', ['info' => $data])->render();
        return view('apps.intranet.ingresos.novedades', ['table' => $table]);
    }

    public function getInfoNovedades(Request $request)
    {
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $co = $request->co;

        $data = array();

        $novedades = ModelIngresosSalidas::ObtenerInformacionNovedades($co, $fecha_i, $fecha_f);
        foreach ($novedades as $key => $value) {
            $data_nov = ModelIngresosSalidas::ObtenerInformacionEmpleadosNovedades($value->id);
            array_push($data, (['cedula' => $value->id, 'nombre' => $value->nombre, 'novedades' => $data_nov]));
        }
        $table = view('apps.intranet.ingresos.tables.infoNovedades', ['info' => $data])->render();
        return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
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
