<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelRegistrarIngresos extends Model
{
    use HasFactory;

    public static function ValidarExistenciaEmpleado($cedula)
    {
        return DB::table('users')->where('id', $cedula)->count();
    }

    public static function RegistrarInformacion($data)
    {
        DB::table('users')->insert($data);
    }

    public static function ObtenerCO($cedula)
    {
        $co = '020';
        $query = DB::table('users')->select(['sucursal'])->where('id', $cedula)->get();
        foreach ($query as $key => $value) {
            $co = $value->sucursal;
        }
        return $co;
    }

    public static function ObtenerIdIngreso($cedula, $fecha)
    {
        $id = 0;
        $query = DB::table('registro_ingreso')
            ->select(['id_row'])
            ->where('id_usuario', $cedula)
            ->where('fecha_registro', $fecha)
            ->get();
        foreach ($query as $key => $value) {
            $id = $value->id_row;
        }
        return $id;
    }

    public static function ValidarIngreso($empleado, $fecha)
    {
        return DB::table('registro_ingreso')
            ->where('id_usuario', $empleado)
            ->where('fecha_registro', $fecha)
            ->whereNotNull('hora_ingreso')->count();
    }

    public static function ValidarSalida($empleado, $fecha)
    {
        return DB::table('registro_ingreso')
            ->where('id_usuario', $empleado)
            ->where('fecha_registro', $fecha)
            ->whereNotNull('hora_salida')->count();
    }

    public static function ValidarReIngreso($empleado, $fecha)
    {
        return DB::table('registro_ingreso')
            ->where('id_usuario', $empleado)
            ->where('fecha_registro', $fecha)
            ->whereNotNull('hora_reingreso')->count();
    }

    public static function RegistrarNovedad($cedula, $fecha, $novedad, $novedad_general, $id_registro_novedad)
    {
        DB::table('novedades')->insert([
            'novedad_salida' => $novedad_general,
            'novedad_usuario' => $novedad,
            'fecha_novedad' => $fecha,
            'id_registro' => $cedula,
            'co' => self::ObtenerCO($cedula),
            'id_registro_ingreso' => $id_registro_novedad
        ]);
    }

    public static function RegistrarIngreso($cedula, $fecha, $hora)
    {
        $co = self::ObtenerCO($cedula);
        return DB::table('registro_ingreso')
            ->insertGetId([
                'co' => $co,
                'fecha_registro' => $fecha,
                'hora_ingreso' => $hora,
                'id_usuario' => $cedula
            ]);
    }

    public static function ActualizarRegistroIngreso($data, $id_table)
    {
        return DB::table('registro_ingreso')->where('id_row', $id_table)->update($data);
    }

    public static function ValidarHoraReIngreso($id_tabla)
    {
        $ingreso = '';
        $salida = '';
        $query = DB::table('registro_ingreso')
            ->select(['hora_reingreso', 'hora_salida_reingreso'])
            ->where('id_row', $id_tabla)
            ->get();
        foreach ($query as $key => $value) {
            $ingreso = $value->hora_reingreso;
            $salida = $value->hora_salida_reingreso;
        }
        if (!empty($ingreso) && empty($salida)) {
            return true;
        }
        return false;
    }
}
