<?php

namespace App\Models\apps\crm_almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHistorialCambios extends Model
{
    use HasFactory;

    protected $connection = 'albura_cotizador';

    protected $table = 'log_info_crm';

    protected $primaryKey = 'id_log';

    protected $fillable = [
        'log_evento',
        'log_id_registro',
        'log_accion',
        'log_id_usuario',
        'log_nombre_usuario',
        'log_sucursal'
    ];

}
