<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCortesPiezaFavor extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'cortes_pieza_a_favor';

    protected $primaryKey = 'id_pieza_favor';

    protected $fillable = [
        'id_pieza_favor',
        'id_pieza',
        'id_a_favor',
        'cantidad',
        'estado',
        'id_plan'
    ];
}
