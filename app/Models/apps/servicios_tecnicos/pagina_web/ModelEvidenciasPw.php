<?php

namespace App\Models\apps\servicios_tecnicos\pagina_web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelEvidenciasPw extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';

    protected $table = 'evidencias_web';

    protected $primaryKey = 'id_evidencia';

    protected $fillable = [
        'id_evidencia',
        'id_ost_FK',
        'extension',
        'url',
        'nombre_doc',
        'tipo_doc',
        'tamanio',
        'fecha'
    ];
}
