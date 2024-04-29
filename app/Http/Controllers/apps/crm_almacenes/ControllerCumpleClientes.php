<?php

namespace App\Http\Controllers\apps\crm_almacenes;

use App\Http\Controllers\Controller;
use App\Models\apps\crm_almacenes\ModelClientesCRM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerCumpleClientes extends Controller
{
    public function index()
    {
        $ayer = date("Y-m-d", strtotime(date('Y-m-d') . "- 1 days"));
        $siete_dias = date("Y-m-d", strtotime(date('Y-m-d') . "- 1 days"));

        $cumple_hoy = ModelClientesCRM::whereDay('fecha_cumple', date('Y-m-d'))
            ->whereMonth('fecha_cumple', date('Y-m-d'))
            ->where('cedula_asesor', Auth::user()->id)
            ->get();

        $cumple_ayer = ModelClientesCRM::whereDay('fecha_cumple', $ayer)
            ->whereMonth('fecha_cumple', $ayer)
            ->where('cedula_asesor', Auth::user()->id)
            ->get();
        $siente_dias = ModelClientesCRM::whereDay('fecha_cumple', $siete_dias)
            ->whereMonth('fecha_cumple', $siete_dias)
            ->where('cedula_asesor', Auth::user()->id)
            ->get();


        return view('apps.crm_almacenes.gcp.asesor.cumple', ['hoy' => $cumple_hoy, 'ayer' => $cumple_ayer, 'siente' => $siente_dias]);
    }
}
