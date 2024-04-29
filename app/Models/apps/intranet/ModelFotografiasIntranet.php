<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelFotografiasIntranet extends Model
{
    use HasFactory;

    public static function AgregarFotosReglamento($data)
    {
        DB::table('registro_reglamento')->insert($data);
    }
}
