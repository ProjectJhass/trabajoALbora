<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoClientesDigitalizacion extends Model
{
    use HasFactory;

    protected $connection = 'cartera';

    protected $table = 'informacion_clientes';

    protected $primaryKey = 'id_info';

    protected $fillable = [
        'id_info',
        'cedula_cliente',
        'nombre_cliente',
        'cuenta_cliente',
        'almacen_cliente',
        'observaciones',
    ];
}
