<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Modelidea extends Model
{
    use HasFactory;

    public static function getIdeas()
    {
        return DB::table('ideas_fabrica as i')
        ->where("categoria","salas")
        ->orderBy("i.fecha_cargue", "DESC")
        ->get();
    }

    public static function getCountComments($id)
    {
        return DB::table('comentarios_ideas')->where('id_ideas', $id)->count();
    }

    public static function searcher($consulta,$section)
    {

        return DB::table('ideas_fabrica')
            ->where("nombre_documento", "LIKE", "%$consulta%")
            ->where("categoria","LIKE","%$section%")
            ->get();

    }


    public static function enviarDatos()
    {

        return DB::table('ideas_fabrica')->get();
    }


    public static function getUsers()
    {
        return DB::table('users')->get();
    }


    public static function enviarComentarios()
    {

        $nombre = Auth::user()->nombre;
    }

    public static function deleteIdea($id)
    {
        return DB::table('ideas_fabrica')->where('id_idea', $id)->delete();
    }


    public static function insertIdea($dato)
    {
        return DB::table('ideas_fabrica')->insert($dato);
    }

    public static function getIdeasSection($section){

        return DB::table('ideas_fabrica as i')
        ->where("categoria",$section)
        ->orderBy("i.fecha_cargue", "DESC")
        ->get();

    }


    public static function updateIdea($id_idea,$section){


        return DB::table('ideas_fabrica as i')
        ->where("id_idea",$id_idea)
        ->update(["categoria" => $section]);

    }

    public static function deleteImg($id_idea){


        return DB::table('ideas_fabrica as i')
        ->where("id_idea",$id_idea)
        ->update(["url_doc" => "/storage/img/sin_fondo.jpg", "tipo_doc" => "jpg"]);

    }


    public static function getPath($id_idea){

        return DB::table('ideas_fabrica as i')
        ->where("id_idea",$id_idea)
        ->get("url_doc");
    }


    public static function updateImage($data,$id_idea){


        return DB::table('ideas_fabrica as i')
        ->where("id_idea",$id_idea)
        ->update($data);


    }

    public static function deleteLink($id_idea){

        return DB::table('ideas_fabrica as i')
        ->where("id_idea",$id_idea)
        ->update([ "link" => null]);

    }

    public static function editLink($id_idea,$link){

        return DB::table('ideas_fabrica as i')
        ->where("id_idea",$id_idea)
        ->update(["link" => $link]);

    }
}
