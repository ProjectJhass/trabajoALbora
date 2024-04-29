<?php

namespace App\Http\Controllers\apps\crm_almacenes\liquidador;

use App\Http\Controllers\Controller;
use App\Models\apps\crm_almacenes\ModelLiquidadorIntereses;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ControllerLiquidadorIntereses extends Controller
{
    public function index()
    {
        return view('apps.crm_almacenes.gcp.intereses');
    }

    public function EstructuraTabla($cuota_vencida, $plan, $valor_cuota, $dias, $intereses)
    {
        $tabla = '';
        $ban = 0;

        for ($i = $cuota_vencida; $i <= $plan; $i++) {
            $ban++;
            $dias_ = (($i == $cuota_vencida) ? $dias : '');
            $input_dif = ($i == $cuota_vencida) ? '<input type="number" name="valor_diferencia" onchange=' . "ValidarValorDiferencia('" . $i . "',this.value)" . ' id="valor_diferencia">' : '';
            $interes_ = ($i == $cuota_vencida) ? '$ ' . number_format($intereses) : '';
            $check = ($i == $cuota_vencida) ? 'checked disabled' : '';

            $tabla .= '<tr>
        <td>' . $i . '</td>
        <td id="valor' . $i . '">$ ' . number_format($valor_cuota) . '</td>
        <td id="dias' . $i . '">' . $dias_ . '</td>
        <td id="diferencia' . $i . '">' . $input_dif . '</td>
        <td id="interes' . $i . '">' . $interes_ . '</td>
        <td>
            <div class="form-check">
                <input class="form-check-input" onchange="PagarCuotaExtra(this.value, ' . $ban . ')"  type="checkbox" value="' . $i . '" id="checkbox' . $i . '" ' . $check . '>
            </div>
        </td>
    </tr>';
        }

        return $tabla;
    }

    public function TasaMensual($tasa_anual)
    {
        $tasa_anual_ = str_replace(',', '.', $tasa_anual);
        $tasa_anual_ = floatval($tasa_anual_);
        return ((pow(((1 + $tasa_anual_)), (1 / 365))) - 1);
    }

    public function ObtenerDiasTranscurridos($fecha_inicial, $fecha_final)
    {
        $ajustar_dias = date("d", strtotime($fecha_inicial)) == 1 ? 1 : 0;
        if ($fecha_inicial >= $fecha_final || $fecha_inicial > date('Y-m-d')) {
            return 0;
        }
        $dias =  Carbon::createFromFormat('Y-m-d', $fecha_final)->diffInDays(Carbon::createFromFormat('Y-m-d', $fecha_inicial));
        return $dias + $ajustar_dias;
    }

    public function ObtenerMesesTranscurridos($fechaInicial)
    {
        $fechaDada = Carbon::parse($fechaInicial);
        $fechaActual = Carbon::now();
        return $fechaDada->diffInMonths($fechaActual);
    }

    public function ObtenerSiguienteMes($fecha)
    {
        $fecha_modificar = date("Y-m", strtotime($fecha));
        $fecha = $fecha_modificar . "-01";
        return date("Y-m-d", strtotime($fecha . "+ 1 month"));
    }

    public function ObtenerDiasIntereses($fecha_vencida)
    {
        $dias_ajustar = 0;

        $fecha_modificar = date("Y-m", strtotime($fecha_vencida));
        $fecha_final =  $fecha_modificar . "-30";
        $fecha_final = ($fecha_final > date('Y-m-d')) ? date('Y-m-d') : $fecha_final;

        $day = date("d", strtotime($fecha_vencida));
        $month = date("m", strtotime($fecha_vencida));
        $year = date("Y", strtotime($fecha_vencida));

        $info_liq = ModelLiquidadorIntereses::whereMonth('fecha_liquidador', $month)->whereYear('fecha_liquidador', $year)->first();
        if ($info_liq) {
            $interes_ = $info_liq->interes_mora;
        } else {
            $interes_ = 0;
        }
        if ($month == 2) {
            switch ($day) {
                case '28':
                    $dias_ajustar = 2;
                    $fecha_final = $fecha_modificar . "-28";
                    break;
                case '29':
                    $dias_ajustar = 1;
                    $fecha_final = $fecha_modificar . "-29";
                    break;
            }
        }
        $dias_vencidos = self::ObtenerDiasTranscurridos($fecha_vencida, $fecha_final);
        $dias_vencidos = $dias_vencidos + $dias_ajustar;
        $tasa_efectiva_diaria = self::TasaMensual($interes_);

        if ($fecha_vencida >= date('Y-m-d')) {
            return (['dias' => 0, 'tasa' => 0]);
        }

        return (['dias' => $dias_vencidos, 'tasa' => $tasa_efectiva_diaria]);
    }

    public function RealizarCalculosGenerales($fecha_vencida, $valor_cuota)
    {
        if ($fecha_vencida > date('Y-m-d')) {
            return (['dias' => 0, 'intereses' => 0]);
        }
        $fechaInicial = date("Y-m", strtotime($fecha_vencida)) . "-01";
        $meses_vencidos = self::ObtenerMesesTranscurridos($fechaInicial);

        $total_dias = 0;
        $total_interes = 0;

        for ($i = 0; $i <= $meses_vencidos; $i++) {

            $mes_validar = $fecha_vencida;
            $datos = self::ObtenerDiasIntereses($mes_validar);
            $dias_t = $datos['dias'];
            $tasa_diaria = $datos['tasa'];

            $intereses = ($valor_cuota * $dias_t * $tasa_diaria);

            $total_interes += $intereses;
            $total_dias += $dias_t;

            $fecha_vencida = self::ObtenerSiguienteMes($mes_validar);
        }
        return (['dias' => $total_dias, 'intereses' => $total_interes]);
    }


    public function RealizarCalculoIntereses(Request $request)
    {
        $plan = $request->plan;
        $cuota_v = $request->cuota_v;
        $fecha_vencida = $request->fecha_v;
        $valor_cuota = $request->cuota;

        $data = self::RealizarCalculosGenerales($fecha_vencida, $valor_cuota);
        $tabla = self::EstructuraTabla($cuota_v, $plan, $valor_cuota, $data['dias'], $data['intereses']);

        return response()->json(['status' => true, 'tabla' => $tabla], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function CalcularValoresNuevaCuota(Request $request)
    {
        $valor_cuota = $request->valor_cuota;
        $fecha_vencida = $request->fecha_v;
        $sumar_meses = ($request->cuota) - 1;

        $fechaVencida = date("Y-m-d", strtotime($fecha_vencida . "+ " . $sumar_meses . " month"));
        $data = self::RealizarCalculosGenerales($fechaVencida, $valor_cuota);

        $valor_intereses = round($data['intereses']);
        $dias_transcurridos = $data['dias'];

        return response()->json(['status' => true, 'valor_c' => $valor_cuota, 'num_dias' => ($valor_intereses == 0) ? 0 : $dias_transcurridos, 'intereses' => $valor_intereses], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function CalcularValoresDiferencia(Request $request)
    {
        $valor_cuota = $request->valor_cuota;
        $fecha_vencida = $request->fecha_v;

        $data = self::RealizarCalculosGenerales($fecha_vencida, $valor_cuota);
        $valor_intereses = round($data['intereses']);
        $dias_transcurridos = $data['dias'];

        return response()->json(['status' => true, 'valor_c' => $valor_cuota, 'num_dias' => $dias_transcurridos, 'intereses' => $valor_intereses], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
