<?php

namespace App\Models\apps\intranet_fabrica\orm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelSolicitudesPQRS extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $connection = 'pqrs_fabrica';

    protected $table = 'solicitudes';

    protected $fillable = [
        'fecha',
        'hora',
        'nombres',
        'apellidos',
        'cargo',
        'email',
        'tipo_solicitud',
        'lugar',
        'descripcion',
        'estado',
    ];

    public function infoAnexos(){
        return $this->hasMany(ModelAnexosPQRS::class, 'consecutivo', 'id');
    }

    public function infoRespuestas(){
        return $this->hasMany(ModelRespuestaPQRS::class, 'consecutivo', 'id');
    }
}
