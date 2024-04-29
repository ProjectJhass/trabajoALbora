<?php

namespace App\Http\Controllers\apps\crm_almacenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerInicioCrm extends Controller
{
    public  function index()
    {
        $cargo = Auth::user()->cargo;
        switch ($cargo) {
            case 'asesor':
                return redirect(route('home.crm.asesor'));
                break;
            case 'administrador':
                return redirect(route('home.crm.admin'));
                break;

            default:
                return redirect()->back();
                break;
        }
    }
}
