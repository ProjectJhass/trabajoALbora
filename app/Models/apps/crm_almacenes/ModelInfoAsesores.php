<?php

namespace App\Models\apps\crm_almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoAsesores extends Model
{
    use HasFactory;

    protected $connection = 'albura_cotizador';

    protected $table = 'users';

    protected $fillable = [
        'codigo',
        'nombre',
        'usuario',
        'zona',
        'sucursal',
        'cargo',
        'estado'
    ];

    public function clientesEfectivos(){

        return $this->hasMany(ModelClientesCRM::class, 'cedula_asesor','id');
    }

    public function presupuestoAsesor()
    {
        return $this->hasMany(ModelPresupuestoAsesor::class, 'id_asesor', 'id');
    }
}
