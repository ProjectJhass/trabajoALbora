<?php

namespace App\Models\apps\cotizador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCotizacionesRealizadas extends Model
{
    use HasFactory;

    protected $connection = 'cotizador';

    protected $table = 'retomar_cotizacion';

    protected $primaryKey = 'id_retomar';

    protected $fillable = [
        'cedula',
        'nombre_1',
        'nombre_2',
        'apellido_1',
        'apellido_2',
        'direccion',
        'ciudad',
        'barrio',
        'celular_1',
        'celular_2',
        'email',
        'genero',
        'mascota',
        'fecha',
        'idsession',
        'vendedor',
        'almacen'
    ];
}
