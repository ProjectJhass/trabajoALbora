<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInformacionFamilia extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'entrevista_familia';

    protected $fillable = [
        'id',
        'nombre',
        'parentesco',
        'edad',
        'ocupacion',
        'id_entrevista'
    ];
}
