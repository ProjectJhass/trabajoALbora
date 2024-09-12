<?php

namespace App\Models\apps\cotizador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCotizaciones extends Model
{
    use HasFactory;

    protected $connection = 'pruebas_cotizador_oncredit';

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
