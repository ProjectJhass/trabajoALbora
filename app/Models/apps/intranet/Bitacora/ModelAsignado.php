<?php

namespace App\Models\apps\intranet\Bitacora;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelAsignado extends Model
{
    use HasFactory;

    public static function ObtenerSolicitudesProgreso($estado, $usuario)
    {
        $signo = ($estado == 'completada') ? '=' : '<>';

        return DB::table('bitacora_solicitudes as s')
            ->join('bitacora_usuarios as u', 's.id_solicitud', '=', 'u.id_solicitud')
            ->select(['s.*'])
            ->where('u.estado', $signo, 'completada')
            ->where('u.id_usuario', $usuario)
            ->get();
    }
}
