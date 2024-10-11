<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoCargos extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'cargos';

    protected $primaryKey = 'id_cargo';

    protected $fillable = [
        'id_cargo',
        'nombre_cargo',
        'id_departamento',
        'descripcion_cargo',
        'name_image',
    ];
}
