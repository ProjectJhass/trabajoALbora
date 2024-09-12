<?php

namespace App\Models\apps\crm_almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelComentariosClientesCrm extends Model
{
    use HasFactory;

    protected $connection = 'albura_cotizador';

    protected $table = 'comentarios_seg';

    protected $primaryKey = 'id_comentario';

    protected $fillable = [
        'comentario',
        'fecha',
        'asesor',
        'id_llamada',
        'id_cliente',
    ];
}
