<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class infoAlmacenes extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';

    protected $table = 'info_almacenes';

    protected $primaryKey = 'id_co';

    protected $fillable = [
        'id_co',
        'numero',
        'almacen',
        'estado'
    ];
}
