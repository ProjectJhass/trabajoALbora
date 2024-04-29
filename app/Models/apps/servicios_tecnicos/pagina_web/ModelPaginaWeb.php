<?php

namespace App\Models\apps\servicios_tecnicos\pagina_web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelPaginaWeb extends Model
{
    use HasFactory;
    
    protected $connection = 'servicios_tecnicos';
    
    protected $table = 'crear_ost_web';

    protected $primaryKey = 'id_ost';

    protected $fillable = [
        'n_ticket',
        'cedula_cliente',
        'nombre',
        'telefono',
        'email',
        'articulo',
        'descripcion_servicio',
        'almacen',
        'fecha',
        'estado',
        'num_ost'
    ];
}
