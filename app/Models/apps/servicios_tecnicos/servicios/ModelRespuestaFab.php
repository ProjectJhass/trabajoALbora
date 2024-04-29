<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelRespuestaFab extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';

    protected $table = 'respuesta_de_fabrica';

    protected $primaryKey = 'id_respuesta';

    protected $fillable = [
        'id_respuesta',
        'concepto',
        'diagnostico',
        'solucion',
        'estado',
        'responsable',
        'aprobacion',
        'id_st'
    ];
}
