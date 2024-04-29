<?php

namespace App\Models\apps\crm_almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelVentasEfectivasCrm extends Model
{
    use HasFactory;

    protected $connection = 'cotizador';

    protected $table = 'ventas_efectivas';

    protected $primaryKey = 'id_efectivo';

    protected $fillable = [
        'recibo_caja',
        'numero_pedido',
        'numero_factura',
        'medio_de_pago',
        'almacen_pago',
        'forma_pago',
        'valor_flete',
        'fecha_compra',
        'estado',
        'id_cliente'
    ];
}
