<?php

namespace App\Models\apps\intranet_fabrica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelInicio extends Model
{
    use HasFactory;

    public static function ImagenesDB()
    {
        return DB::connection('db_fabrica')->table('imagenes_carrucel')->where('estado', '=', '1')->get();
    }
}
