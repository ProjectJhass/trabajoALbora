<?php

namespace App\Models\apps\servicios_tecnicos\pagina_web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelWeb extends Model
{
    use HasFactory;

    public static function insertOst($data){
        $id = DB::table('crear_ost_web')->insertGetId( $data);
        return $id;

    }


    public static function insertEvidence($data){


       return  DB::table('evidencias_web')
         ->insert($data);
    }


    public static function getEvidences($id){

        return DB::table('evidencias_web AS e')
        ->where('e.id_ost_FK' ,$id)
        ->get();
    }


    public static function deleteOST($id){

        return DB::table('crear_ost_web AS c')
        ->where('c.id_evidencia' ,$id)
        ->delete();

    }


    public static function ultimoRegistro(){
        return DB::table('crear_ost_web')->orderByDesc('id_ost')->limit(1)->get('n_ticket');

    }
}
