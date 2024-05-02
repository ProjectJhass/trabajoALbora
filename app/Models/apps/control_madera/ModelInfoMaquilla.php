<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoMaquilla extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'codigo_design';

    protected $fillable = [
        'id',
        'marquilla',
        'estado'
    ];
}
