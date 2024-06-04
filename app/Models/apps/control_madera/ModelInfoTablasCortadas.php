<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoTablasCortadas extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'tablas_cortes_series';

    protected $primaryKey = 'id_tabla';

    protected $fillable = [
        'id_tabla',
        'cantidad_tabla',
        'ancho_tabla',
        'id_corte',
        'usuario_registro'
    ];
}
