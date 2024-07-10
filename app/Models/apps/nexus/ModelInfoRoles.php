<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoRoles extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'roles';

    protected $fillable = [
        'id',
        'rol',
        'estado'
    ];
}
