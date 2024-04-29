<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControllerLogistica extends Controller
{
    public function index()
    {
        return view('apps.intranet.logistica.home');
    }
}
