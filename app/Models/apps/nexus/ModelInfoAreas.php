<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoAreas extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'areas';

    protected $primaryKey = 'id_dpto';

    protected $fillable = [
        'id_dpto',
        'nombre_dpto',
        'id_empresa'
    ];
}
