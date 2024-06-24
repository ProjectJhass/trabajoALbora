<?php

namespace App\Models\apps\intranet_fabrica\orm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelAnexosPQRS extends Model
{
    use HasFactory;

    protected $connection = 'pqrs_fabrica';

    protected $table = 'anexos';

    protected $primaryKey = 'id_anexo';

    protected $fillable = [
        'consecutivo',
        'nombre',
        'extension',
        'peso',
        'fecha',
        'hora',
    ];
}
