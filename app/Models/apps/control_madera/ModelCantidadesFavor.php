<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCantidadesFavor extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'piezas_a_favor';

    protected $fillable = [
        'id',
        'id_pieza',
        'nom_pieza',
        'cantidad',
        'estado'
    ];
}
