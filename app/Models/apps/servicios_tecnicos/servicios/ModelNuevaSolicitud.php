<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelNuevaSolicitud extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';

    protected $table = 'servicios_tecnicos';

    protected $primaryKey = 'id_st';

    protected $fillable = [
        'id_st',
        'proveedor',
        'ced_asesor',
        'asesor',
        'almacen',
        'tipo_servicio',
        'cedula',
        'nombre',
        'celular',
        'email',
        'direccion',
        'barrio',
        'ciudad',
        'forma_pago',
        'cantidad',
        'id_item',
        'articulo',
        'ext1',
        'ext2',
        'factura',
        'fecha_factura',
        'remision',
        'fecha_remision',
        'inconveniente',
        'causales',
        'otro_causal',
        'respuesta_st',
        'proceso',
        'estado'
    ];
}
