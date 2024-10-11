<?php

namespace App\Models\apps\nexus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCargoUsuarios extends Model{
    use HasFactory;

    protected $connection="app_nexus";

    protected $table= "cargo_usuarios";

    protected $primaryKey='id_cargo_usuarios';

    protected $fillable=[
        "id_cargo_usuarios",
        "id",
        "id_cargo",
    ];


    public function usuario(){
        return $this->belongsTo('App\Models\apps\intranet\ModelUsersIntranet','id','id');
    }

    public function cargos(){
        return $this->belongsTo('App\Models\apps\nexus\ModelInfoCargos','id_cargo','id_cargo');
    }
}