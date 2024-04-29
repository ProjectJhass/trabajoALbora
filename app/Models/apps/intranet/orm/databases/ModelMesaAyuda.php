<?php

namespace App\Models\apps\intranet\orm\databases;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelMesaAyuda extends Model
{
    use HasFactory;

    protected $connection = 'db_mesa_ayuda';

    protected $table = 'usuario';

    protected $primaryKey = 'cedula';

    protected $fillable = [
        'id_usuario',
        'cedula',
        'correo',
        'nombre_completo',
        'tipo_usuario',
        'usuario',
        'contraseña',
        'contraseña_provicional',
        'cargo',
        'procesos',
        'registro_casos',
        'estado_usuario',
        'sonido_notificacion'
    ]; 
}
