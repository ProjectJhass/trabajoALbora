<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use App\Models\apps\servicios_tecnicos\servicios\ModelEtapasServicios;
use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHistorialFechasNotificacion extends Model
{
    use HasFactory;

    protected $table = 'historial_fechas_notificaciones';

    protected $fillable = [
        'id_st',
        'id_etapa',
        'fecha_inicial',
        'transcurrido',
        'retraso',
        'fecha_envio',
        'estado',
    ];

    public function nuevaSolicitud()
    {
        return $this->belongsTo(ModelNuevaSolicitud::class, 'id_st');
    }

    public function etapasServicios()
    {
        return $this->belongsTo(ModelEtapasServicios::class, 'id_etapa');
    }
}
