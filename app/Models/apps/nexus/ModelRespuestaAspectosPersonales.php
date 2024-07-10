<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelRespuestaAspectosPersonales extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'entrevista_asp_personal';

    protected $fillable = [
        'id',
        'aspecto',
        'respuesta',
        'seccion',
        'id_entrevista'
    ];
}
