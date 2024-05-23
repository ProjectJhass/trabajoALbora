<?php

namespace App\Models\apps\intranet_fabrica\orm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHvMaquinas extends Model
{
    use HasFactory;

    protected $connection = 'db_fabrica';

    protected $table = 'maquinas_hojas_de_vida';

    protected $primaryKey = 'id_maquina';

    protected $fillable = [
        'id_maquina',
        'referencia',
        'nombre_maquina',
        'estado',
        'imagen'
    ];
}
