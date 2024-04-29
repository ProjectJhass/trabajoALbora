<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCausalidades extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';

    protected $table = 'causales_servicio';

    protected $fillable = [
        'id',
        'descripcion',
        'estado'
    ];
}
