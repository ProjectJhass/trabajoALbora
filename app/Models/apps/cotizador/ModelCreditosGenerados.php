<?php

namespace App\Models\apps\cotizador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCreditosGenerados extends Model
{
    use HasFactory;

    protected $connection = 'pruebas_cotizador_oncredit';

    protected $table = 'creditos_oncredit';

    protected $primaryKey = 'id_credito';

    protected $fillable = [
        'valores',
        'fecha_envio',
        'idcotizacion',
        'asesor'
    ];
}
