<?php

namespace App\Http\Controllers\apps\cotizador;

use App\Http\Controllers\Controller;
use App\Models\apps\cotizador\cartera\ModelCartera;
use App\Models\apps\cotizador\ModelCiudadesCot;
use App\Models\apps\cotizador\ModelCotizaciones;
use App\Models\apps\cotizador\ModelDepartamentos;
use App\Models\apps\cotizador\ModelModificacionPlan;
use App\Models\apps\cotizador\ModelPlanesFinanciacion;
use App\Models\apps\cotizador\ModelSueldosIntereses;
use Illuminate\Http\Request;

class ControllerLiquidador extends Controller
{
    public function ConsultarCiudad(Request $request)
    {
        if (request()->ajax()) {
            $id = $request->id;
            $val = '<option value="">Seleccionar...</option>';
            $deptos = ModelCiudadesCot::where('id_depto', $id)->orderBy('ciudad')->get();
            foreach ($deptos as $key => $value) {
                $val .= '<option value="' . $value->ciudad . '" data-id_city="' . $value->id_city . '" data-id_depto="' . $value->id_depto . '" data-id_pais="' . $value->id_pais . '">' . $value->ciudad . '</option>';
            }
            return response()->json(['status' => true, 'ciudad' => $val], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function TablaProductos($productos)
    {
        return view('apps.cotizador.tableProducts')->with('productos', $productos)->render();
    }

    public function realizarCalculosCot()
    {

        session()->forget('cuotas_plan_cotizador');

        $info_saldos = ModelSueldosIntereses::find(1);
        $porcetaje_fianza = $info_saldos->valor_fianza;

        $proc_ga = ($porcetaje_fianza / 100);
        $val_neto = 0;
        $val_dsto = 0;
        $val_dsto_ad = 0;
        $cuotas_ = 1;

        $productos = ModelCotizaciones::where('idsession', session('IdSession'))->get();
        $planes = ModelPlanesFinanciacion::all();


        foreach ($productos as $key => $value) {
            $val_neto_ = ($value->vlr_credito * $value->cantidad);
            $val_neto += $val_neto_;

            $val_dsto_ = ($val_neto_ * ($value->descuento / 100));
            $val_dsto += $val_dsto_;

            $val_dsto_ad_ = ($val_neto_ - $val_dsto_) * ($value->dsto_adicional / 100);

            $val_dsto_ad += $val_dsto_ad_;

            $cuotas_ = $value->cuotas;
        }

        $total_venta = $val_neto - $val_dsto - $val_dsto_ad;
        $garantia = ($total_venta * $proc_ga);

        $cuota_inicial = ((session('valor_inicial') !== NULL) && ($cuotas_ != 1)) ? session('valor_inicial') : '0';
        $cuota_mensual_ = ($total_venta - $cuota_inicial) / $cuotas_;
        $cuota_mensual = ($cuota_mensual_);

        $venta_ttal = (($cuota_mensual * $cuotas_) + $cuota_inicial);

        session(['cuotas_plan_cotizador' => $cuotas_, 'valor_fianza_cotizador' => $garantia, 'cuota_mensual_cot' => $cuota_mensual]);

        return ([
            'productos' => $productos,
            'neto' => $val_neto,
            'normal' => $val_dsto,
            'adicional' => $val_dsto_ad,
            'total' => $total_venta,
            'garantia' => $garantia,
            'inicial' => $cuota_inicial,
            'mensual' => $cuota_mensual,
            'cuotas' => $cuotas_,
            'venta_total' => $venta_ttal, //+$parte_decimal,
            'planes' => $planes,
            'cc' => isset($cc) ? '1' : '0'
        ]);
    }



    public function planesDeVentas()
    {
        $cotizador = self::realizarCalculosCot();

        return view('apps.cotizador.detalleVenta', [
            'neto' => $cotizador['neto'],
            'normal' => $cotizador['normal'],
            'adicional' => $cotizador['adicional'],
            'total' => $cotizador['total'],
            'garantia' => $cotizador['garantia'],
            'inicial' => $cotizador['inicial'],
            'mensual' => $cotizador['mensual'],
            'cuotas' => $cotizador['cuotas'],
            'venta_total' => $cotizador['venta_total'],
            'planes' => $cotizador['planes'],
            'cc' => isset($cc) ? '1' : '0'
        ])->render();
    }

    public function index()
    {

        $cotizador = self::realizarCalculosCot();

        $productos = $cotizador['productos'];

        $dptos = ModelDepartamentos::all();
        $tableView = self::TablaProductos($productos);
        $planesVentaC = self::planesDeVentas();

        return view(
            'apps.cotizador.productos_cotizados',
            [
                'tblProducts' => $tableView,
                'productos' => $productos,
                'planesV' => $planesVentaC,
                'dptos' => $dptos,
                'neto' => $cotizador['neto'],
                'normal' => $cotizador['normal'],
                'adicional' => $cotizador['adicional'],
                'total' => $cotizador['total'],
                'garantia' => $cotizador['garantia'],
                'inicial' => $cotizador['inicial'],
                'mensual' => $cotizador['mensual'],
                'cuotas' => $cotizador['cuotas'],
                'venta_total' => $cotizador['venta_total'],
                'planes' => $cotizador['planes'],
                'cc' => isset($cc) ? '1' : '0'
            ]
        );
    }


    public function eliminar(Request $request)
    {
        $id_cotizacion = $request->id_cotizacion;
        $info_ = ModelCotizaciones::find($id_cotizacion);
        $info_->delete();

        $productos = ModelCotizaciones::where('idsession', session('IdSession'))->get();
        $tableView = self::TablaProductos($productos);
        $planesVentaC = self::planesDeVentas();

        return response()->json(['status' => true, 'tblProducts' => $tableView, 'viewDetalle' => $planesVentaC], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function actualizar(Request $request)
    {
        $id_cotizacion = $request->id_cotizacion;
        $cantidad = empty($request->cantidad) ? '1' : $request->cantidad;
        $descuento = empty($request->descuento) ? '0' : $request->descuento;
        $dsto_adicional = empty($request->dsto_ad) ? '0' : $request->dsto_ad;

        $info_cot = ModelCotizaciones::find($id_cotizacion);
        $info_cot->cantidad = $cantidad;
        $info_cot->descuento = $descuento;
        $info_cot->dsto_adicional = $dsto_adicional;
        $info_cot->save();

        $productos = ModelCotizaciones::where('idsession', session('IdSession'))->get();
        $tableView = self::TablaProductos($productos);
        $planesVentaC = self::planesDeVentas();

        return response()->json(['status' => true, 'tblProducts' => $tableView, 'viewDetalle' => $planesVentaC], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }


    public function validarPlanesItems($aplica, $valor, $tasa_f, $dsto)
    {
        if ($aplica) {
            $valor_dsto_30 = $valor - ($valor * 0.3);
            $porcentaje_base = (($valor - ($valor_dsto_30 / 0.8)) / $valor);
            $nuevo_valor = ($valor - ($valor * $porcentaje_base));
            return round(($nuevo_valor) * $tasa_f);
        } else {
            return round(($valor) * $tasa_f);
        }
    }


    public function ModificarPlanCotizacion(Request $request)
    {
        $valor_inicial = empty($request->valor_inicial) ? '0' : $request->valor_inicial;
        session(['valor_inicial' => $valor_inicial]);
        $plan = empty($request->plan) ? '1' : $request->plan;

        if ($plan == 1) {
            session()->forget('valor_inicial');
        }

        $info_ = ModelModificacionPlan::find($plan);
        $tasas_f = ModelPlanesFinanciacion::find($plan);

        if ($info_) {
            if ($info_->fecha_finalizacion < date('Y-m-d')) {
                $aplica = false;
                $tasa_f = str_replace(',', '.', $tasas_f->valor_tasa);
                $descuento =  20;
                $dsto = 0;
            } else {
                $aplica = true;
                $tasa_f = $info_->valor_tasa;
                $descuento = 20;
                $dsto = $info_->descuento;
            }
        } else {
            $aplica = false;
            $tasa_f = str_replace(',', '.', $tasas_f->valor_tasa);
            $descuento =  20;
            $dsto = 0;
        }

        $productos = ModelCotizaciones::where('idsession', session('IdSession'))->get();

        foreach ($productos as $key => $value) {
            $data = ([
                'vlr_credito' => self::validarPlanesItems($aplica, $value->vlr_contado, $tasa_f, $dsto),
                'dsto_adicional' => '0',
                'plan' => ($plan == 1) ? 'CO' : $plan . "F",
                'descuento' => $descuento,
                'cuotas' => $plan
            ]);

            ModelCotizaciones::where('id_cotizacion', $value->id_cotizacion)->update($data);
        }

        $productos = ModelCotizaciones::where('idsession', session('IdSession'))->get();
        $tableView = self::TablaProductos($productos);
        $planesVentaC = self::planesDeVentas();

        return response()->json(['status' => true, 'tblProducts' => $tableView, 'viewDetalle' => $planesVentaC], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function estructuraClienteCartera($data)
    {

        $info_g = $data->first();

        $body = '';
        $header = '<div class="alert" role="alert">
            <strong>Observaciones:</strong><br><br>
            El cliente <span style="font-size: 14px; text-transform: uppercase;"><strong>' . $info_g->nombre_cliente . '</strong></span>
            identificado con el número de cédula <span style="font-size: 14px;"><strong>' . $info_g->cedula_cliente . '</strong></span>
            no se le puede realizar el proceso de crédito ya que presenta las siguientes novedades: <br><br>
            <table class="table table-sm">
            <thead>
            <tr>
            <th>Cuenta</th>
            <th>Almacén</th>
            <th>Observaciones</th>
            </tr>
            </thead>
            <tbody>
            ';

        foreach ($data as $key => $value) {
            $body .= '<tr>
                            <td>' . $value->cuenta_cliente . '</td>
                            <td>' . $value->almacen_cliente . '</td>
                            <td>' . $value->observaciones . '</td>
                        </tr>';
        }
        $footer = '</tbody>
                        </table>';
        return $header . $body . $footer;
    }

    public function ValidarDatosCotizacion(Request $request)
    {
        $tbl_sueldo = ModelSueldosIntereses::find(1);
        $salario_min = $tbl_sueldo->sueldo_basico;
        $cuenta_cartera = ModelCartera::where('cedula_cliente', $request->cedula_cliente)->count();

        $validar = false;

        $data = ([
            'cedula_cliente' => strtoupper($request->cedula_cliente),
            'primer_nombre' => strtoupper($request->primer_nombre),
            'segundo_nombre' => strtoupper($request->segundo_nombre),
            'primer_apellido' => strtoupper($request->primer_apellido),
            'segundo_apellido' => strtoupper($request->segundo_apellido),
            'direccion' => strtoupper($request->direccion),
            'ciudad' => strtoupper($request->ciudad),
            'id_ciudad' => $request->id_ciudad,
            'id_depto' => $request->id_depto,
            'id_pais' => $request->id_pais,
            'barrio' => strtoupper($request->barrio),
            'telefono1' => $request->telefono1,
            'telefono2' => $request->telefono2,
            'correo' => strtolower($request->correo),
            'genero' => $request->genero,
            'cumple' => $request->cumple_cl,
            'categoria' => $request->categoria,
            'observaciones' => ucfirst($request->observaciones)
        ]);

        session($data);



        if ($request->tipo_cotizacion != 'CO') {
            if (session('cuota_mensual_cot') != '') {

                if ($cuenta_cartera != 0) {
                    $info_c = ModelCartera::where('cedula_cliente', $request->cedula_cliente)->get();
                    $table = self::estructuraClienteCartera($info_c);
                    return response()->json(['status' => 'cartera', 'mensaje' => 'No puede realizar el crédito a este cliente', 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                }

                if (
                    !empty($request->cedula_cliente)
                    && !empty($request->primer_nombre)
                    && !empty($request->primer_apellido)
                    && !empty($request->direccion)
                    && !empty($request->ciudad)
                    && !empty($request->barrio)
                    && !empty($request->telefono1)
                    && !empty($request->correo)
                    && !empty($request->genero)  && !empty($request->categoria)
                ) {
                    if (session('cuota_mensual_cot') >= ($salario_min * 0.07)) {
                        $validar = true;
                    } else {
                        return response()->json(['status' => false, 'mensaje' => 'La cuota mensual minima debe ser de $ ' . ($salario_min * 0.07)], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                    }
                }
            } else {
                return response()->json(['status' => false, 'mensaje' => 'La sesión ha expirado, recarga la página y vuelve a intentar'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        } else {
            if (
                !empty($request->cedula_cliente)
                && !empty($request->primer_nombre)
                && !empty($request->ciudad)
                && !empty($request->telefono1)
                && !empty($request->genero)
                && !empty($request->categoria)
                && !empty($request->observaciones)
            ) {
                $validar = true;
            }
        }
        if ($validar) {
            session(['tipo_cotizacion_p' => $request->tipo_cotizacion]);
            return response()->json(['status' => true, 'mensaje' => 'Información validada', 'url' => route('finalizar.cotizacion')], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
