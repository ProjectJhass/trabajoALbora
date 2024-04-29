<?php

namespace App\Models\apps\crm_almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoLlamadasPendientes extends Model
{
    use HasFactory;

    protected $connection = 'cotizador';

    protected $table = 'llamadas_a_realizar';

    protected $primaryKey = 'id_llamada';

    protected $fillable = [
        'fecha_a_llamar',
        'estado',
        'id_cliente'
    ];
}
