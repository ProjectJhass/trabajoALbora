<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelValoracionFab extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';

    protected $table = 'valoracion_fabrica';

    protected $primaryKey = 'id_valoracion';

    protected $fillable = [
        'id_valoracion',
        'concepto',
        'observaciones',
        'responsable',
        'estado',
        'id_st'
    ];
}
