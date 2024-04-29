<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelSeguimientoVisita extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';

    protected $table = 'seguimiento_visita';

    protected $fillable = [
        'id',
        'comentario',
        'responsable',
        'id_st',
        'fecha_responsable'
    ];
}
