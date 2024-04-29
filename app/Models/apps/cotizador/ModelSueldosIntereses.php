<?php

namespace App\Models\apps\cotizador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelSueldosIntereses extends Model
{
    use HasFactory;

    protected $connection = 'cotizador';

    protected $table = 'sueldo_e_interes';

    protected $primaryKey = 'id_table';

    protected $fillable = [
        'sueldo_basico',
        'tasa_de_interes',
        'interes_mora',
        'valor_fianza',
        'iva',
        'porcentaje_iva'
    ];
}
