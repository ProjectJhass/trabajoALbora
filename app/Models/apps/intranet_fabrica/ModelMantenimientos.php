<?php

namespace App\Models\apps\intranet_fabrica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelMantenimientos extends Model
{
    use HasFactory;

    public static function getMaquinas()
    {
        return DB::connection('db_fabrica')->table('maquinas_hojas_de_vida')
            ->select("referencia", "nombre_maquina", "id_maquina")
            ->get();
    }

    public static function insertMantenice($mantenice)
    {

        return DB::connection('db_fabrica')->table('mantenimiento_maquinas')->insert($mantenice);
    }

    public static function getMantenimientos($id_user, $fecha_min, $fecha_max)
    {
        return DB::connection('db_fabrica')->table('mantenimiento_maquinas')
            ->where('id_user', $id_user)
            ->where('estado', 'programado')
            ->whereBetween('fecha_mantenimiento', [$fecha_min, $fecha_max])
            ->orderByDesc('id_mantenimiento')
            ->get();
    }


    public static function getReferenceAndName($id)
    {

        return DB::connection('db_fabrica')->table('maquinas_hojas_de_vida')
            ->where('id_maquina', $id)
            ->select('nombre_maquina', 'referencia')
            ->get();
    }


    public static function getHistory($id_maquina)
    {

        return DB::connection('db_fabrica')->table('mantenimiento_maquinas')
            ->where('id_maquina', $id_maquina)
            ->orderByDesc('id_mantenimiento')
            ->get();
    }


    public static function checkValidate($fecha_min)
    {

        return DB::connection('db_fabrica')->table('mantenimiento_maquinas')
            ->where('estado', 'programado')
            ->where('fecha_mantenimiento', '>=', $fecha_min)
            ->orderByDesc('id_mantenimiento')
            ->get();
    }



    public static function getAllMantenices()
    {

        return DB::connection('db_fabrica')->table('mantenimiento_maquinas')
            ->where('estado', 'programado')
            ->orderByDesc('id_mantenimiento')
            ->get();
    }


    public static function getIdMantenice($id_mantenice)
    {

        return DB::connection('db_fabrica')->table('mantenimiento_maquinas')
            ->where('id_mantenimiento', '=', $id_mantenice)
            ->get();
    }


    public static function changeMantenice($id_mantenice, $data)
    {
        return DB::connection('db_fabrica')->table('mantenimiento_maquinas')
            ->where('id_mantenimiento', '=', $id_mantenice)
            ->update($data);
    }

    public static function deleteMantenices($id_mantenice)
    {


        return DB::connection('db_fabrica')->table('mantenimiento_maquinas')
            ->where('id_mantenimiento', '=', $id_mantenice)
            ->delete();
    }


    public static function getMantenicesUser()
    {

        return DB::connection('db_fabrica')->table('mantenimiento_maquinas')
            ->where('estado', '=', "programado")
            ->orderByDesc('id_mantenimiento')
            ->get();
    }


    public static function getDateMonth($month, $anio)
    {
        return DB::connection('db_fabrica')->table('fechas_extraccion')
            ->whereYear('fecha', $anio)
            ->whereMonth('fecha', $month)
            ->get();
    }

    public static function getMantenicesUsers($id_user, $fecha_min, $fecha_max)
    {
        return DB::connection('db_fabrica')->table('mantenimiento_maquinas')
            ->where('id_user', $id_user)
            ->whereBetween('fecha_mantenimiento', [$fecha_min, $fecha_max])
            ->where('estado', 'programado')
            ->orderByDesc('id_mantenimiento')
            ->get();
    }


    public static function getDiasNoLaborales()
    {

        return DB::connection('db_fabrica')->table('fechas_extraccion')->get();
    }

    public static function getDiasNoLaborales2($fecha)
    {

        return DB::connection('db_fabrica')->table('fechas_extraccion')->where('fecha', $fecha)->count();
    }

    public static function getfechaProxima($fecha)
    {
        $query =  DB::connection('db_fabrica')->table('fechas_extraccion')->where('fecha', $fecha)->limit(1)->get();
        $dat =  $query->first();
        $fecha_pr = !empty($dat->fecha) ? $dat->fecha : date('Y-m-d');
        return $fecha_pr;
    }


    public static function getMantenimientoId($id_mantenice)
    {
        $consulta = DB::connection('db_fabrica')->table('mantenimiento_maquinas')
            ->where('id_mantenimiento', "$id_mantenice")
            ->limit(1)
            ->get();

        $consulta1 = $consulta->first();
        return $consulta1;
    }


    public static function requestMantenimiento($id_mantenice, $observacion, $hoy)
    {

        return DB::connection('db_fabrica')->table('mantenimiento_maquinas')
            ->where('id_mantenimiento', '=', $id_mantenice)
            ->update([
                'observacion2' => $observacion,
                'estado' => 'realizado',
                'fecha_realizacion' => $hoy
            ]);
    }


    public static function changeStatus($id_mantenimiento)
    {
        return DB::connection('db_fabrica')->table('mantenimiento_maquinas')
            ->where('id_mantenimiento', '=', $id_mantenimiento)
            ->update(['estado' => 'no realizado']);
    }

    public static function showMantenice($referencia)
    {

        return DB::connection('db_fabrica')->table('mantenimiento_maquinas')
            ->where('referencia', $referencia)
            ->where('estado', 'realizado')
            ->where('hoja_vida', 'true')
            ->orderByDesc('id_mantenimiento')
            ->get();
    }


    public static function getMantenicesDates($referencia, $fecha_i, $fecha_f)
    {
        return DB::connection('db_fabrica')->table('mantenimiento_maquinas')
            ->whereBetween('fecha_realizacion', [$fecha_i, $fecha_f])
            ->where('referencia', $referencia)
            ->where('estado', 'realizado')
            ->where('hoja_vida', 'true')
            ->orderByDesc('id_mantenimiento')
            ->get();
    }


    public static function showNoHistory()
    {

        return DB::connection('db_fabrica')->table('mantenimiento_maquinas')
            ->where('hoja_vida', 'false')
            ->where('estado', 'realizado')
            ->orderByDesc('id_mantenimiento')
            ->get();
    }

    public static function getDaysNoJob($fecha)
    {
        return DB::connection('db_fabrica')->table('fechas_extraccion')->where('fecha', $fecha)->count();
    }


    public static function searcher($buscar)
    {
        return DB::connection('db_fabrica')->table('mantenimiento_maquinas')
            ->where('referencia', 'LIKE', $buscar . '%')
            ->where('hoja_vida', 'false')
            ->orWhere('nombre_maquina', 'LIKE', $buscar . '%')
            ->where('hoja_vida', 'false')
            ->orderByDesc('id_mantenimiento')
            ->get();
    }

    public static function searcherDate($fecha1, $fecha2)
    {
        return DB::connection('db_fabrica')->table('mantenimiento_maquinas')
            ->where('hoja_vida', 'false')
            ->whereBetween('fecha_realizacion', [$fecha1, $fecha2])
            ->orderByDesc('id_mantenimiento')
            ->get();
    }
}
