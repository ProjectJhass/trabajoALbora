<?php

namespace App\Http\Controllers\apps\crm_almacenes;

use App\Http\Controllers\Controller;
use App\Models\apps\crm_almacenes\ModelLiquidadorDescuentos;
use Illuminate\Http\Request;

class ControllerLiquidadorDescuentos extends Controller
{
    public function index()
    {
        return view('apps.crm_almacenes.gcp.descuentos');
    }

    protected static function ObtenerMesesTranscurridos($fecha_inicial)
    {
        $fecha_i = $fecha_inicial; //date('Y-m', strtotime($fecha_inicial)) . "-01";
        $fecha_vencida = date_create($fecha_i);
        $fecha_actual = date_create(date('Y-m-d'));
        $diferencia = $fecha_vencida->diff($fecha_actual);
        $meses = $diferencia->format("%m");
        $years = $diferencia->format("%y") * 12;
        return $meses + $years;
    }

    protected static function ObtenerValorPresente($cuota_mensual, $plan, $interes_mensual)
    {
        $valor_presente = 0;
        for ($i = $plan; $i > 0; $i--) {
            $valor_presente += ($cuota_mensual) / pow((1 + $interes_mensual), $i);
        }
        return $valor_presente;
    }

    protected static function ObtenerCalculosDecuentos($valor_presente, $plan, $cuota_mensual, $interes_mensual)
    {
        $vlr_presente = $valor_presente;
        $data = array();
        for ($i = 1; $i <= $plan; $i++) {
            $valor_presente_mod = $vlr_presente;
            $vlr_interes = ($valor_presente_mod * $interes_mensual);
            $abono_a_capital = ($cuota_mensual - $vlr_interes);
            $valor_a_pagar = ($valor_presente_mod - $abono_a_capital);
            $vlr_presente = $valor_a_pagar;

            array_push($data, (['cuota' => $i, 'mensual' => $cuota_mensual, 'abono_capital' => $abono_a_capital, 'interes' => $vlr_interes, 'saldo' => $valor_a_pagar]));
        }
        return $data;
    }

    public function getValorInteresDescuento($fecha_facturacion)
    {
        $fecha_band = '';
        $interes_band = 0;

        $fecha_db = '';
        $interes_db = 0;

        $interes_dsto = 0;

        $month = date('m', strtotime($fecha_facturacion));
        $year = date('Y', strtotime($fecha_facturacion));
        $data = ModelLiquidadorDescuentos::whereMonth('fecha_liquidador', $month)->whereYear('fecha_liquidador', $year)->get();

        if (count($data) == 1) {
            foreach ($data as $key => $value) {
                $interes_dsto = str_replace(',', '.', $value->interes_dsto);
            }
            return $interes_dsto;
        } else {
            foreach ($data as $key => $value) {
                if (!empty($fecha_band) && !empty($interes_band)) {
                    $fecha_db = $value->fecha_liquidador;
                    $interes_db = str_replace(',', '.', $value->interes_dsto);
                    if ($fecha_facturacion > $fecha_band && $fecha_facturacion <= $fecha_db) {
                        return $interes_db;
                    }
                    if ($fecha_facturacion <= $fecha_band) {
                        return $interes_band;
                    }
                } else {
                    $fecha_band = $value->fecha_liquidador;
                    $interes_band = str_replace(',', '.', $value->interes_dsto);
                }
            }
        }
    }

    public function ObtenerValoresLiquidadorDescuentos(Request $request)
    {
        $fecha_inicial = $request->fecha; //Se utiliza para obtener la tasa de usuara
        $plan_credito = $request->plan; //Meses en los que financio el credito
        $valor_capital = $request->capital; //Valor financiado

        $cuota_mensual = ($valor_capital / $plan_credito);

        $interes_mensual = self::getValorInteresDescuento($fecha_inicial);

        $valor_presente = self::ObtenerValorPresente($cuota_mensual, $plan_credito, $interes_mensual);

        $numero_meses = self::ObtenerMesesTranscurridos($fecha_inicial);

        $data = self::ObtenerCalculosDecuentos($valor_presente, $plan_credito, $cuota_mensual, $interes_mensual);

        $total_capital = 0;
        $total_i = 0;

        foreach ($data as $key => $value) {
            if ($value['cuota'] > $numero_meses) {
                $total_capital += $value['mensual'];
                if ($value['cuota'] > ($numero_meses + 1)) {
                    $total_i += $value['interes'];
                }
            }
        }

        return response()->json(['status' => true, 'capital' => round($total_capital), 'intereses' => round($total_i)], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
