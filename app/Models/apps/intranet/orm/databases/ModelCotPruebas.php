<?php

namespace App\Models\apps\intranet\orm\databases;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCotPruebas extends Model
{
    use HasFactory;

    protected $connection = 'db_cotizador_pruebas';

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
