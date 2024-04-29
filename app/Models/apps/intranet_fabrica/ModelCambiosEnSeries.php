<?php

namespace App\Models\apps\intranet_fabrica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelCambiosEnSeries extends Model
{
    use HasFactory;

    public static function GuardarInformacionReporte($informacion)
    {
        foreach ($informacion as $key => $val) {
            $id_i = DB::connection('db_fabrica')->table('reportes_y_analisis')->insertGetId([
                'producto' => $val['producto'],
                'pieza' => $val['pieza'],
                'op' => $val['op'],
                'problema' => $val['problema'],
                'cambio' => $val['cambio'],
                'imagen' => $val['imagen']
            ]);
        }
        return $id_i;
    }

    public static function GuardarImagenesDeReporte($tipo_archivo, $nombre_archivo, $id_reporte)
    {
        DB::connection('db_fabrica')->table('soportes_de_cambio')->insert(
            [
                'tipo_archivo' => $tipo_archivo,
                'nombre_archivo' => $nombre_archivo,
                'id_reporte' => $id_reporte
            ]
        );
    }

    public static function AgregarCambiosPorSeccion($seccion, $actividad, $responsable, $id_reporte)
    {
        DB::connection('db_fabrica')->table('cambios_por_seccion')->insert(
            [
                'id_seccion' => $seccion,
                'actividad' => $actividad,
                'responsable' => $responsable,
                'id_reporte' => $id_reporte
            ]
        );
    }

    public static function ObtenerReporteCambio($id_reporte)
    {
        return DB::connection('db_fabrica')->table('reportes_y_analisis')->where('id_reporte', '=', $id_reporte)->get();
    }

    public static function ObtenerImagenesReporte($id_reporte)
    {
        return DB::connection('db_fabrica')->table('soportes_de_cambio')->select('nombre_archivo')->where('id_reporte', '=', $id_reporte)->get();
    }

    public static function ObtenerCambiosSeccion($id_reporte)
    {
        return DB::connection('db_fabrica')->table('cambios_por_seccion')
            ->where('id_reporte', '=', $id_reporte)
            ->get();
    }
}
