<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelDocumentosTemporales extends Model
{
    use HasFactory;

    public static function ObtenerDocumentosTemporales($dpto)
    {
        return DB::table('documentos_temporales')->where('dpto', $dpto)->orderByDesc('created_at')->get();
    }

    public static function CargarDocumentosTmp($data)
    {
        DB::table('documentos_temporales')->insert($data);
    }
}
