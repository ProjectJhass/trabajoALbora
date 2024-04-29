<?php

namespace App\Models\apps\intranet_fabrica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelDocsSgc extends Model
{
    use HasFactory;

    public static function ObtenerDocuementosSGC($carpeta, $subcarpeta)
    {
        return DB::connection('db_fabrica')->table('documentacion_sgc')
            ->select(['id_documento', 'nombre_doc', 'documento'])
            ->where('carpeta', '=', $carpeta)
            ->where('subcarpeta', '=', $subcarpeta)
            ->get();
    }

    public static function CargarDocumentoSGC($informacion)
    {
        DB::connection('db_fabrica')->table('documentacion_sgc')->insert($informacion);
    }

    public static function EliminarDocumentoSGC($id_documento)
    {
        return DB::connection('db_fabrica')->table('documentacion_sgc')->where('id_documento', '=', $id_documento)->delete();
    }
}
