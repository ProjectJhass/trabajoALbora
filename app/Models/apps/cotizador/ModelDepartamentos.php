<?php

namespace App\Models\apps\cotizador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelDepartamentos extends Model
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
