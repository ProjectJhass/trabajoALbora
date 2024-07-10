<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelEntrevistasRealizadas extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'entrevistas_realizadas';

    protected $fillable = [
        'id',
        'proceso',
        'sede',
        'fecha',
        'cedula',
        'nombre',
        'apellidos',
        'id_dpto',
        'departamento',
        'id_ciudad',
        'ciudad',
        'barrio',
        'direccion',
        'fecha_nacimiento',
        'edad',
        'cargo_aspira',
        'tipo_vivienda',
        'libreta_militar',
        'clase',
        'distrito',
        'camisa',
        'pantalon',
        'zapatos',
        'primaria',
        'secundaria',
        'profesional',
        'complementaria',
        'id_usuario',
        'usuario_creador',
        'estado'
    ];

    public function infoFamiliar()
    {
        return $this->hasMany(ModelInformacionFamilia::class, 'id_entrevista', 'id');
    }

    public function infoAspectosGenerales()
    {
        return $this->hasMany(ModelRespuestaAspectosPersonales::class, 'id_entrevista', 'id');
    }

    public function infoExpLaboral()
    {
        return $this->hasMany(ModelExperienciaLaboral::class, 'id_entrevista', 'id');
    }
}
