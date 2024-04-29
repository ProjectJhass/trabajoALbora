<?php

namespace App\Models\apps\intranet_fabrica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelSolicitudesMtto extends Model
{
    use HasFactory;

    public static function all_s()
    {
        return DB::connection('db_fabrica')->table('solicitudes_mtto')->get();
    }

    public static function ObtenerInformacionSolicitudes($id_solicitud)
    {
        return DB::connection('db_fabrica')->table('solicitudes_mtto')
            ->select(['id_solicitud', 'solicitud', 'seccion', 'maquina', 'responsable_s', 'fecha_solicitud','respuesta_solicitud','estado_solicitud'])
            ->where('id_solicitud', '=', $id_solicitud)->get();
    }

    public static function ObtenerHerramientasFabrica()
    {
        return DB::connection('db_fabrica')->table('herramientas_fabrica')->get();
    }

    public static function ObtenerSeccionesFabrica()
    {
        return DB::connection('db_fabrica')->table('secciones_fabrica')->where('id_proceso', '=', '1')->get();
    }

    public static function AgregarNuevasSolicitudesMtto($informacion)
    {
        return DB::connection('db_fabrica')->table('solicitudes_mtto')->insertGetId($informacion);
    }

    public static function ObtenerSolicitudesPorRangoFecha($fecha_i, $fecha_f)
    {
        return DB::connection('db_fabrica')->table('solicitudes_mtto')->whereBetween('fecha_solicitud', [$fecha_i, $fecha_f])->get();
    }

    public static function ObtenerSolicitudesMttoPendientes()
    {
        return DB::connection('db_fabrica')->table('solicitudes_mtto')->where('estado_solicitud', '=', 'ABIERTA')->get();
    }

    public static function ActualizarSolucionSolicitudMtto($data, $id_solicitud)
    {
        return DB::connection('db_fabrica')->table('solicitudes_mtto')->where('id_solicitud', '=', $id_solicitud)->update($data);
    }
}
