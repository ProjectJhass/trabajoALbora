<?php

namespace App\Models\apps\intranet\Bitacora;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelBitacora extends Model
{
    use HasFactory;

    protected $table = 'bitacora_solicitudes';

    protected $primaryKey = 'id_solicitud';

    protected $fillable = [
        'tipo_solicitud',
        'nombre_solicitud',
        'descripcion',
        'fecha_creacion',
        'fecha_posible_entrega',
        'fecha_terminado',
        'estado',
        'porcentaje',
        'color',
        'id_solicitante',
        'nombre_solicitante',
        'prioridad',
        'categoria',
        'organizacion'
    ];
}
