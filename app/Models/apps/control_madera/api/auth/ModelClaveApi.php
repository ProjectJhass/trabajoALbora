<?php

namespace App\Models\apps\control_madera\api\auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelClaveApi extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'auth_api';

    protected $fillable = [
        'id',
        'clave'
    ];
}
