<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelConsecutivosMadera extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'consecutivos_madera';

    protected $fillable = [
        'id',
        'ancho',
        'grueso',
        'largo',
        'pulgadas',
        'pulgadas_resta',
        'id_info_madera',
        'tipo_madera',
        'usuario_creacion',
        'usuario_actualizacion',
        'usuario_actualizacion_estado',
        'estado'
    ];
}
