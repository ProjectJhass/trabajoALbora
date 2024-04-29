<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelSeguimientoTaller extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';
    
    protected $table = 'seguimiento_taller';

    protected $primaryKey = 'id_seguimiento';

    protected $fillable = [
        "id_seguimiento",
        "seguimiento",
        "responsable",
        "id_st"
    ];

    public function evidencias()
    {
        return $this->hasMany(ModelEvidenciasSeguimiento::class, 'id_seguimiento');
    }
}
