<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInfoAreas extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table = 'areas';

    protected $primaryKey = 'id_dpto';

    protected $fillable = [
        'id_dpto',
        'nombre_dpto',
        'descripcion_dpto',
        'name_image',
        'id_empresa'
    ];


    public function empresa()
    {
        return $this->belongsTo(ModelEmpresa::class, 'id_empresa', 'id_empresa');
    }
}
