<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelUsersIntranet extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'id',
        'codigo',
        'nombre',
        'email',
        'permisos',
        'dpto_user',
        'bitacora',
        'sucursal',
        'cargo',
        'usuario',
        'password',
        'zona',
        'ingreso_personal',
        'calendario',
        'estado',
        'almacen',
        'empresa',
        'rol',
        'ruta_foto',
        'rol_user',
        'permiso_madera',
        'inhabilitar'
    ];
}
