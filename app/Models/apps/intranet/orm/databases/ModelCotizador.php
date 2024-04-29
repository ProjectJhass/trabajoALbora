<?php

namespace App\Models\apps\intranet\orm\databases;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCotizador extends Model
{
    use HasFactory;

    protected $connection = 'db_cotizador';

    protected $table = 'users';

    protected $fillable = [
        'id',
        'codigo',
        'nombre',
        'usuario',
        'password',
        'zona',
        'sucursal',
        'cargo',
        'estado'
    ]; 
}
