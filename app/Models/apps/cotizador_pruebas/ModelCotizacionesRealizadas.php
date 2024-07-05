<?php

namespace App\Models\apps\cotizador_pruebas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCotizacionesRealizadas extends Model
{
    use HasFactory;

    protected $connection = 'albura_cotizador';

    protected $table = 'cotizaciones';

    protected $primaryKey = 'id_cotizacion';

    protected $fillable = [
        'idsession',
        'sku',
        'producto',
        'vlr_contado',
        'cantidad',
        'vlr_credito',
        'dsto_adicional',
        'plan',
        'descuento',
        'cuotas',
        'asesor',
        'fecha',
        'sucursal'
    ];
}
