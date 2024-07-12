<?php

namespace App\Http\Controllers\apps\cotizador;

use App\Http\Controllers\Controller;
use App\Models\apps\cotizador\ModelConsecutivoCotizacion;
use App\Models\apps\cotizador\ModelCotizaciones;
use App\Models\apps\cotizador\ModelInfoSucursales;
use App\Models\apps\cotizador\ModelSueldosIntereses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Luecano\NumeroALetras\NumeroALetras as NumeroALetrasNumeroALetras;
use Codedge\Fpdf\Fpdf\Fpdf;

use function PHPUnit\Framework\isNull;

class ControllerPdfCotizacion extends Controller
{
    protected static function numero_a_Letras($valor)
    {
        $formatter = new NumeroALetrasNumeroALetras();
        return $formatter->toInvoice($valor, '0', 'pesos');
    }

    protected static function obtenerProductosCotizados($id_sesion)
    {
        return ModelCotizaciones::where('idsession', $id_sesion)->get();
    }

    public function GenerarPdfCotizacion()
    {
        $retomar = new ControllerRetomarCotizacion();
        $retomar->GuardarInfoClienteCotizacion();
        $pdf = $this->GenerarPdfCotizacionP();
        $pdf->Output(session('primer_nombre') . ' ' . session('segundo_nombre') . ' ' . session('primer_apellido') . ' ' . session('segundo_apellido') . '.pdf', 'i');
        exit;
    }

    public function GenerarPdfCotizacionP()
    {
        $info_sueldos = ModelSueldosIntereses::find(1);
        $iva = $info_sueldos->iva;
        $porc_iva = $info_sueldos->porcentaje_iva;
        $tasa_plazo = $info_sueldos->tasa_de_interes;
        $tasa_mora = $info_sueldos->interes_mora;

        $cuotas = (session('cuotas_plan_cotizador') == 1) ? 'CO' : session('cuotas_plan_cotizador') . "F";
        $porc_dsto = ($cuotas == 'CO') ? ($info_sueldos->porcentaje_contado/100) : ($info_sueldos->porcentaje_credito/100);
        $vigencia = date("Y-m-d", strtotime(date('Y-m-d') . "+ 8 days"));
        $productos = self::obtenerProductosCotizados(session('IdSession'));

        $info_sucursales = ModelInfoSucursales::where('co', Auth::user()->sucursal)->first();

        if (isNull($info_sucursales)) {
            $sucursal_ = 'Muebles Albura SAS';
            $direccion_ = '';
            $telefono_ = '';
            $email_ = '';
        } else {
            $sucursal_ = $info_sucursales->nombre_sucursal;
            $direccion_ = $info_sucursales->direccion;
            $telefono_ = $info_sucursales->telefonos;
            $email_ = $info_sucursales->email;
        }


        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->Image(public_path('img/logoMueblesAlburapdf.jpeg'), 20, 10, 35, 14, 'JPEG');

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(48, 10, '', 0);
        $pdf->Cell(15, 8, $sucursal_, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(80, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("COTIZACIÓN DE VENTA"), 0);
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(48, 10, '', 0);
        $pdf->Cell(15, 8, $direccion_, 0);
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(48, 10, '', 0);
        $pdf->Cell(15, 8, $telefono_, 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(90, 10, '', 0);

        $info_consec = ModelConsecutivoCotizacion::find(1);
        $consecutivo_ = $info_consec->consecutivo;
        $pdf->Cell(15, 8, "No - " . $consecutivo_, 0);
        $info_consec->consecutivo = $consecutivo_ + 1;
        $info_consec->save();

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(48, 10, '', 0);
        $pdf->Cell(15, 8, $email_, 0);
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(48, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("mueblesalbura.com.co"), 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(91, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode(date('Y-m-d')), 0);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);

        $pdf->Ln(6);
        $pdf->SetFont('Arial', 'U', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("DATOS DEL CLIENTE"), 0);
        $pdf->Ln(7);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Cedula del Cliente  "), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 20, '', 0);
        $pdf->Cell(15, 8, session('cedula_cliente'), 0);

        $pdf->Cell(15, 8, utf8_decode(""), 0);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Nombre del Cliente  "), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode(session('primer_nombre') . ' ' . session('segundo_nombre')), 0);


        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, utf8_decode("Apellido   "), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 20, '', 0);
        $pdf->Cell(15, 10, utf8_decode(session('primer_apellido')), 0);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(45, 10, '', 0);
        $pdf->Cell(15, 10, utf8_decode("Segundo Apellido "), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(15, 10, utf8_decode(session('segundo_apellido')), 0);

        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, utf8_decode("Dirección "), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 20, '', 0);
        $pdf->Cell(15, 10, utf8_decode(session('direccion')), 0);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(45, 10, '', 0);
        $pdf->Cell(15, 10, utf8_decode("Barrio - Ciudad"), 0);

        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(15, 10, utf8_decode(session('barrio') . " - " . session('ciudad')), 0);


        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 11, utf8_decode("Teléfonos"), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 20, '', 0);
        $pdf->Cell(15, 11, utf8_decode(session('telefono1') . ' - ' . session('telefono2')), 0);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(45, 10, '', 0);
        $pdf->Cell(15, 11, utf8_decode("Email"), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(15, 11, utf8_decode(session('correo')), 0);

        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 12, utf8_decode("Forma de Pago  "), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 20, '', 0);
        $pdf->Cell(15, 12, utf8_decode($cuotas), 0);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(45, 10, '', 0);
        $pdf->Cell(15, 12, utf8_decode("Número de Cuotas  "), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(15, 12, utf8_decode(session('cuotas_plan_cotizador')), 0);

        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 13, utf8_decode("Asesor de Venta  "), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 20, '', 0);
        $pdf->Cell(15, 13, utf8_decode(Auth::user()->nombre), 0);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(45, 10, '', 0);
        $pdf->Cell(15, 13, utf8_decode("Vigencia Hasta  "), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(15, 13, utf8_decode($vigencia . " ( 8 días )"), 0);

        $pdf->Ln(2);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 14, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);

        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(8, 10, '', 0);
        $pdf->Cell(15, 12, utf8_decode("DETALLE COTIZACIÓN "), 0);

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 11, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(15, 13, utf8_decode("Descripción del Ítem"), 0);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(43, 20, '', 0);
        $pdf->Cell(15, 13, utf8_decode("Cantidad"), 0);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(1, 10, '', 0);
        $pdf->Cell(15, 13, utf8_decode("Precio Unitario  "), 0);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(7, 10, '', 0);
        $pdf->Cell(15, 13, utf8_decode("Vlr Total"), 0);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(11, 13, utf8_decode("- %"), 0);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(1, 10, '', 0);
        $pdf->Cell(11, 13, utf8_decode("- %"), 0);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(1, 10, '', 0);
        $pdf->Cell(15, 13, utf8_decode("Vlr descontado"), 0);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(6, 10, '', 0);
        $pdf->Cell(15, 13, utf8_decode("Total a pagar"), 0);

        $pdf->Ln(1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 14, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);

        $neto = 0;
        $val_desc = 0;

        foreach ($productos as $key => $val) {

            $vlr_descontado = (($val->vlr_credito) * ($val->cantidad)) * ($val->descuento / 100);
            $vlr_descontado_t = ((($val->vlr_credito) * ($val->cantidad)) - $vlr_descontado) * ($val->dsto_adicional / 100);
            $vlr_dsto = $vlr_descontado + $vlr_descontado_t;

            $neto += ($val->vlr_credito) * ($val->cantidad);
            $val_desc += $vlr_dsto;

            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(2, 10, '', 0);
            $pdf->Cell(15, 14, utf8_decode(($val->sku) . " - " . $val->producto), 0);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(61, 20, '', 0);
            $pdf->Cell(12, 14, utf8_decode($val->cantidad), 0);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(1, 10, '', 0);
            $pdf->Cell(15, 14, "$ " . number_format($val->vlr_credito), 0);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(6, 10, '', 0);
            $pdf->Cell(15, 14, "$ " . number_format(($val->vlr_credito) * ($val->cantidad)), 0);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(2, 10, '', 0);
            $pdf->Cell(10, 14, utf8_decode(($val->descuento) . " %"), 0);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(2, 10, '', 0);
            $pdf->Cell(12, 14, utf8_decode(($val->dsto_adicional) . " %"), 0);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(1, 10, '', 0);
            $pdf->Cell(15, 14, "$ " . number_format($vlr_dsto), 0);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(4, 10, '', 0);
            $pdf->Cell(15, 14, "$ " . number_format((($val->vlr_credito) * ($val->cantidad)) - ($vlr_dsto)), 0);
        }

        $total_venta = $neto - $val_desc;
        $valor_letras = self::numero_a_Letras($total_venta);

        /*Valor venta antes de descuento y antes de IVA */
        $valor_antes = ($neto / $iva);
        /* Descuento (-) */
        if ($cuotas != "CO") {
            $vlr_descuento_ = $valor_antes * ($porc_dsto);
        } else {
            $vlr_descuento_ = $valor_antes * ((($val_desc * 100) / $neto) / 100);
        }

        /* Valor venta antes de IVA */
        $vlr_venta_antes_iva = ($valor_antes - $vlr_descuento_);
        /* IVA */
        $vlr_iva = ($vlr_venta_antes_iva * $porc_iva);
        /* Total de la venta */
        $vlr_total_venta = ($vlr_venta_antes_iva + $vlr_iva);



        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 14, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(15, 16, utf8_decode(""), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(42, 20, '', 0);
        $pdf->Cell(15, 8, utf8_decode(""), 0);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 16, utf8_decode("Valor venta antes de descuento y antes de IVA "), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(50, 10, '', 0, '', 'R');
        $pdf->Cell(15, 16, number_format($valor_antes), 0);

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(15, 16, utf8_decode(""), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(42, 20, '', 0);
        $pdf->Cell(15, 16, utf8_decode(""), 0);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 17, utf8_decode("Descuento (-)"), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(50, 10, '', 0, '', 'R');
        $pdf->Cell(15, 17, number_format($vlr_descuento_), 0);

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(15, 16, utf8_decode(""), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(42, 20, '', 0);
        $pdf->Cell(15, 16, utf8_decode(""), 0);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 17, utf8_decode("Valor venta antes de IVA"), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(50, 10, '', 0, '', 'R');
        $pdf->Cell(15, 17, number_format($vlr_venta_antes_iva), 0);

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(15, 16, utf8_decode(""), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(42, 20, '', 0);
        $pdf->Cell(15, 16, utf8_decode(""), 0);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 17, utf8_decode("IVA"), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(50, 10, '', 0, '', 'R');
        $pdf->Cell(15, 17, number_format($vlr_iva), 0);

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(15, 16, utf8_decode(""), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(42, 20, '', 0);
        $pdf->Cell(15, 16, utf8_decode(""), 0);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 17, utf8_decode("Total de la venta"), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(50, 10, '', 0, '', 'R');
        $pdf->Cell(15, 17, number_format($vlr_total_venta), 0);

        if ($cuotas != "CO") {

            $pdf->Ln(3);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(10, 10, '', 0);
            $pdf->Cell(15, 16, utf8_decode(""), 0);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(42, 20, '', 0);
            $pdf->Cell(15, 16, utf8_decode(""), 0);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(20, 10, '', 0);
            $pdf->Cell(15, 17, utf8_decode("Valor garantia"), 0);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(50, 10, '', 0, '', 'R');
            $pdf->Cell(15, 17, number_format(session('valor_fianza_cotizador')), 0);

            $pdf->Ln(3);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(10, 10, '', 0);
            $pdf->Cell(15, 16, utf8_decode(""), 0);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(42, 20, '', 0);
            $pdf->Cell(15, 16, utf8_decode(""), 0);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(20, 10, '', 0);
            $pdf->Cell(15, 17, utf8_decode("Cuota inicial"), 0);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(50, 10, '', 0, '', 'R');
            $pdf->Cell(15, 17, number_format(session('valor_inicial')), 0);

            $pdf->Ln(3);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(10, 10, '', 0);
            $pdf->Cell(15, 16, utf8_decode(""), 0);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(42, 20, '', 0);
            $pdf->Cell(15, 16, utf8_decode(""), 0);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(20, 10, '', 0);
            $pdf->Cell(15, 17, utf8_decode("Saldo a plazos"), 0);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(50, 10, '', 0, '', 'R');
            $pdf->Cell(15, 17, number_format((session('cuota_mensual_cot')) * (session('cuotas_plan_cotizador'))), 0);
        }

        $pdf->Ln(2);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 14, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode(""), 0);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(60, 20, '', 0);
        $pdf->Cell(15, 18, utf8_decode("Precios incluyen impuestos"), 0);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 18, utf8_decode("Total a Pagar"), 0);
        $pdf->SetFont('Arial', 'U', 8);
        $pdf->SetFillColor(0, 0, 255);
        $pdf->Cell(16, 10, '', 0);
        $pdf->Cell(15, 18, number_format(((session('cuota_mensual_cot')) * (session('cuotas_plan_cotizador')))  + session('valor_inicial')), 0);

        $pdf->Ln(1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(44, 10, '', 0);
        $pdf->Cell(15, 19, utf8_decode("                                                           ___________________________________________________________________________"), 0);

        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 20, utf8_decode("Valor en Letras:   "), 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(10, 21, '', 0);
        $pdf->Cell(15, 21, utf8_decode($valor_letras . " MCTE"), 0);

        if ($cuotas != "CO") {
            $pdf->Ln(18);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(2, 10, '', 0);
            $pdf->MultiCell(0, 5, utf8_decode("Un único pago de $ " . number_format(session('valor_inicial') + session('valor_fianza_cotizador')) . " pesos mcte y " . session('cuotas_plan_cotizador') . " cuotas mensuales de $ " . number_format((session('cuota_mensual_cot'))) . " pesos mcte."));
        }
        $pdf->Ln(1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 22, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 24, utf8_decode("800.009.732-6 Muebles Albura SAS"), 0);


        if ($cuotas != "CO") {
            $pdf->Ln(15);
            $pdf->SetFont('Arial', 'U', 8);
            $pdf->Cell(65, 10, '', 0);
            $pdf->Cell(15, 8, utf8_decode("CONDICIONES GENERALES VENTAS A CREDITO "), 0);

            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(2, 10, '', 0);
            $pdf->MultiCell(0, 4, utf8_decode("FORMA DE PAGO:  Mensual dentro de los _5_ días siguientes al vencimiento de cada cuota, los cuáles deberan ser pagados en el establecimiento de comercio donde se realizó la compra y/o en las sucursales bancarias autorizadas por el vendedor."));

            $pdf->Ln(2);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(2, 10, '', 0);
            $pdf->MultiCell(0, 4, utf8_decode("El valor de la fianza (Garantía de pago prestada por el FONDO DE GARANTÍAS Y DESARROLLO S.A.S - FOGADE) será pagada dentro de los _0_ días comunes siguientes a la fecha de suscripción de esta solicitud crédito, serán pagadas por EL CLIENTE en el establecimiento de comercio o según las formas de pago estipuladas por el vendedor al momento de la suscripción de esta solicitud crédito."));

            $pdf->Ln(4);
            $pdf->SetFont('Arial', 'U', 10);
            $pdf->Cell(2, 10, '', 0);
            $pdf->Cell(15, 8, utf8_decode("Las cuentas bancarias autorizadas para el pago son:"), 0);

            $pdf->Ln(1);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(2, 10, '', 0);
            $pdf->Cell(15, 20, utf8_decode("BANCOLOMBIA: "), 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 20, '', 0);
            $pdf->Cell(15, 20, utf8_decode("Cuenta corriente No. 115-000020-55"), 0);

            $pdf->Ln(4);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(2, 10, '', 0);
            $pdf->Cell(15, 20, utf8_decode("BANCO DE OCCIDENTE: "), 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 20, '', 0);
            $pdf->Cell(15, 20, utf8_decode("Cuenta corriente No. 033-44935-6"), 0);

            $pdf->Ln(4);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(2, 10, '', 0);
            $pdf->Cell(15, 20, utf8_decode("DAVIVIENDA: "), 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 20, '', 0);
            $pdf->Cell(15, 20, utf8_decode("Cuenta corriente No. 126269998426"), 0);

            $pdf->Ln(8);
            $pdf->SetFont('Arial', 'U', 9);
            $pdf->Cell(2, 10, '', 0);
            $pdf->Cell(15, 25, utf8_decode("A NOMBRE DE MUEBLES ALBURA SAS NIT 800.009.732-6"), 0);

            $pdf->Ln(15);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(2, 10, '', 0);
            $pdf->Cell(15, 20, utf8_decode("Interés de plazo: " . $tasa_plazo . " %"), 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 20, '', 0);
            $pdf->Cell(15, 20, utf8_decode("* Interés de mora: " . $tasa_mora . " %"), 0);

            $pdf->Ln(6);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(2, 10, '', 0);
            $pdf->Cell(15, 20, utf8_decode("* Tasa máxima legal vigente certificada por la superintendencia financiera de Colombia."), 0);
        }

        return $pdf;
    }
}
