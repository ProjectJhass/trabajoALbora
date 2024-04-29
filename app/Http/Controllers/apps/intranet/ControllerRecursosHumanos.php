<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelRecursosHumanos;
use Illuminate\Http\Request;

class ControllerRecursosHumanos extends Controller
{
    public function index()
    {
        return view('apps.intranet.rrhh.home');
    }

    public function Reglamento()
    {
        $documentos = ModelRecursosHumanos::ObtenerInfoReglamento();
        return view('apps.intranet.rrhh.reglamento_interno', ['documentos' => $documentos]);
    }
}
