<?php

namespace App\Models\apps\cotizador_pruebas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelClientesCreditoCrexit extends Model
{
    use HasFactory;

    protected $connection = 'albura_cotizador';

    protected $table = 'clientes_credito_crexit';

    protected $primaryKey = 'id_credito';

    protected $fillable = [
        'id_cotizacion',
        'cedula_cliente',
        'valor_a_financiar',
        'valor_inicial',
        'items'
    ];
}
