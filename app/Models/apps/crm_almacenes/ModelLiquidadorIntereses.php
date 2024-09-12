<?php

namespace App\Models\apps\crm_almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelLiquidadorIntereses extends Model
{
    use HasFactory;

    protected $connection = 'albura_cotizador';

    protected $table = 'liquidador_de_intereses';

    protected $primaryKey = 'id_liquidador';

    protected $fillable = [
        'fecha_liquidador',
        'interes_mora'
    ];
}
