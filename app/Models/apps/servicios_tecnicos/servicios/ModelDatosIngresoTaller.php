<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelDatosIngresoTaller extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';

    protected $table = 'ingreso_taller';

    protected $primaryKey = 'id_ingreso';

    protected $fillable = [
        'id_ingreso',
        'observaciones_ingreso',
        'responsable_ingreso',
        'fecha_ingreso',
        'observaciones_salida',
        'responsable_salida',
        'fecha_salida',
        'orden_taller',
        'estado',
        'id_st'
    ];
}
