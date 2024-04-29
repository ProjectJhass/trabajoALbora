<?php

namespace App\Models\apps\intranet\orm\databases;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelTareas extends Model
{
    use HasFactory;

    protected $connection = 'db_tareas';

    protected $table = 'users';

    protected $primaryKey = 'cedula';

    protected $fillable = [
        'id',
        'cedula',
        'name',
        'email',
        'usuario',
        'password'
    ];
}
