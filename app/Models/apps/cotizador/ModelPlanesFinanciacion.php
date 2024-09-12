<?php

namespace App\Models\apps\cotizador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelPlanesFinanciacion extends Model
{
    use HasFactory;

    protected $connection = 'pruebas_cotizador_oncredit';

    protected $table = 'tasas_financiacion';

    protected $primaryKey = 'id_tasa';

    protected $fillable = [
        'plan',
        'valor_tasa'
    ];
}
