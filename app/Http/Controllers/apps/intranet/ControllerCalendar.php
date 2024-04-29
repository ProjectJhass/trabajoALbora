<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelCalendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerCalendar extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;

        $eventos = ModelCalendar::eventos($id);
        return view('apps.intranet.ingresos.asesor.calendario', ['eventos'=>$eventos]);
    }
}
