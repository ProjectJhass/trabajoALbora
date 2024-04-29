<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelComments extends Model
{
    use HasFactory;

    protected $table = 'comentarios_ideas';


    public static function insertComment($data){

        return DB::table('comentarios_ideas')->insert($data);

    }


    public static function getComments($id_idea){
        return DB::table('comentarios_ideas AS c')
        ->join('users AS u', 'u.id','=','c.id_usuario')
        ->where('c.id_ideas', $id_idea)
        ->select('c.comentarios','u.nombre','u.id','c.fecha_comentario','c.hora_comentario','c.id_comentario','c.id_ideas')
        ->orderBy('c.id_comentario','desc')
        ->get();
    }


    public static function deleteComment($id_comment){

        return DB::table('comentarios_ideas')->where('id_comentario', $id_comment)->delete();

    }

    public static function getPersonName($person_id){

       $query =  DB::table('users AS u')
        ->where('u.id',$person_id)
        ->select('u.nombre','u.id')
        ->get();

        foreach ($query as $key => $value) {
            return $value->nombre;
        }
    }
}
