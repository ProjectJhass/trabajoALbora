<?php

namespace App\Models\apps\intranet_fabrica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelHojaDeVida extends Model
{
    use HasFactory;

    public static function ObtenerMaquinas()
    {
        return DB::connection('db_fabrica')->table('maquinas_hojas_de_vida')->orderBy('nombre_maquina')->get();
    }


    public static function ObtenerhistorialMaquina($referencia)
    {
        return DB::connection('db_fabrica')->table('solicitudes_mtto')
            ->where('maquina', 'LIKE', $referencia . '%')
            ->get();
    }


    public static function cantidadSolicitudRealizadasMaquina($referencia)
    {
        return DB::connection('db_fabrica')->table('fabrica_app.solicitudes_mtto')
            ->where('maquina', 'like', $referencia . '%')
            ->where('estado_solicitud', 'CERRADA')
            ->count();
    }


    public static function cantidadSolicitudMaquina($referencia)
    {
        return DB::connection('db_fabrica')->table('fabrica_app.solicitudes_mtto')
            ->where('maquina', 'like', $referencia . '%')
            ->count();
    }


    public static function actualizarImagenMaquina($idMaquina, $nombreImagen)
    {
        return DB::connection('db_fabrica')->table('maquinas_hojas_de_vida')
            ->where('id_maquina', $idMaquina)
            ->update(['imagen' => $nombreImagen]);
    }


    public static function ObtenerhistorialPorFecha($referenciaMaquina, $fechaInicial, $fechaFinal)
    {
        return DB::connection('db_fabrica')->table('solicitudes_mtto')
            ->where('maquina', 'LIKE', $referenciaMaquina . '%')
            ->whereBetween('fecha_solicitud', [$fechaInicial, $fechaFinal])
            ->get();
    }
}
