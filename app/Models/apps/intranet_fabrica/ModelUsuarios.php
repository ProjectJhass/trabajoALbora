<?php

namespace App\Models\apps\intranet_fabrica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelUsuarios extends Model
{
    use HasFactory;

    public static function ObtenerTodosLosUsuarios()
    {
        return DB::connection('db_fabrica')->table('users')->select(['id', 'nombre', 'email', 'usuario', 'rol_user'])->get();
    }

    public static function GuardarInformacionNuevoUsuario($data)
    {
        return DB::connection('db_fabrica')->table('users')->insert($data);
    }

    public static function EliminarUsuarioRegistradoFab($id_usuario)
    {
        return DB::connection('db_fabrica')->table('users')->where('id', '=', $id_usuario)->delete();
    }

    public static function getInfoUser($id_usuario){

        return DB::connection('db_fabrica')->table('users')->where('id', '=', $id_usuario)->get();
    }

    public static function getNameUser($id_usuario){

        return DB::connection('db_fabrica')->table('users')
        ->where('id', '=', $id_usuario)
        ->get('nombre');
    }

}
