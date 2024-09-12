<?php

namespace App\Models\apps\cotizador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoSucursales extends Model
{
    use HasFactory;

    protected $connection = 'pruebas_cotizador_oncredit';

    protected $table = 'sucursales';

    protected $primaryKey = 'id_sucursal';

    protected $fillable = [
        'co',
        'nombre_sucursal',
        'direccion',
        'telefonos',
        'email'
    ];
}
