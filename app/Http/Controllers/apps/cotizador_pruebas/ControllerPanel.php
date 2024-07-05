<?php

namespace App\Http\Controllers\apps\cotizador_pruebas;

use App\Http\Controllers\Controller;
use App\Models\apps\cotizador\ModelGenerarHash;
use App\Models\apps\cotizador_pruebas\ModelCotizacionesRealizadas;
use App\Models\soap\cotizador_consultas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class ControllerPanel extends Controller
{
    public function panel(Request $request)
    {
        $origen = $request->origen;
        if (isset($origen)  && !empty($origen)) {
            session(['IdSession' => ModelGenerarHash::make()]);
        }
        $productos_ = cotizador_consultas::productosCotizadorWS();
        return view('apps.cotizador_pruebas.panel', ['productos' => $productos_]);
    }

    public function GenerarNuevaCotizacion()
    {
        session()->forget(['IdSession']);
        session(['IdSession' => ModelGenerarHash::make()]);
        return redirect()->route('lista.precios.pruebas');
    }

    public function AgregarProducto(Request $request)
    {
        $session = session('IdSession');
        $sku = $request->sku;
        $producto = $request->producto;
        $vlr_contado = $request->valor;
        $cantidad =  $request->cantidad;

        $valor_ = ModelCotizacionesRealizadas::where('idsession', $session)->where('sku', $sku)->count();
        if (empty($valor_) || $valor_ == 0) {

            $query = ModelCotizacionesRealizadas::create([
                'idsession' => $session,
                'sku' => $sku,
                'producto' => $producto,
                'vlr_contado' => $vlr_contado,
                'cantidad' => empty($cantidad) ? '1' : $cantidad,
                'vlr_credito' => round($vlr_contado),
                'dsto_adicional' => '0',
                'plan' => 'CO',
                'descuento' => '20',
                'cuotas' => '1',
                'asesor' => Auth::user()->nombre,
                'fecha' => date('Y-m-d'),
                'sucursal' => Auth::user()->sucursal
            ]);

            if ($query) {
                return response()->json(['status' => true, 'mensaje' => 'Producto agregado'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        } else {
            return response()->json(['status' => false], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
