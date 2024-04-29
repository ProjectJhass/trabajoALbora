<?php

namespace App\Models\apps\crm_almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoDepartamentos extends Model
{
    use HasFactory;
    
    protected $connection = 'cotizador';

    protected $table = 'departamentos';

    protected $primaryKey = 'row_id';

    protected $fillable = [
        'id_depto',
        'depto'
    ];

}
