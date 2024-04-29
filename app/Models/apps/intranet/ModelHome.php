<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelHome extends Model
{
    use HasFactory;

    public static function FraseDelDia($id)
    {
        $query = DB::table('frases_filosofos')->where('id_frase', $id)->get('maxima');
        foreach ($query as $key => $value) {
            return $value->maxima;
        }
        return '';
    }

    public static function ImagenesCarrucel()
    {
        return DB::table('imagenes_carrucel')->orderBy('orden')->get();
    }

    public static function NumerosContacto()
    {
        return DB::table('numeros_de_contacto')->get();
    }

    public static function AgregarNuevosNumeros($data)
    {
        return DB::table('numeros_de_contacto')->insert($data);
    }

    public static function AgregarDocumentosCarrusel($data)
    {
        return DB::table('imagenes_carrucel')->insert($data);
    }

    public static function EliminarValorNumeroContacto($id)
    {
        return DB::table('numeros_de_contacto')->where('id_numero', $id)->delete();
    }
    public static function EliminarImagenCarrucel($id)
    {
        return DB::table('imagenes_carrucel')->where('id_carrucel', $id)->delete();
    }

    public static function ActualizarCarrucel($id, $data)
    {
        return DB::table('imagenes_carrucel')->where('id_carrucel', $id)->update($data);
    }
}
