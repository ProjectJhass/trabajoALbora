<?php

namespace App\Models\apps\intranet_fabrica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelUsuariosEncuesta extends Model
{
    use HasFactory;

    public static function ObtenerTodosLosUsuariosEncuesta()
    {
        return DB::connection('db_fabrica')->table('usuarios_encuesta')->get();
    }

    public static function AgregarNuevoRegistroEncuesta($data)
    {
        return DB::connection('db_fabrica')->table('usuarios_encuesta')->insert($data);
    }

    public static function EliminarRegistroUserEncuesta($id_usuario)
    {
        return DB::connection('db_fabrica')->table('usuarios_encuesta')->where('id_usuario_e', '=', $id_usuario)->delete();
    }
}
