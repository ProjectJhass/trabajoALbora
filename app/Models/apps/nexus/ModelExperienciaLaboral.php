<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelExperienciaLaboral extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'entrevista_exp_lab';

    protected $primaryKey = 'id_exp';

    protected $fillable = [
        'id_exp',
        'empresa',
        'cargo',
        'periodo',
        'funciones',
        'retiro',
        'id_entrevista'
    ];
}
