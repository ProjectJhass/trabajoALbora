<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelFechasExcluidas extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';

    protected $table = 'fechasexcluidas';

    protected $fillable = [
        'fecha'
    ];
}
