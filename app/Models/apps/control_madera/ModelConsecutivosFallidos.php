<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelConsecutivosFallidos extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'consecutivos_fallidos';

    protected $fillable = [
        'id',
        'consecutivo',
        'id_impresion',
        'tipo_madera',
        'estado'
    ];
}
