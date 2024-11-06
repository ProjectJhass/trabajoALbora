<?php

namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelModuloTemas extends Model{
    use HasFactory;

    protected $connection='app_nexus';


    protected $table = 'modulos_temas';

    protected $primaryKey='id_modulos_temas';


    protected $fillable=[
        'id_modulos_temas',
        'id_modulo',
        'id_tema',
    ];

}









