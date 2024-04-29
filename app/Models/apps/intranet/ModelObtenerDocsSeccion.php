<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelObtenerDocsSeccion extends Model
{
    use HasFactory;

    public static function ObtenerDocumentacionIntranet($seccion)
    {
        return DB::table('documentos_cargados')->where('seccion', $seccion)->orderByDesc('created_at')->get();
    }
}
