<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoMueble extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'info_muebles';

    protected $primaryKey = 'id_mueble';

    protected $fillable = [
        'id_mueble',
        'mueble',
        'id_serie',
        'id_madera',
        'estado'
    ];
}
