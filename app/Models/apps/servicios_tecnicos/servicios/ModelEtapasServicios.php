<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use Illuminate\Database\Eloquent\Model;

class ModelEtapasServicios extends Model
{
    protected $connection = 'servicios_tecnicos';

    protected $table = 'etapas_servicos';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'etapa',
        'dias',
        'estado',
        'created_at',
        'updated_at',
    ];
}
