<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCargosModulo extends Model
{
    use HasFactory;

    protected $connection = 'app_nexus';


    protected $table = 'cargos_modulos';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_cargo',
        'id_modulo',
        'estado',
    ];


    
    public function modulo_capacitacion(){
        return $this->belongsTo('App\Models\apps\nexus\ModelInfoModulos','id_modulo','id_modulo');
    }

    public function cargos(){
        return $this->belongsTo('App\Models\apps\nexus\ModelInfoCargos','id_cargo','id_cargo');
    }
}
