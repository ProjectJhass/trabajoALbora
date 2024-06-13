<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCodigosSiesa extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'codigos_siesa';

    protected $fillable = [
        'id',
        'nombre',
        'codigo',
        'estado'
    ];
}
