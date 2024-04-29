<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelDominicales extends Model
{
    use HasFactory;
    public static function ObtenerAsesoresZona($zona)
    {
        return DB::table('users')
            ->select(['id', 'nombre', 'sucursal', 'zona'])
            ->where('zona', $zona)
            ->where('estado','1')
            ->orderBy('nombre')
            ->get();
    }

    public static function ObtenerEventos($zona)
    {
        return DB::table('eventos')
            ->where('zona', $zona)
            ->get();
    }

    public static function ObtenerColorEvento($id)
    {
        $color = 'rgb(10, 136, 138)';
        $query = DB::table('tipo_eventos')->where('id_evento', $id)->get('color');
        foreach ($query as $key => $value) {
            $color = $value->color;
        }
        return $color;
    }

    public static function BloquearEventos()
    {
        return DB::table('eventos')->where('fecha_i', '<=', date('Y-m-d'))->update((['bloqueado' => '1']));
    }

    public static function AgregarEventos($data)
    {
        return DB::table('eventos')->insert($data);
    }

    public static function ActualizarEvento($id_evento, $data)
    {
        return DB::table('eventos')->where('id_evento', $id_evento)->update($data);
    }

    public static function EliminarEvento($id_evento)
    {
        return DB::table('eventos')->where('id_evento', $id_evento)->delete();
    }

}
