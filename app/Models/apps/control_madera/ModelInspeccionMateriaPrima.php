<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInspeccionMateriaPrima extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'inspeccion_materia_prima';

    protected $fillable = [
        'id',
        'id_madera',
        'madera',
        'tipo_vehiculo',
        'placa',
        'conducto',
        'subproceso',
        'total_bloques',
        'total_pulgadas',
        'menor_tres_m',
        'usuario_creacion'
    ];
}
