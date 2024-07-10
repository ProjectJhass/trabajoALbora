<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHistorialUsuarioManual extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'usuario_cargos';

    protected $primaryKey = 'id_registro';

    protected $fillable = [
        'id_registro',
        'id_area',
        'id_cargo',
        'id_manual_funciones',
        'id_usuario',
        'estado'
    ];
}
