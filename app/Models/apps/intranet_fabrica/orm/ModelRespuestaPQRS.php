<?php

namespace App\Models\apps\intranet_fabrica\orm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelRespuestaPQRS extends Model
{
    use HasFactory;

    protected $connection = 'pqrs_fabrica';

    protected $table = 'respuesta';

    protected $primaryKey = 'id_respuesta';

    protected $fillable = [
        'consecutivo',
        'fecha',
        'hora',
        'responsable',
        'respuesta',
    ];
}
