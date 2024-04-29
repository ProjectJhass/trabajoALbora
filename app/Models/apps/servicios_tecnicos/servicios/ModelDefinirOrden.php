<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelDefinirOrden extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';

    protected $table = 'definir_ost';

    protected $fillable = [
        'id',
        'observaciones',
        'responsable',
        'nom_doc',
        'documento',
        'tipo',
        'tama',
        'url',
        'id_st'
    ];
}
