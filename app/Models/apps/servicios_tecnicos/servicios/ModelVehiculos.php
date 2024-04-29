<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelVehiculos extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';

    protected $table = 'vehiculos';

    protected $fillable = [
        'id',
        'placa',
        'modelo',
        'estado'
    ];
}
