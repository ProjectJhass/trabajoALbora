<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoPrinter extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'config_impresora';

    protected $fillable = [
        'id',
        'nombre',
        'ip',
        'puerto',
        'conexion',
        'impresora',
        'estado'
    ];
}
