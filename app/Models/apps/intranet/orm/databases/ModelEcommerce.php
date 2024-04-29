<?php

namespace App\Models\apps\intranet\orm\databases;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelEcommerce extends Model
{
    use HasFactory;

    protected $connection = 'db_ecommerce';

    protected $table = 'asesor';

    protected $primaryKey = 'cedula_ase';

    protected $fillable = [
        'cedula_ase',
        'nombre_ase',
        'nombre2_ase',
        'apellido1_ase',
        'apellido2_ase',
        'nombrecargo',
        'usuario',
        'clave',
        'almacen',
        'cargo',
        'dependencia',
        'estado_ase',
        'rgb',
        'letra'
    ]; 
}
