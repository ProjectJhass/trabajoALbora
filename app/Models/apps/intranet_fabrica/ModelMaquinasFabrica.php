<?php

namespace App\Models\apps\intranet_fabrica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelMaquinasFabrica extends Model
{
    use HasFactory;

    public static function ObtenerTodasLasHerramientas()
    {
        return DB::connection('db_fabrica')->table('herramientas_fabrica')->orderBy('nombre_maquina')->get();
    }

    public static function CrearNuevaMaquinaFab($data)
    {
        return DB::connection('db_fabrica')->table('herramientas_fabrica')->insert($data);
    }

    public static function EliminarMaquinaFabrica($id_maquina)
    {
        return DB::connection('db_fabrica')->table('herramientas_fabrica')->where('id_maquina', '=', $id_maquina)->delete();
    }
}
