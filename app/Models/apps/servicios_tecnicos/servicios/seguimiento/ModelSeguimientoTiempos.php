<?php

namespace App\Models\apps\servicios_tecnicos\servicios\seguimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelSeguimientoTiempos extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';

    protected $table = 'historial_seguimiento';

    protected $fillable = [
        'id',
        'id_st',
        'id_proceso',
        'fecha_inicial',
        'fecha_final'
    ];
}
