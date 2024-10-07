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
        'seccion_empresa',//modificacion a la tabla de user agregando una seccion de empresa la cual ayudara identificar en que empresa esta el usuario
        'empresa',
        'rol',
        'ruta_foto',
        'rol_user',
        'permiso_madera',
        'inhabilitar'
    ];
}
