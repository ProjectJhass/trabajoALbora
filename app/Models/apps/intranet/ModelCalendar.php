<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelCalendar extends Model
{
    use HasFactory;

    public static function eventos($id)
    {
        return DB::table('eventos')->where('cedula_evento', $id)->get();
    }
}
