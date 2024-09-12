<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelIngresosSalidas extends Model
{
    use HasFactory;

    public static function ObtenerListadoLlegadasTarde($co, $hora_minima, $fecha_i, $fecha_f)
    {

        return DB::table('registro_ingreso')
            ->where('co', $co)
            ->whereBetween('fecha_registro', ([$fecha_i, $fecha_f]))
            ->where('hora_ingreso', '>', $hora_minima)
            ->count();
    }

    public static function ObtenerListadoATiempo($co, $hora_minima, $fecha_i, $fecha_f)
    {
        return DB::table('registro_ingreso')
            ->where('co', $co)
            ->whereBetween('fecha_registro', ([$fecha_i, $fecha_f]))
            ->where('hora_ingreso', '<=', $hora_minima)
            ->count();
    }

    public static function ObtenerIngresosDiarios($co, $fecha_i, $fecha_f)
    {
        return DB::table('registro_ingreso')
            ->where('co', $co)
            ->whereBetween('fecha_registro', ([$fecha_i, $fecha_f]))
            ->count();
    }

    public static function ObtenerCantidadEmpleados($sucursal)
    {
        return DB::table('users')->where('ingreso_personal', '1')->where('sucursal', $sucursal)->where('estado', 1)->count();
    }

    public static function ObtenerListadoEmpleadosIngreso()
    {
        return DB::table('users')
            ->select(['id', 'nombre'])
            ->where('ingreso_personal', '1')
            ->where("zona", "<>", "0")
            ->where('estado', '1')
            ->orderBy('nombre')
            ->get();
    }

    public static function ObtenerListadoEmpleadosIngresoI($co)
    {
        return DB::table('users')
            ->select(['id', 'nombre'])
            ->where('ingreso_personal', '1')
            ->where('sucursal', $co)
            ->orderBy('nombre')
            ->get();
    }

    public static function ConsultarAsistenciaEmpleados($cedula, $co, $fecha)
    {
        return DB::table('registro_ingreso')
            ->where('co', $co)
            ->where('fecha_registro', $fecha)
            ->where('id_usuario', $cedula)
            ->count();
    }

    public static function ObtenerNovedadesRealizadas($fecha_i, $fecha_f, $co)
    {
        return DB::table('novedades')
            ->whereBetween('fecha_novedad', ([$fecha_i, $fecha_f]))
            ->where('co', $co)
            ->count();
    }

    public static function ObtenerDataIngresosDiarios($fecha_i, $fecha_f, $co)
    {
        return DB::table('registro_ingreso as r')
            ->join('users as u', 'u.id', '=', 'r.id_usuario')
            ->select(['u.id', 'u.nombre', 'r.fecha_registro', 'r.hora_ingreso', 'r.hora_salida', 'r.hora_reingreso', 'r.hora_salida_reingreso'])
            ->whereBetween('r.fecha_registro', ([$fecha_i, $fecha_f]))
            ->where('r.co', $co)
            ->where('u.estado', 1)
            ->get();
    }

    public static function ObtenerDataLlegadasTarde($fecha_i, $fecha_f, $co, $hora_i)
    {
        return DB::table('registro_ingreso as r')
            ->join('users as u', 'u.id', '=', 'r.id_usuario')
            ->select(['u.id', 'u.nombre', 'r.fecha_registro', 'r.hora_ingreso', 'r.hora_salida', 'r.hora_reingreso', 'r.hora_salida_reingreso', 'r.id_row'])
            ->whereBetween('r.fecha_registro', ([$fecha_i, $fecha_f]))
            ->where('r.co', $co)
            ->where('u.estado', 1)
            ->where('r.hora_ingreso', '>', $hora_i)
            ->get();
    }

    public static function ObtenerNovedadesLlegadasTarde($id_row)
    {
        return DB::table('novedades')
        ->where('id_registro_ingreso', $id_row)
        ->limit(1)
        ->orderBy('id_novedad', 'DESC')
        ->get();
    }

    public static function ValidarEventosUsuarios($cedula_u, $fecha_c)
    {
        $fecha_f = date("Y-m-d", strtotime($fecha_c . "+ 1 days"));
        $val = 0;
        $data = DB::table('eventos')
            ->select(['fecha_i', 'fecha_f'])
            ->where('cedula_evento', $cedula_u)
            ->where('tipo_evento', '1')
            ->get();
        foreach ($data as $key => $value) {
            if ($fecha_f <= $value->fecha_f) {
                if ($fecha_c >= $value->fecha_i && $fecha_c <=  $value->fecha_f) {
                    $val = 1;
                }
            }
        }
        return $val;
    }

    public static function ObtenerInformacionNovedades($co, $fecha_i, $fecha_f)
    {
        return DB::table('novedades as n')
            ->join('users as u', 'n.id_registro', '=', 'u.id')
            ->select(['u.id', 'u.nombre'])
            ->where('n.co', $co)
            ->whereBetween('n.fecha_novedad', ([$fecha_i, $fecha_f]))
            ->distinct()
            ->get();
    }

    public static function ObtenerFechasUsuarioNovedades($id_registro)
    {
        return DB::table('novedades')
            ->select(['fecha_novedad'])
            ->where('id_registro', $id_registro)
            ->distinct()
            ->get();
    }

    public static function ObtenerRegistrosIngresoEmpleado($empleado, $fecha)
    {
        return DB::table('registro_ingreso')
            ->select(['fecha_registro', 'hora_ingreso', 'hora_salida', 'hora_reingreso', 'hora_salida_reingreso'])
            ->where('id_usuario', $empleado)
            ->where('fecha_registro', $fecha)
            ->get();
    }

    public static function ObtenerNovedadesEmpleado($empleado, $fecha)
    {
        return DB::table('novedades')
            ->select(['novedad_usuario'])
            ->where('fecha_novedad', $fecha)
            ->where('id_registro', $empleado)
            ->get();
    }

    public static function ObtenerInformacionEmpleadosNovedades($empleado)
    {
        $novedades = array();
        $fechas_usuario = self::ObtenerFechasUsuarioNovedades($empleado);
        foreach ($fechas_usuario as $key => $value) {
            $novedad = '';

            $hora_ingreso = '';
            $hora_salida = '';
            $hora_reingreso = '';
            $hora_sal_re = '';

            $fecha_n = $value->fecha_novedad;
            $data_i = self::ObtenerRegistrosIngresoEmpleado($empleado, $fecha_n);
            $data_n = self::ObtenerNovedadesEmpleado($empleado, $fecha_n);
            foreach ($data_n as $key => $val) {
                $novedad .= $val->novedad_usuario . "<br>";
            }
            foreach ($data_i as $key => $data) {
                $hora_ingreso =  $data->hora_ingreso;
                $hora_salida = $data->hora_salida;
                $hora_reingreso = $data->hora_reingreso;
                $hora_sal_re = $data->hora_salida_reingreso;
            }
            array_push($novedades, (['novedad_usuario' => $novedad, 'fecha_novedad' => $fecha_n, 'hora_ingreso' => $hora_ingreso, 'hora_salida' => $hora_salida, 'hora_reingreso' => $hora_reingreso, 'hora_salida_reingreso' => $hora_sal_re]));
        }
        return $novedades;
    }
}
