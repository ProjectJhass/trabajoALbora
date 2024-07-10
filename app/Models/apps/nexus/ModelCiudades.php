<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCiudades extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'ciudades';

    protected $primaryKey = 'row_id';

    protected $fillable = [
        'row_id',
        'ciudad',
        'id_city',
        'id_depto',
        'id_pais'
    ];
}
