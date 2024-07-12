<?php

namespace App\Models\apps\crm_almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelClientesCRM extends Model
{
    use HasFactory;

    protected $connection = 'cotizador';

    protected $table = 'clientes_crm';

    protected $primaryKey = 'id_cliente';

    protected $fillable = [
        'cedula_cliente',
        'nombre_1',
        'nombre_2',
        'apellido_1',
        'apellido_2',
        'direccion',
        'ciudad',
        'id_ciudad',
        'id_depto',
        'id_pais',
        'barrio',
        'celular_1',
        'celular_2',
        'email',
        'fecha_cumple',
        'genero',
        'categoria',
        'fecha_registro',
        'prioridad',
        'origen',
        'tipo_cliente',
        'cedula_asesor',
        'id_cotizacion',
        'estado'
    ];

    public function llamadasPendientes()
    {
        return $this->hasMany(ModelInfoLlamadasPendientes::class, 'id_cliente')->where('estado', 'PENDIENTE');
    }
    public function llamadasRealizadas()
    {
        return $this->hasMany(ModelInfoLlamadasPendientes::class, 'id_cliente')->where('estado', 'REALIZADA');
    }

    public function itemsCotizados()
    {
        return $this->hasMany(ModelItemsCotizadosCrm::class, 'idsession', 'id_cotizacion');
    }

    public function ventasEfectivas()
    {
        return $this->hasMany(ModelVentasEfectivasCrm::class, 'id_cliente');
    }

    public function asesoresCRM()
    {
        return $this->hasMany(ModelInfoAsesores::class, 'id', 'cedula_asesor');
    }
}
