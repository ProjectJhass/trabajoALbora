<?php

namespace App\Http\Controllers\apps\cotizador;

use App\Http\Controllers\Controller;
use App\Models\apps\cotizador\ModelCotizaciones;
use Illuminate\Http\Request;

class ControllerValidarProductos extends Controller
{
    public function index(Request $request)
    {
        $bandera = false;
        if ($request->validar == 1) {
            $items = ModelCotizaciones::where("idsession", session('IdSession'))->count();
            $contado = ModelCotizaciones::where("idsession", session('IdSession'))->where('plan', 'CO')->count();
            $credito = ModelCotizaciones::where("idsession", session('IdSession'))->where('plan', '<>', 'CO')->count();
            if ($items == $contado) {
                $bandera = true;
            } else {
                if ($items == $credito) {
                    $bandera = true;
                }
            }
            return response()->json(['status' => $bandera], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
