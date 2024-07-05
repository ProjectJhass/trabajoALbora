<?php

namespace App\Http\Controllers\apps\cotizador_pruebas;

use App\Http\Controllers\Controller;
use App\Models\apps\cotizador\ModelInfoSucursales;
use App\Models\apps\cotizador_pruebas\ModelCotizacionesRealizadas;
use App\Models\apps\cotizador_pruebas\ModelInfoClientesCRM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return ModelCotizacionesRealizadas::where('idsession', $id_sesion)->get();
    }

    public function GenerarPdfCotizacion($id_cliente)
    {
        $pdf = $this->GenerarPdfCotizacionP($id_cliente);
        $pdf->Output('COTIZACION_VENTA_' . $id_cliente . '_MUEBLES_ALBURA_SAS.pdf', 'i');
        exit;
    }

    public function GenerarPdfCotizacionP($id_cliente)
    {
        $vigencia = date("Y-m-d", strtotime(date('Y-m-d') . "+ 8 days"));
        $productos = self::obtenerProductosCotizados(session('IdSession'));
        $cliente = ModelInfoClientesCRM::find($id_cliente);

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
        $pdf->Cell(15, 8, "No - " . $id_cliente, 0);
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
        $pdf->Cell(15, 8, $cliente->cedula_cliente, 0);

        $pdf->Cell(15, 8, utf8_decode(""), 0);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Nombre del Cliente  "), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode($cliente->nombre_1), 0);

        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, utf8_decode("Apellidos   "), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 20, '', 0);
        $pdf->Cell(15, 10, utf8_decode($cliente->apellido_1), 0);

        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, utf8_decode("Dirección "), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 20, '', 0);
        $pdf->Cell(15, 10, utf8_decode($cliente->direccion), 0);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(45, 10, '', 0);
        $pdf->Cell(15, 10, utf8_decode("Barrio - Ciudad"), 0);

        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(15, 10, utf8_decode($cliente->barrio . " " . $cliente->ciudad), 0);


        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 11, utf8_decode("Teléfonos"), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 20, '', 0);
        $pdf->Cell(15, 11, utf8_decode($cliente->celular_1), 0);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(45, 10, '', 0);
        $pdf->Cell(15, 11, utf8_decode("Email"), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(15, 11, utf8_decode($cliente->email), 0);

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
        $valor_antes = ($neto / 1.19);
        /* Descuento (-) */
        $vlr_descuento_ = $valor_antes * ((($val_desc * 100) / $neto) / 100);

        /* Valor venta antes de IVA */
        $vlr_venta_antes_iva = ($valor_antes - $vlr_descuento_);
        /* IVA */
        $vlr_iva = ($vlr_venta_antes_iva * 0.19);
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
        $pdf->Cell(15, 18, number_format($vlr_total_venta), 0);

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
        $pdf->Cell(15, 21, utf8_decode(str_replace("CON 00/100 ", "", $valor_letras) . " MCTE"), 0);

        $pdf->Ln(1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 22, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 24, utf8_decode("800.009.732-6 Muebles Albura SAS"), 0);

        return $pdf;
    }
}
