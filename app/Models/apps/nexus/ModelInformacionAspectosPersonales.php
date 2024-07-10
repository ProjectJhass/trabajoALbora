<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInformacionAspectosPersonales extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'aspectos_personales';

    protected $primaryKey = 'id_aspecto';

    protected $fillable = [
        'id_aspecto',
        'aspecto',
        'estado'
    ];
}
