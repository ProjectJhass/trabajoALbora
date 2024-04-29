<?php

namespace App\Http\Controllers\apps\cotizador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControllerCatalogo extends Controller
{
    public function index()
    {
        return view('apps.cotizador.catalogo');
    }
}
