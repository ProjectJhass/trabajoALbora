<?php

namespace App\Models\apps\cotizador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCiudadesCot extends Model
{
    use HasFactory;

    protected $connection = 'cotizador';

    protected $table = 'ciudades_id';

    protected $primaryKey = 'row_id';

    protected $fillable = [
        'ciudad',
        'id_city',
        'id_depto',
        'id_pais'
    ];
}
