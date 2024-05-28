<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\soap\cotizador_consultas;
use Illuminate\Http\Request;

class ItemsActivosSiesa extends Controller
{
    public function index(){
        $productos = cotizador_consultas::productosCotizadorWS();
        return response()->json(['status' => true, 'productos' => $productos], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function ObtenerPrecioProductoBuscado(Request $request)
    {
        $precio = 0;
        $descuento = 20;
        $nom_p = '';
        $producto = cotizador_consultas::producto_buscado_ws($request->id_producto);
        foreach ($producto as $key => $value) {
            $precio = round($value['precio']);
            $nom_p = $value['producto'];
        }
        return response()->json(['status' => true, 'precio' => $precio, 'descuento' => $descuento, 'producto' => $nom_p], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
