<?php

namespace App\Models\apps\crm_almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelPresupuestoAsesor extends Model
{
    use HasFactory;

    protected $connection = 'cotizador';

    protected $table = 'presupuesto_asesor';

    protected $primaryKey = 'id_presupuesto';

    protected $fillable = [
        'id_asesor',
        'presupuesto',
        'presupuesto_2',
        'fecha'
    ];
}
