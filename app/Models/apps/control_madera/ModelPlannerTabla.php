<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelPlannerTabla extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'cortes_tablas';

    protected $fillable = [
        'id',
        'nombre_corte',
        'cantidad',
        'medida_grosor',
        'pulgadas_solicitadas',
        'planificador',
        'cantidad_cortada',
        'pulgadas_cortadas',
        'bloques_utilizados',
        'cortador',
        'op_creada',
        'consecutivo_op',
        'usuario_creacion_op',
        'estado'
    ];
}
