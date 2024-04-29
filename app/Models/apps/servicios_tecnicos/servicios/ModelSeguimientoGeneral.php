<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelSeguimientoGeneral extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';

    protected $table = 'seguimiento_general';

    protected $fillable = [
        'id',
        'comentario',
        'responsable',
        'id_st',
        'fecha_responsable'
    ];
}
