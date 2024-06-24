<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use Illuminate\Database\Eloquent\Model;

class ModelHistorialSeguimiento extends Model
{
    protected $connection = 'servicios_tecnicos';
    protected $table = 'historial_seguimiento';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'id_st',
        'id_proceso',
        'fecha_inicial',
        'fecha_final',
        'created_at',
        'updated_at'
    ];
}
?>
