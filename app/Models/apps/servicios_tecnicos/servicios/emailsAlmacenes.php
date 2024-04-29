<?php

namespace App\Models\apps\servicios_tecnicos\servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emailsAlmacenes extends Model
{
    use HasFactory;

    protected $connection = 'servicios_tecnicos';

    protected $table = 'emails_almacenes';

    protected $primaryKey = 'id_email';

    protected $fillable = [
        'id_email',
        'email',
        'id_co',
        'almacen'
    ];
}
