<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoManualFunciones extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'manual_funciones';

    protected $primaryKey = 'id_manual';

    protected $fillable = [
        'id_manual',
        'id_empresa',
        'id_cargo',
        'cargo',
        'id_area',
        'area',
        'operacion_asignada',
        'jefe_inmediato',
        'autoridad_formal',
        'objetivo_general',
        'estado',
        'usuario_actualizacion'
    ];

    public function funcionesGenerales()
    {
        return $this->hasMany(ModelFuncionesGeneralesManual::class, 'id_manual', 'id_manual');
    }
}
