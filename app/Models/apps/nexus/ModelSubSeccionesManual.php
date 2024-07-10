<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelSubSeccionesManual extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'sub_seccion_manual';

    protected $primaryKey = 'id_seccion_m';

    protected $fillable = [
        'id_seccion_m',
        'seccion_m',
        'id_seccion_padre'
    ];
}
