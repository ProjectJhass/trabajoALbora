<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelFuncionesGeneralesManual extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'funciones_generales';

    protected $primaryKey = 'id_funcion';

    protected $fillable = [
        'id_funcion',
        'descripcion',
        'relevancia',
        'frecuencia',
        'id_manual',
        'id_seccion',
        'id_subseccion'
    ];
}
