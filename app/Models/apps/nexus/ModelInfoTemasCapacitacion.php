<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoTemasCapacitacion extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'temas_capacitacion';

    protected $primaryKey = 'id_tema';

    protected $fillable = [
        'id_tema',
        'nombre_tema',
        'objetivo_tema',
        'documento_tema',
        'url_tema',
        'estado',
    ];


    public function evaluacionesCreadas()
    {

        return $this->hasMany(ModelInfoEvaluaciones::class, 'id_tema_capacitacion', 'id_tema');
    }

    public function infoEncargadoTema()
    {
        return $this->hasMany(ModelUsuarios::class, 'id', 'encargado');
    }
}
