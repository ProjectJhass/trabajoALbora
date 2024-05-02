<?php

namespace App\Http\Controllers\apps\control_madera;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControllerFabricaMadera extends Controller
{
    public function home()
    {
        return view('apps.control_madera.app.home');
    }
}
