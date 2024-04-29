<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelDescargarInfoEventos extends Model
{
    use HasFactory;

    public static function ObtenerInfoEventos($fecha_i, $fecha_f)
    {
        return DB::table('eventos as e')
            ->join('tipo_eventos as t', 't.id_evento', '=', 'e.tipo_evento')
            ->join('zonas as z', 'z.id_zona', '=', 'e.zona')
            ->select(['cedula_evento', 'nombre_evento', 'fecha_i', 'fecha_f', 't.tipo', 'z.zona', 'observaciones', 'cedula_reemplaza', 'nombre_reemplaza'])
            ->whereBetween('fecha_i', ([$fecha_i, $fecha_f]))
            ->get();
    }

    public static function ObtenerInfoNovedades($fecha_i, $fecha_f)
    {
        return DB::table('novedades as n')
        ->select('u.id', 'u.nombre', 'u.sucursal', 'n.novedad_salida', 'n.novedad_usuario', 'n.fecha_novedad', 'r.hora_ingreso', 'r.hora_salida', 'r.hora_reingreso', 'r.hora_salida_reingreso')
        ->leftJoin('registro_ingreso as r', function($join) {
            $join->on('n.id_registro', '=', 'r.id_usuario')
                ->on('r.fecha_registro', '=', 'n.fecha_novedad');
        })
        ->join('users as u', 'n.id_registro', '=', 'u.id')
        ->whereBetween('n.fecha_novedad', [$fecha_i, $fecha_f])
        ->get();
    }

    public static function ObtenerInfoIngresos($fecha_i, $fecha_f)
    {
        return DB::table('users as u')
            ->leftJoin('registro_ingreso as r', 'u.id', '=', 'r.id_usuario')
            ->select(['u.id', 'u.nombre', 'u.sucursal', 'r.fecha_registro', 'r.hora_ingreso', 'r.hora_salida', 'r.hora_reingreso', 'r.hora_salida_reingreso'])
            ->where('u.ingreso_personal', '1')
            ->whereBetween('r.fecha_registro', ([$fecha_i, $fecha_f]))
            ->orderBy('r.fecha_registro')
            ->get();
    }

    public static function ObtenerInfoIngresosNovedades($fecha_i, $fecha_f)
    {
        return DB::table('users as u')
            ->select(
                'u.id',
                'u.nombre',
                'r.co',
                'r.fecha_registro',
                'r.hora_ingreso',
                'r.hora_salida',
                'r.hora_reingreso',
                'r.hora_salida_reingreso',
                DB::raw('GROUP_CONCAT(n.novedad_usuario) AS novedades')
            )
            ->join('registro_ingreso as r', 'u.id', '=', 'r.id_usuario')
            ->leftJoin('novedades as n', function ($join) {
                $join->on('u.id', '=', 'n.id_registro')
                    ->on('r.fecha_registro', '=', 'n.fecha_novedad');
            })
            ->whereBetween('r.fecha_registro', [$fecha_i, $fecha_f])
            ->groupBy('u.id', 'u.nombre', 'r.co', 'r.fecha_registro', 'r.hora_ingreso', 'r.hora_salida', 'r.hora_reingreso', 'r.hora_salida_reingreso')
            ->get();

    }
}
