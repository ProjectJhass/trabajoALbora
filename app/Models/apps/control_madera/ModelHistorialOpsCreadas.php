<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHistorialOpsCreadas extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'historial_ops_creadas';

    protected $fillable = [
        'id',
        'tipo_corte',
        'id_corte',
        'nombre',
        'pulgadas',
        'tipo_doc',
        'codigo_item',
        'planificador',
        'consecutivo_op'
    ];
}
