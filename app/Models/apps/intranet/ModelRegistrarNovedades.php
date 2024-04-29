<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelRegistrarNovedades extends Model
{
    use HasFactory;

    public static function ConsultarSucursalUsuario($id)
    {
        return DB::table('users')->where('id', $id)->get('sucursal');
    }

    public static function AgregarNovedades($data)
    {
        return DB::table('novedades')->insert($data);
    }
}
