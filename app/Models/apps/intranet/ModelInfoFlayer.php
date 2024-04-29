<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoFlayer extends Model
{
    use HasFactory;

    protected $table = 'visualizacion_flayer';


    protected $primaryKey = 'id';


    protected $fillable = [
        'cedula',
        'nombre',
        'fecha',
        'id_estado',
        'estado'
    ];
}
