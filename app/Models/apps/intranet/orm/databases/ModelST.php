<?php

namespace App\Models\apps\intranet\orm\databases;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelST extends Model
{
    use HasFactory;

    protected $connection = 'db_st';

    protected $table = 'users';

    protected $fillable = [
        'id',
        'nombre',
        'almacen',
        'empresa',
        'rol',
        'usuario',
        'password'
    ];
}
