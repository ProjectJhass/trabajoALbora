<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelPiezasMaderaFavor extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'cortes_piezas_wood';

    protected $fillable = [
        'id',
        'largo',
        'ancho',
        'grueso',
        'cantidad_inicial',
        'cantidad_disponible',
        'id_madera',
        'madera',
        'id_corte',
        'estado'
    ];
}
