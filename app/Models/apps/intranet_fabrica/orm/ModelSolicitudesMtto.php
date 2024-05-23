<?php

namespace App\Models\apps\intranet_fabrica\orm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelSolicitudesMtto extends Model
{
    use HasFactory;

    protected $connection = 'db_fabrica';

    protected $table = 'solicitudes_mtto';

    protected $primaryKey = 'id_solicitud';

    protected $fillable = [
        'id_solicitud',
        'solicitud',
        'seccion',
        'maquina',
        'responsable_s',
        'fecha_solicitud',
        'respuesta_solicitud',
        'responsable_respuesta',
        'fecha_respuesta',
        'responsable_recibe',
        'fecha_recibe',
        'estado_solicitud'
    ];
}
