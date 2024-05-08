<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelFirmasDescansosCompensatorios extends Model
{
    use HasFactory;

    protected $table = 'firmas_descansos';

    protected $fillable = [
        'id',
        'nombre',
        'cedula',
        'ciudad',
        'depto',
        'almacen',
        'dominical_laborado',
        'dia_compensatorio',
        'nombre_firma',
        'url_firma',
        'tipo_firma',
        'ip_firma',
        'hash_firma',
        'observaciones'
    ];
}
