<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHistoricoNotificacionesPersonalizadas extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';

    protected $table = 'historico_notificaciones_personalizadas';

    protected $fillable = [
        'id_st',
        'id_proceso',
        'dias_transcurridos',
        'day',
        'month',
        'year',
    ];

    public function nuevaSolicitud() {
        return $this->belongsTo(ModelNuevaSolicitud::class, 'id_st');
    }

    public function etapasServicios() {
        return $this->belongsTo(ModelEtapasServicios::class, 'id_proceso');
    }

}
