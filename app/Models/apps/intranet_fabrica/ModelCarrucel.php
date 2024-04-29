<?php

namespace App\Models\apps\intranet_fabrica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelCarrucel extends Model
{
    use HasFactory;

    public static function ImagenesDB()
    {
        return DB::connection('db_fabrica')->table('imagenes_carrucel')->get();
    }

    public static function ObtenerEstadoIMG($id_img)
    {
        $query = DB::connection('db_fabrica')->table('imagenes_carrucel')->select(['estado'])->where('id_imagen', '=', $id_img)->get();
        foreach ($query as $key => $value) {
            $estado = $value->estado;
        }
        return $estado;
    }

    public static function ObtenerNombreIMG($id_img)
    {
        $query = DB::connection('db_fabrica')->table('imagenes_carrucel')->select(['nombre_img'])->where('id_imagen', '=', $id_img)->get();
        foreach ($query as $key => $value) {
            $nombre_i = $value->nombre_img;
        }
        return $nombre_i;
    }

    public static function ActualizarEstadoImg($id_img, $estado)
    {
        return DB::connection('db_fabrica')->table('imagenes_carrucel')->where('id_imagen','=', $id_img)->update(['estado'=>$estado]);
    }

    public static function GuardarInformacionImagenes($nombre_i, $tipo, $tama, $seccion)
    {
        $data = ([
            'nombre_img' => $nombre_i,
            'tipo_img' => $tipo,
            'tama_img' => $tama,
            'seccion_img' => $seccion,
            'estado' => '0'
        ]);

        return DB::connection('db_fabrica')->table('imagenes_carrucel')->insert($data);
    }

    public static function EliminarImagenesCarrucel($id_imagen){
        return DB::connection('db_fabrica')->table('imagenes_carrucel')->where('id_imagen','=', $id_imagen)->delete();
    }
}
