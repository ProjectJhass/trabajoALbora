<?php

namespace App\Http\Controllers\apps\cotizador_pruebas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControllerCatalogo extends Controller
{
    public function index()
    {
        return view('apps.cotizador_pruebas.catalogo');
    }
}
