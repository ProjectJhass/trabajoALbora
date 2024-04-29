<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelRecursosHumanos extends Model
{
    use HasFactory;

    public static function ObtenerInfoReglamento()
    {
        return DB::table('registro_reglamento')->orderByDesc('created_at')->get();
    }

    //mysql_api

    public static function vaciarDBApi()
    {
        DB::connection('mysql_api')->table('solicitudes')->delete();
    }
}