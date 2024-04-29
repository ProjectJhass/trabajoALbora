<?php

namespace App\Models\apps\automoviles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelPolizas extends Model
{
    use HasFactory;

    protected $connection = 'automoviles';

    protected $table = 'historial_polizas';

    protected $primaryKey = 'id_historial';

    protected $fillable = [
        'id_placa',
        'placa',
        'poliza',
        'nombre_pdf',
        'pdf',
        'tipo',
        'url',
        'fecha'
    ];
}
