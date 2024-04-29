<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelUsuariosIntranet extends Model
{
    use HasFactory;

    public static function ObtenerDepartamentos()
    {
        return DB::table('departamentos')->get();
    }

    public static function ObtenerInfoUsuario($cedula)
    {
        $data = array();
        $query =  DB::table('users')
            ->select(['sucursal', 'usuario', 'estado'])
            ->where('id', $cedula)
            ->get();
        foreach ($query as $key => $value) {
            array_push($data, (['sucursal' => $value->sucursal, 'usuario' => $value->usuario, 'estado' => $value->estado]));
        }
        return count($data) > 0 ? $data : array(['sucursal' => '', 'usuario' => '', 'estado' => '']);
    }
}
