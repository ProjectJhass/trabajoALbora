<?php

namespace App\Models\apps\automoviles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelKmRecorridos extends Model
{
    use HasFactory;


    protected $connection = 'automoviles';

    protected $table = 'km_recorridos';

    protected $primaryKey = 'id_km';

    protected $fillable = [
        'placa',
        'km_recorridos',
        'fecha'
    ];
}
