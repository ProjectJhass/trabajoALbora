<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoMadera extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'info_tipo_madera';

    protected $primaryKey = 'id_madera';

    protected $fillable = [
        'id_madera',
        'nombre_madera',
        'estado'
    ];
}
