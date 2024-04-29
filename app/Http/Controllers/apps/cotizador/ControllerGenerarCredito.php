<?php

namespace App\Http\Controllers\apps\cotizador;

use App\Http\Controllers\Controller;
use App\Models\apps\cotizador\ModelCotizaciones;
use App\Models\apps\cotizador\ModelCreditosGenerados;
use App\Models\apps\cotizador\ModelSueldosIntereses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ControllerGenerarCredito extends Controller
{
    protected function GenerarEstructuraCredito()
    {
        $info_saldos = ModelSueldosIntereses::find(1);

        $tasa = $info_saldos->tasa_de_interes;
        $iva_ = $info_saldos->iva;
        $porc_iva = $info_saldos->porcentaje_iva;

        $porc_dsto = '0.2';
        $bandera = 0;

        $productos = ModelCotizaciones::where('idsession', session('IdSession'))->get();

        $valor_total_venta = 0;

        foreach ($productos as $key => $val) {
            $valor_total_venta += ($val->vlr_credito) * ($val->cantidad);
            $bandera++;
        }

        $total_venta_cre = $valor_total_venta - ($valor_total_venta * $porc_dsto);

        $valor_antes_iva = round($valor_total_venta / $iva_);
        $descuento = round($valor_antes_iva * $porc_dsto);
        $venta_antes_iva = round($valor_antes_iva - $descuento);
        $iva = round($venta_antes_iva * $porc_iva);
        $valor_total = round($venta_antes_iva + $iva);
        $saldo_a_plazos = round($valor_total - session('valor_inicial'));
        $cuota_mensual = round($saldo_a_plazos / session('cuotas_plan_cotizador'));

        $varJSON = '{
            cedula: ' . session('cedula_cliente') . ',
            primer_nombre: "' . session('primer_nombre') . '",
            segundo_nombre: "' . session('segundo_nombre') . '",
            primer_apellido: "' . session('primer_apellido') . '",
            segundo_apellido: "' . session('segundo_apellido') . '",
            direccion: "' . session('direccion') . '",
            ciudad: "' . session('ciudad') . '",
            barrio: "' . session('barrio') . '",
            telefono: ' . session('telefono1') . ',
            numero_cuotas: "' . session('cuotas_plan_cotizador') . '",
            valor_antes_iva: ' . $valor_antes_iva . ',
            descuento: ' . $descuento . ',
            venta_antes_iva: ' . $venta_antes_iva . ',
            iva_: ' . $iva . ',
            valor_total: ' . $valor_total . ',
            cuota_inicial: ' . session('valor_inicial') . ',
            cuota_mensual: ' . $cuota_mensual . ',
            saldo_a_plazos: ' . $saldo_a_plazos . ',
            tasa: ' . $tasa . ',
            email:"' . session('correo') . '",
            productos: [';

        $contador = 1;

        foreach ($productos as $key => $value) {

            if ($contador == 1 && $bandera == 1) {
                $varJSON  .= '
                {
                    codigo_productos: "' . $value->sku . '",
                    descripcion: "' . $value->producto . '",
                    cantidad: ' . $value->cantidad . ',
                    valoru: "' . (round((($value->vlr_credito) - ($value->vlr_credito * $porc_dsto)), 0, PHP_ROUND_HALF_UP)) . '",
                }';
            } else {
                if ($contador == $bandera) {
                    $varJSON  .= '
                    {
                        codigo_productos: "' . $value->sku . '",
                        descripcion: "' . $value->producto . '",
                        cantidad: ' . $value->cantidad . ',
                        valoru: "' . (round((($value->vlr_credito) - ($value->vlr_credito * $porc_dsto)), 0, PHP_ROUND_HALF_UP)) . '",
                    }';
                } else {
                    $varJSON  .= '
                    {
                        codigo_productos: "' . $value->sku . '",
                        descripcion: "' . $value->producto . '",
                        cantidad: ' . $value->cantidad . ',
                        valoru: "' . (round((($value->vlr_credito) - ($value->vlr_credito * $porc_dsto)), 0, PHP_ROUND_HALF_UP)) . '",
                    },';
                }
            }
            $contador++;
        }
        $varJSON .= ']}';

        return base64_encode($varJSON);
    }

    protected function GuardarInformacionBD($productos)
    {
        ModelCreditosGenerados::create([
            'valores' => $productos,
            'fecha_envio' => date('Y-m-d'),
            'idcotizacion' => session('IdSession'),
            'asesor' => Auth::user()->nombre
        ]);
    }

    public function GenerarSolicitudCredito()
    {
        $data = $this->GenerarEstructuraCredito();
        self::GuardarInformacionBD($data);
        return Redirect::to('https://albura.coxti.com/administrator/panel-opc/solicitar-cred?data=' . $data);
    }
}
