<?php

namespace App\Http\Controllers\apps\cotizador;

use App\Http\Controllers\Controller;
use App\Models\apps\cotizador\ModelCotizaciones;
use App\Models\apps\cotizador\ModelGenerarHash;
use App\Models\apps\cotizador\ModelPlanesFinanciacion;
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
        return view('apps.cotizador.panel', ['productos' => $productos_]);
    }

    public function GenerarNuevaCotizacion()
    {
        $data = ([
            'IdSession',
            'cedula_cliente',
            'primer_nombre',
            'segundo_nombre',
            'primer_apellido',
            'segundo_apellido',
            'direccion',
            'ciudad',
            'barrio',
            'telefono1',
            'telefono2',
            'correo',
            'genero',
            'categoria',
            'observaciones',
            'cuotas_plan_cotizador',
            'valor_inicial',
            'cuotas_plan_cotizador',
            'valor_fianza_cotizador',
            'cuota_mensual_cot'
        ]);
        session()->forget($data);


        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');

        session(['IdSession' => ModelGenerarHash::make()]);
        return redirect()->route('lista.precios');
    }

    public function AgregarProducto(Request $request)
    {
        $session = session('IdSession');
        $sku = $request->sku;
        $producto = $request->producto;
        $vlr_contado = $request->valor;
        $cantidad =  $request->cantidad;

        $valor_ = ModelCotizaciones::where('idsession', $session)->where('sku', $sku)->count();
        if (empty($valor_) || $valor_ == 0) {

            $valor_cot = ModelCotizaciones::where('idsession', $session)->first();
            if (!is_null($valor_cot)) {
                $plan_coti = $valor_cot->plan;
            } else {
                $plan_coti = 'CO';
            }
            $planes = ModelPlanesFinanciacion::where('plan', $plan_coti)->first();

            $query = ModelCotizaciones::create([
                'idsession' => $session,
                'sku' => $sku,
                'producto' => $producto,
                'vlr_contado' => $vlr_contado,
                'cantidad' => empty($cantidad) ? '1' : $cantidad,
                'vlr_credito' => round($vlr_contado * (str_replace(',', '.', $planes->valor_tasa))),
                'dsto_adicional' => '0',
                'plan' => $planes->plan,
                'descuento' => '20',
                'cuotas' => $planes->id_tasa,
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
