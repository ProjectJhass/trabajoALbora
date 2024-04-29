<?php

namespace App\Models\apps\intranet_fabrica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelComentariosHojasDeVida extends Model
{
    use HasFactory;

    public static function crearComentario($data)
    {
        return DB::connection('db_fabrica')->table('comentarios_hojas_vidas')->insert($data);
    }


    public static function obtenerComentarios($idMaquina)
    {
        return DB::connection('db_fabrica')->table('comentarios_hojas_vidas')
            ->where('referencia_maquina', $idMaquina)
            ->get();
    }
}
