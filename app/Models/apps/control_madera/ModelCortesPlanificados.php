<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCortesPlanificados extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'cortes_planificados';

    protected $fillable = [
        'id',
        'serie',
        'madera',
        'mueble',
        'cantidad',
        'pulgadas_solicitadas',
        'pulgadas_cortadas',
        'op_creada_p1',
        'consecutivo_op_p1',
        'creacion_op_p1',
        'pulgadas_no_utilizadas',
        'op_creada_p2',
        'consecutivo_op_p2',
        'creacion_op_p2',
        'planificador',
        'estado'
    ];
}
