<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelUsuarios extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'usuarios';

    protected $fillable = [
        'id',
        'tipo_doc',
        'documento',
        'nombre',
        'apellidos',
        'celular',
        'celular2',
        'email',
        'fecha_nacimiento',
        'fecha_ingreso',
        'id_dpto',
        'dpto',
        'id_ciudad',
        'ciudad',
        'barrio',
        'direccion',
        'usuario',
        'pwd',
        'pwd_cambio',
        'nombre_foto',
        'url',
        'tipo',
        'tama',
        'area',
        'cargo',
        'rol',
        'zona',
        'permisos',
        'estado'
        
    ];



}
