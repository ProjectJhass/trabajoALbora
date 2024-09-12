<?php

namespace App\Models\apps\cotizador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelConsecutivoCotizacion extends Model
{
    use HasFactory;

    protected $connection = 'albura_cotizador';

    protected $table = 'consecutivo_cotizacion';

    protected $primaryKey = 'id_consecutivo';

    protected $fillable = [
        'consecutivo'
    ];
}
