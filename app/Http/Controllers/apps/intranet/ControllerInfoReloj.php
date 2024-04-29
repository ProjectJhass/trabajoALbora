<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelRecursosHumanos;
use Illuminate\Http\Request;

class ControllerInfoReloj extends Controller
{
    public function index()
    {  
        ModelRecursosHumanos::vaciarDBApi();      
        return view('apps.intranet.rrhh.reloj');
    }
}
