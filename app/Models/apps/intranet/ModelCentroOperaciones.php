<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCentroOperaciones extends Model
{
    use HasFactory;

    protected $table = 'centro_operaciones';

    protected $fillable = [
        'centro_operacion'
    ];
}
