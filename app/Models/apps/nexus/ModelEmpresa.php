<?php 
namespace App\Models\apps\nexus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


 class ModelEmpresa extends Model 
{
    use HasFactory;

    protected $connection = 'app_nexus';

    protected $table='Empresa';

    protected $primaryKey = 'id_empresa';

    protected $fillable = [
        'id_empresa',
        'nombre_empresa',
        'descripcion_empresa',
    ];


    public function areas()
    {
        return $this->hasMany(ModelInfoAreas::class, 'id_empresa', 'id_empresa');
    }
}




?>