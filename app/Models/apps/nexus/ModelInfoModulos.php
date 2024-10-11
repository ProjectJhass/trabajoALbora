<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoModulos extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'modulos_capacitacion';

    protected $primaryKey = 'id_modulo';

    protected $fillable = [
        'id_modulo',
        'nombre_modulo',
        'descripcion_modulo',
        'name_image',
        'estado'
    ];
}