<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelSeccionesManual extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'secciones_manual';

    protected $primaryKey = 'id_seccion';

    protected $fillable = [
        'id_seccion',
        'seccion'
    ];

    public function subSecciones()
    {
        return $this->hasMany(ModelSubSeccionesManual::class, 'id_seccion_padre', 'id_seccion');
    }
}
