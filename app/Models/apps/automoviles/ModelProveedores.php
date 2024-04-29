<?php

namespace App\Models\apps\automoviles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelProveedores extends Model
{
    use HasFactory;

    protected $connection = 'automoviles';

    protected $table = 'info_proveedores';

    protected $fillable = [
        'nit',
        'razon_social',
        'establecimiento',
        'ciudad',
        'direccion',
        'barrio',
        'celular',
        'servicio'
    ];
}
