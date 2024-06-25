<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelLogs extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'logs_madera';

    protected $fillable = [
        'id',
        'accion',
        'usuario'
    ];
}
