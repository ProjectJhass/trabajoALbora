<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoPreguntasEvaluacion extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'preguntas_evaluacion';

    protected $primaryKey = 'id_pregunta';

    protected $fillable = [
        'id_pregunta',
        'pregunta_ev',
        'tipo_respuesta',
        'respuesta1',
        'respuesta2',
        'respuesta3',
        'respuesta4',
        'imagen',
        'url_img',
        'respuesta_correcta',
        'id_evaluacion'
    ];
}
