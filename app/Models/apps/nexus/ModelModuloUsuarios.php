<?php
namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 


class ModelModuloUsuarios extends Model{
    use HasFactory;

    protected $connection="app_nexus";

    protected $table = "modulos_usuarios";

    protected $primaryKey="id_modulos_usuarios";


    protected $fillable=[
        "id_modulos_usuarios",
        "id",
        "id_modulo",
    ];


    public function usuario(){
        return $this->belongsTo('App\Models\apps\intranet\ModelUsersIntranet','id','id');
    }

    public function modulos(){
        return $this->belongsTo('App\Models\apps\nexus\ModelInfoModulos','id_modulo','id_modulo');
    }
}







