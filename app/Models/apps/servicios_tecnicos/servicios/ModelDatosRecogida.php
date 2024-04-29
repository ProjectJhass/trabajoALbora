<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelDatosRecogida extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';

    protected $table = 'datos_recogida_st';

    protected $primaryKey = 'id_recogida';

    protected $fillable = [
        'id_valoracion',
        'elementos_recogidos',
        'observaciones_r',
        'responsable',
        'fecha_responsable',
        'id_st'
    ];
}
