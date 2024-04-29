<?php

namespace App\Models\apps\servicios_tecnicos\servicios\users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelUsuarios extends Model
{
    use HasFactory;

    protected $connection = 'mysql_intranet';

    protected $table = 'users';

    protected $fillable = [
        'id',
        'nombre',
        'sucursal',
        'usuario',
        'password'
    ];
}
