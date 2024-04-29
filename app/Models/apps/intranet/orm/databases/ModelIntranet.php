<?php

namespace App\Models\apps\intranet\orm\databases;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelIntranet extends Model
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
