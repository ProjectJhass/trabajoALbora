<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoEvaluaciones extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'evaluaciones_temas';

    protected $primaryKey = 'id_evaluacion';

    protected $fillable = [
        'id_evaluacion',
        'nombre_evaluacion',
        'id_tema_capacitacion',
        'estado'
    ];

    public function getPreguntasEvaluacion()
    {
        return $this->hasMany(ModelInfoPreguntasEvaluacion::class, 'id_evaluacion', 'id_evaluacion');
    }
}
