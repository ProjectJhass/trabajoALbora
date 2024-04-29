<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelCargarDocumentos extends Model
{
    use HasFactory;

    public static function CargarDocumentacion($data)
    {
        DB::table('documentos_cargados')->insert($data);
    }

    public static function ObtenerNombreDocumento($id)
    {
        $data = DB::table('documentos_cargados')->where('id_documento', $id)->get('documento');
        foreach ($data as $key => $value) {
            return $value->documento;
        }
        return '';
    }

    public static function EliminarDocumentoDB($id)
    {
        return DB::table('documentos_cargados')->where('id_documento', $id)->delete();
    }
}
