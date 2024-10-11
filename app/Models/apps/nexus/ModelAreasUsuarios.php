<?php 

namespace App\Models\apps\nexus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelAreasUsuarios extends Model
{
    use HasFactory;

    protected $connection='app_nexus';

    protected $table='area_usuarios';

    protected $primaryKey='id_area_usuarios';

    protected $fillable=[
        'id_area_usuarios',
        'id',
        'id_dpto',
    ];

    public function usuario(){
        return $this->belongsTo('App\Models\apps\intranet\ModelUsersIntranet','id','id');
    }

    public function Areas(){
        return $this->belongsTo('App\Models\apps\nexus\ModelInfoAreas','id_dpto','id_dpto');
    }
}






