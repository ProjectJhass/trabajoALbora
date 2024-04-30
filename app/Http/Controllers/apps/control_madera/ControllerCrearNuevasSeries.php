<?php

namespace App\Http\Controllers\apps\control_madera;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControllerCrearNuevasSeries extends Controller
{
    public function getView()
    {
        return view('apps.control_madera.app.planner.crear_series.home');
    }
}
