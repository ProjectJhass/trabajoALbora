<?php

namespace App\Models\apps\cotizador_pruebas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoLlamadasPendientes extends Model
{
    use HasFactory;

    protected $connection = 'albura_cotizador';

    protected $table = 'llamadas_a_realizar';

    protected $primaryKey = 'id_llamada';

    protected $fillable = [
        'fecha_a_llamar',
        'estado',
        'id_cliente'
    ];
}
