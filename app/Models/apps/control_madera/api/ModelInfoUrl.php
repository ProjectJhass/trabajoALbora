<?php

namespace App\Models\apps\control_madera\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoUrl extends Model
{
    use HasFactory;

    protected $connection = 'db_control_madera';

    protected $table = 'info_url';

    protected $fillable = [
        'id',
        'url'
    ];
}
