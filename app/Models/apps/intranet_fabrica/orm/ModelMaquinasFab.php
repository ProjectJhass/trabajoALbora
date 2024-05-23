<?php

namespace App\Models\apps\intranet_fabrica\orm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelMaquinasFab extends Model
{
    use HasFactory;

    protected $connection = 'db_fabrica';

    protected $table = 'herramientas_fabrica';

    protected $primaryKey = 'id_maquina';

    protected $fillable = [
        'id_maquina',
        'referencia',
        'nombre_maquina'
    ];
}
