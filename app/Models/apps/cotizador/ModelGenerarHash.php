<?php

namespace App\Models\apps\cotizador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelGenerarHash extends Model
{
    use HasFactory;

    public static function make()
    {
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $key = substr(str_shuffle($pattern), 0, 16);
        return $key;
    }
}
