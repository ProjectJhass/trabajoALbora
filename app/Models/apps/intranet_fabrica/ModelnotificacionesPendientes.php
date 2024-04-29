<?php

namespace App\Models\apps\intranet_fabrica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelnotificacionesPendientes extends Model
{
    use HasFactory;
    
    public static function notificacionesPendientes($id){
        return DB::connection('db_fabrica')->table('comentarios_ideas AS c')
        ->join('users AS u', 'u.id','=','c.id_usuario')
        ->where('c.id_ideas', $id)
        ->select('c.comentarios','u.nombre','u.id','c.fecha_comentario','c.hora_comentario','c.id_comentario','c.id_ideas')
        ->orderBy('c.id_comentario','desc')
        ->get();
    }
}
