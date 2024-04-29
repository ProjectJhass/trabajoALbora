<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelConductores extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';

    protected $table = 'conductores';

    protected $fillable = [
        'id',
        'nombre',
        'celular',
        'estado'
    ];
}
