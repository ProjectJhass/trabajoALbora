<?php

namespace App\Models\apps\cotizador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelModificacionPlan extends Model
{
    use HasFactory;

    protected $connection = 'pruebas_cotizador_oncredit';

    protected $table = 'tasas_descuentos';

    protected $primaryKey = 'id_tasa';

    protected $fillable = [
        'id_tasa',
        'plan',
        'valor_tasa',
        'descuento',
        'fecha_finalizacion'
    ];
}
