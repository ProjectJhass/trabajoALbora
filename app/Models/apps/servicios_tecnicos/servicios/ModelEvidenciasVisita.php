<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelEvidenciasVisita extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';

    protected $table = 'evidencias_visita';

    protected $fillable = [
        'id',
        'nombre_img',
        'tipo',
        'tama',
        'url',
        'tabla',
        'id_comentario',
        'id_st'
    ];
}
