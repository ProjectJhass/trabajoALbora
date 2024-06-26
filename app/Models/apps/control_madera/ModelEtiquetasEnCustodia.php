<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelEtiquetasEnCustodia extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'etiquetas_custodia';

    protected $fillable = [
        'id',
        'id_consecutivo',
        'id_impresion',
        'id_nueva_imp',
        'usuario_registro',
        'usuario_a_cargo',
        'estado'
    ];
}
