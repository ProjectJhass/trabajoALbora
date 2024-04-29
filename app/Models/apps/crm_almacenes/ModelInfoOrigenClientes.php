<?php

namespace App\Models\apps\crm_almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoOrigenClientes extends Model
{
    use HasFactory;

    protected $connection = 'cotizador';

    protected $table = 'origen_estrategia';

    protected $primaryKey = 'id_origen';

    protected $fillable = [
        'origen'
    ];
}
