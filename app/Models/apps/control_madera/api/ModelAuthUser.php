<?php

namespace App\Models\apps\control_madera\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelAuthUser extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'id',
        'nombre',
        'email',
        'permisos',
        'dpto_user',
        'permiso_dpto',
        'bitacora',
        'sucursal',
        'cargo',
        'usuario',
        'password',
        'zona',
        'ingreso_personal',
        'calendario',
        'estado'
    ];
}
