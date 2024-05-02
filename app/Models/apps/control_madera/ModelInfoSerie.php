<?php

namespace App\Models\apps\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoSerie extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'info_series';

    protected $primaryKey = 'id_serie';

    protected $fillable = [
        'id_serie',
        'serie',
        'estado'
    ];
}
