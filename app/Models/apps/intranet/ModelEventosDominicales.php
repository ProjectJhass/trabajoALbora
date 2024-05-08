<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelEventosDominicales extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    protected $primaryKey='id_evento';

    protected $fillable = [
        'id_evento',
        'cedula_evento',
        'nombre_evento',
        'fecha_i',
        'fecha_f',
        'allDay',
        'url',
        'color',
        'border_color',
        'tipo_evento',
        'zona',
        'observaciones',
        'cedula_reemplaza',
        'nombre_reemplaza',
        'firmar',
        'bloqueado'        
    ]; 
}
