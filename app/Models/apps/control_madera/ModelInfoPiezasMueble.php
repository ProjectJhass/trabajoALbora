<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoPiezasMueble extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'medidas_piezas';

    protected $fillable = [
        'id',
        'id_mueble',
        'id_serie',
        'id_madera',
        'pieza',
        'cantidad_pieza',
        'largo',
        'ancho',
        'grueso',
        'estado'
    ];
}
