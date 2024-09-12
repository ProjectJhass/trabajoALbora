<?php

namespace App\Models\apps\crm_almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCumpleClientesCRM extends Model
{
    use HasFactory;

    protected $connection = 'albura_cotizador';

    protected $table = 'cumple_enviados_cliente';

    protected $primaryKey = 'id_cumple_enviado';

    protected $fillable = [
        'id_cliente',
        'id_asesor',
        'cell_enviado',
        'text_enviado',
        'img_url',
    ];
}
