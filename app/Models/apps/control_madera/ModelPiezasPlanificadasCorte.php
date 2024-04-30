<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelPiezasPlanificadasCorte extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'piezas_planificadas';

    protected $fillable = [
        'id',
        'pieza',
        'largo',
        'ancho',
        'grueso',
        'cantidad',
        'l_bloque',
        'pulgadas_t',
        'troncos',
        'obs',
        'troncos_utilizados',
        'cantidad_cortada',
        'estado',
        'id_plan'
    ];
}
