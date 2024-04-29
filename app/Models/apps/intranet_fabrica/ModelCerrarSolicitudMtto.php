<?php

namespace App\Models\apps\intranet_fabrica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelCerrarSolicitudMtto extends Model
{
    use HasFactory;

    public static function ObtenerSolicitudesAbiertas($seccion)
    {
        return DB::connection('db_fabrica')->table('solicitudes_mtto')
            ->select(['id_solicitud', 'solicitud', 'seccion', 'maquina', 'responsable_s', 'fecha_solicitud'])
            ->where('estado_solicitud', '=', 'REVISION')
            ->where('seccion', '=', $seccion)->get();
    }

    public static function ObtenerHistorialSolicitudMtto($id_solicitud)
    {
        return DB::connection('db_fabrica')->table('solicitudes_mtto')->where('id_solicitud', '=', $id_solicitud)->get();
    }

    public static function ActualizarCerrarSolicitudMtto($id_solicitud, $informacion){
        return DB::connection('db_fabrica')->table('solicitudes_mtto')->where('id_solicitud', '=', $id_solicitud)->update($informacion);

    }
}
