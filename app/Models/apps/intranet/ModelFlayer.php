<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelFlayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'imagen',
        'url',
        'tipo',
    ];
}
