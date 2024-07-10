<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelDepartamentos extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'departamentos';

    protected $primaryKey = 'row_id';

    protected $fillable = [
        'row_id',
        'id_depto',
        'depto'
    ];
}
