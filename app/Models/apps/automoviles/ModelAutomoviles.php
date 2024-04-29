<?php

namespace App\Models\apps\automoviles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelAutomoviles extends Model
{
    use HasFactory;

    protected $connection = 'automoviles';

    protected $table = 'info_automoviles';

    protected $primaryKey = 'id_auto';

    protected $fillable = [
        'row_id',
        'placa',
        'modelo',
        'imagen',
        'soat',
        'ambiental',
        'riesgo'
    ];
}
