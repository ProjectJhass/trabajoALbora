<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios;

use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use App\Models\apps\servicios_tecnicos\servicios\ModelRespuestaFab;
use App\Models\apps\servicios_tecnicos\servicios\ModelValoracionFab;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ControllerFormatosPdf extends Controller
{
    public function GenerarPdfOrdenServicioTec(Request $request)
    {
        $id_st = $request->id_st;
        $info = ModelNuevaSolicitud::where('id_st', $id_st)->get();
        $collect_valoracion = ModelValoracionFab::where('estado', '1')->where('id_st', $id_st)->get();
        $info_val = $collect_valoracion->first();

        $pdf = self::generatePdfOrdenServicio($info, $info_val);
        $pdf->Output('OST ' . $id_st . ' - CARTA_ORDEN_DE_SERVICIO_TECNICO.pdf', 'i');
        exit;
    }

    public function printFormatoRespuesta(Request $request)
    {
        $id_st = $request->id_st;

        $pdf = self::FormatoRespuesta($id_st);
        $pdf->Output('OST ' . $id_st . ' - CARTA_RESPUESTA_OST.pdf', 'i');
        exit;
    }

    public function FormatoRespuesta($id_st)
    {
        $data = ModelNuevaSolicitud::find($id_st);

        switch ($data->respuesta_st) {
            case 'Garantia':
                $pdf = self::cartaGarantia($data);
                break;
            case 'No garantia':
                $pdf = self::cartaNogarantia($data);
                break;
            case 'Liberalidad de la empresa':
                $pdf = self::cartaLiberalidad($data);
                break;
            case 'Cobrable':
                $pdf = self::cartaServicioCobrable($data);
                break;
            case 'No garantia por tiempo':
                $pdf = self::cartaServicioGarantiaTiempo($data);
                break;

            default:
                return redirect()->back()->withInput()->withErrors(['error' => 'La OST no está en el estado requerido']);
                break;
        }

        return $pdf;
    }

    public function cartaGarantia($data)
    {
        $value = $data;
        $carta_ = ModelRespuestaFab::where('id_st', $value->id_st)->where('estado', '1')->get();
        $info_c = $carta_->first();

        $fechaActual = date('Y-m-d');
        $fechaCarbon = Carbon::parse($fechaActual);
        Carbon::setLocale('es');
        $fechaFormateada = $fechaCarbon->isoFormat('LL');

        $pdf = new FPDF();

        $pdf->AddPage();

        $pdf->Image(public_path('logo/img_log_rojo.png'), 20, 10, 52, 0, 'PNG');
        $pdf->Ln(20);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode("Dosquebradas / Risaralda,  " . $fechaFormateada), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode("Señor(a):"), 0);

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode($value->nombre), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode("CC: " . $value->cedula), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode("Almacén : " . $value->almacen), 0);
        $pdf->Ln(13);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(59, 10, '', 0);
        $pdf->Cell(10, 10, utf8_decode("Respuesta al servicio técnico"), 0);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(90, 10, '', 0);
        $pdf->Cell(10, 10, utf8_decode("garantía por defecto de fábrica"), 0, 0, 'C');
        $pdf->Ln(13);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 5, utf8_decode($value->nombre . " en nombre de Muebles Albura SAS y todo nuestro equipo de trabajo estamos atentos a resolver cualquier problema que se haya presentado con uno de nuestros productos."), 0, 'J');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode("Para Muebles Albura SAS el profesionalismo define nuestra forma de trabajo, es por eso que todos nuestros procesos confiables se encuentran regulados por la norma ISO 9001-2015 supervisado por Bureau Veritas con el número de certificación CO 23.08088 versión No. 1, revisado el 29 de diciembre 2023."), 0, 'J');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 5, utf8_decode("Orden de servicio, N°:"), 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(35, 10, '', 0);
        $pdf->Cell(10, 5, $value->id_st, 0);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 4, utf8_decode("Producto:"), 0);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(35, 10, '', 0);
        $pdf->Cell(10, 4, utf8_decode($value->articulo), 0);
        $pdf->Ln(9);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode("En su caso, se ha determinado que los defectos si se produjeron en fábrica. Por parte del equipo de calidad lamentamos lo ocurrido y tomaremos los siguientes correctivos:"), 0, 'J');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("Diagnóstico: "), 0);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode($info_c->diagnostico), 0, 'J');
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("Solución: "), 0);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 10, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode($info_c->solucion), 0, 'J');

        $pdf->Ln(4);
        $pdf->Cell(11, 5, '', 0);
        $pdf->Cell(95, 5, $pdf->Image(public_path('firmas/smr_firma.png'), $pdf->GetX(), $pdf->GetY() + 13, 50), 0);
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 40, utf8_decode("Atentamente. "), 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 40, utf8_decode("Stefannia Marín R. "), 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 40, utf8_decode("Coordinadora SGC Muebles Albura SAS. "), 0);
        $pdf->Ln(20);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("_________________________________________________________________________ "), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 23, '', 0);
        $pdf->Cell(95, 15, utf8_decode("mueblesalbura.com.co "), 0);

        return $pdf;
    }

    public function cartaNogarantia($data)
    {
        $value = $data;
        $carta_ = ModelRespuestaFab::where('id_st', $value->id_st)->where('estado', '1')->get();
        $info_c = $carta_->first();

        $fechaActual = date('Y-m-d');
        $fechaCarbon = Carbon::parse($fechaActual);
        Carbon::setLocale('es');
        $fechaFormateada = $fechaCarbon->isoFormat('LL');

        $pdf = new FPDF();
        $pdf->AddPage();

        $pdf->Image(public_path('logo/img_log_rojo.png'), 20, 10, 40, 0, 'PNG');
        $pdf->Ln(20);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode("Dosquebradas / Risaralda,  " . $fechaFormateada), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 12, '', 0);
        $pdf->Cell(65, 8, utf8_decode("Señor(a):"), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 12, '', 0);
        $pdf->Cell(65, 8, utf8_decode($value->nombre), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 12, '', 0);
        $pdf->Cell(65, 8, utf8_decode("CC: " . $value->cedula), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 12, '', 0);
        $pdf->Cell(65, 8, utf8_decode("Almacén : " . $value->almacen), 0);
        $pdf->Ln(13);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(62, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("Respuesta al servicio técnico"), 0);
        $pdf->Ln(13);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 5, utf8_decode($value->nombre . " en nombre de Muebles Albura SAS y todo nuestro equipo de trabajo estamos atentos a resolver cualquier problema que se haya presentado con uno de nuestros productos."), 0, 'J');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode("Para Muebles Albura SAS el profesionalismo define nuestra forma de trabajo, es por eso que todos nuestros procesos confiables se encuentran regulados por la norma ISO 9001-2015 supervisado por Bureau Veritas con el número de certificación CO 23.08088 versión No. 1, revisado el 29 de diciembre 2023."), 0, 'J');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 5, utf8_decode("Orden de servicio, N°:"), 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(35, 10, '', 0);
        $pdf->Cell(10, 5, $value->id_st, 0);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 4, utf8_decode("Producto:"), 0);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(35, 10, '', 0);
        $pdf->Cell(10, 4, utf8_decode($value->articulo), 0);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode("Hemos investigado la razón de la causa del servicio técnico del producto " . $value->articulo . " bajo las normas de calidad y los estándares del Bureau Veritas y se determinó que la solicitud no cumple los requisitos para garantía."), 0, 'J');
        $pdf->Ln(2);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("A continuación la descripción del problema técnico:"), 0);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("Diagnóstico: "), 0);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode($info_c->diagnostico), 0, 'J');
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("Solución: "), 0);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 10, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode($info_c->solucion), 0, 'J');
        $pdf->Ln(4);
        $pdf->Cell(11, 5, '', 0);
        $pdf->Cell(10, 5, $pdf->Image(public_path('firmas/smr_firma.png'), $pdf->GetX(), $pdf->GetY() + 13, 50), 0);
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 40, utf8_decode("Atentamente. "), 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 40, utf8_decode("Stefannia Marín R. "), 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 40, utf8_decode("Coordinadora SGC Muebles Albura SAS. "), 0);
        $pdf->Ln(20);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("_________________________________________________________________________ "), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 23, '', 0);
        $pdf->Cell(95, 15, utf8_decode("mueblesalbura.com.co "), 0);

        return $pdf;
    }

    public function cartaLiberalidad($data)
    {
        $value = $data;
        $carta_ = ModelRespuestaFab::where('id_st', $value->id_st)->where('estado', '1')->get();
        $info_c = $carta_->first();

        $fechaActual = date('Y-m-d');
        $fechaCarbon = Carbon::parse($fechaActual);
        Carbon::setLocale('es');
        $fechaFormateada = $fechaCarbon->isoFormat('LL');

        $pdf = new FPDF();
        $pdf->AddPage();

        $pdf->Image(public_path('logo/img_log_rojo.png'), 20, 10, 40, 0, 'PNG');
        $pdf->Ln(20);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode("Dosquebradas / Risaralda,  " . $fechaFormateada), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode("Señor(a):"), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode($value->nombre), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode("CC: " . $value->cedula), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode("Almacén : " . $value->almacen), 0);
        $pdf->Ln(12);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(62, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("Respuesta al servicio técnico"), 0);
        $pdf->Ln(13);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 5, utf8_decode($value->nombre . " en nombre de Muebles Albura SAS y todo nuestro equipo de trabajo estamos atentos a resolver cualquier problema que se haya presentado con uno de nuestros productos."), 0, 'J');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode("Para Muebles Albura SAS el profesionalismo define nuestra forma de trabajo, es por eso que todos nuestros procesos confiables se encuentran regulados por la norma ISO 9001-2015 supervisado por Bureau Veritas con el número de certificación CO 23.08088 versión No. 1, revisado el 29 de diciembre 2023."), 0, 'J');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 5, utf8_decode("Orden de servicio, N°:"), 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(35, 10, '', 0);
        $pdf->Cell(10, 5, $value->id_st, 0);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 4, utf8_decode("Producto:"), 0);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(35, 10, '', 0);
        $pdf->Cell(10, 4, utf8_decode($value->articulo), 0);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode("Hemos investigado la razón de la causa del servicio técnico del producto " . $value->articulo . " bajo las normas de calidad y los estándares del Bureau Veritas y por liberalidad de la empresa se decidió tomar como garantía el servicio técnico."), 0, 'J');
        $pdf->Ln(2);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("A continuación la descripción del problema técnico:"), 0);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("Diagnóstico: "), 0);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode($info_c->diagnostico), 0, 'J');
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("Solución: "), 0);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 10, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode($info_c->solucion), 0, 'J');
        $pdf->Ln(4);
        $pdf->Cell(11, 5, '', 0);
        $pdf->Cell(95, 5, $pdf->Image(public_path('firmas/smr_firma.png'), $pdf->GetX(), $pdf->GetY() + 13, 50), 0);
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 40, utf8_decode("Atentamente. "), 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 40, utf8_decode("Stefannia Marín R. "), 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 40, utf8_decode("Coordinadora SGC Muebles Albura SAS. "), 0);
        $pdf->Ln(20);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("_________________________________________________________________________ "), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 23, '', 0);
        $pdf->Cell(95, 15, utf8_decode("mueblesalbura.com.co "), 0);

        return $pdf;
    }

    public function generatePdfOrdenServicio($info, $res_fab)
    {
        $dat = $info->first();

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Image(public_path('logo/img_log_rojo.png'), 20, 10, 40, 0, 'PNG');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(50, 10, '', 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("SOLICITUD DE SERVICIO TÉCNICO"), 0);
        $pdf->Ln(8);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(50, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("**" . $dat->almacen . "**"), 0);
        $pdf->Cell(30, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Fecha : " . date('Y-m-d', strtotime($dat->created_at))), 0);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(30, 10, '', 0);
        $pdf->Cell(30, 10, utf8_decode("No ST: " . $dat->id_st), 0);
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(50, 10, '', 0);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode("DATOS GENERALES DEL CLIENTE "), 1);
        $pdf->Ln(7);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Cedula del Cliente  "), 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 20, '', 0);
        $pdf->Cell(15, 8, ($dat->cedula), 0);
        $pdf->Cell(15, 8, utf8_decode(""), 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Nombre del Cliente  "), 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode($dat->nombre), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Dirección: "), 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode($dat->direccion . " " . $dat->barrio . " " . $dat->ciudad), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Télefonos"), 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 20, '', 0);
        $pdf->Cell(15, 8, ($dat->celular), 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(25, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Correo Electrónico "), 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 8, ($dat->email), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Factura Venta"), 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 20, '', 0);
        $pdf->Cell(15, 8, ($dat->factura), 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(8, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Fecha"), 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(1, 10, '', 0);
        $pdf->Cell(15, 8, ($dat->fecha_factura), 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(8, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Remisión  :"), 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode($dat->remision . " - " . $dat->fecha_remision), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Proveedor"), 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 20, '', 0);
        $pdf->Cell(15, 8, utf8_decode($dat->proveedor), 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(25, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Forma de Pago "), 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode($dat->forma_pago), 0);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("DETALLE DEL ARTICULO PARA SERVICIO TÉCNICO"), 1);
        $pdf->Ln(9);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(10, 8, utf8_decode("Item:"), 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(5, 10, '', 0);
        $pdf->Cell(10, 8, utf8_decode($dat->articulo), 0);
        $pdf->Ln(7);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Daño Reportado:"), 0);
        $pdf->Ln(1);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(45, 20, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode($dat->inconveniente), 0, 'L');
        $pdf->Ln(1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(10, 8, utf8_decode("Causales del Servicio:"), 0);
        $pdf->Ln(1);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(55, 22, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode($dat->causales), 0, 'L');
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(65, 10, '', 0);
        $pdf->Cell(75, 8, utf8_decode("INSPECCIÓN Y RECOGIDA DEL SERVICIO  "), 1, 0, 'C');
        $pdf->Ln(12);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(100, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Fecha de Recogida: ______ / ______ / ______"), 0);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(10, 8, utf8_decode("Estado del Articulo: "), 0);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(10, 8, utf8_decode("[   ] PELADO - [   ] RAYADO - [   ] TALLADO - [   ] SUCIO - [   ] MANCHADO - [   ] OTRO"), 0);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(10, 8, utf8_decode("_________________________________________________________________________________________ "), 0);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(10, 8, utf8_decode("Elementos Recogidos: "), 0);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(10, 8, utf8_decode("_________________________________________________________________________________________ "), 0);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(10, 8, utf8_decode("Observaciones Generales: "), 0);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(10, 8, utf8_decode("_________________________________________________________________________________________ "), 0);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(10, 8, utf8_decode("_________________________________________________________________________________________ "), 0);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(10, 8, utf8_decode("Acción Correctiva:"), 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(30, 20, '', 0);
        $pdf->Cell(10, 7, utf8_decode("[ X ] " . $dat->respuesta_st), 0);
        $pdf->Ln(15);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(10, 8, utf8_decode("Entrega al cliente en señal de recibido a conformidad del producto "), 0);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(15, 10, '', 0);
        $pdf->MultiCell(0, 4, utf8_decode('Conforme mi solicitud, estoy informado y doy el consentimiento para que recojan el producto señalado anteriormente, aceptando con esto de manera expresa mi obligación respecto a la recepción del producto, la firma de los documentos de entrega y los soportes del procedimiento adelantado conforme la Ley 1480 de 2011. Más información en mueblesalbura.com.co'), 0, 'J');
        $pdf->Ln(8);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(10, 8, "Firma____________________________________           Fecha:_______________/ ______ / ______ ", 0);
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(75, 10, '', 0);
        $pdf->Cell(55, 8, utf8_decode("CONCEPTO DE FÁBRICA"), 1, 0, 'C');
        $pdf->Ln(15);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(10, 10, utf8_decode("Concepto:"), 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(25, 10, '', 0);

        $concepto_ = isset($res_fab->concepto) ? $res_fab->concepto : "SIN DEFINIR";
        $pdf->Cell(10, 10, utf8_decode("** " . strtoupper($concepto_) . " **"), 0);

        $pdf->Ln(7);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Observaciones:"), 0);
        $pdf->Ln(1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 20, '', 0);

        $obs = isset($res_fab->observaciones) ? $res_fab->observaciones : "NO SE HA REALIZADO LA VALORACIÓN POR PARTE DE FÁBRICA";

        $pdf->MultiCell(0, 6, utf8_decode($obs), 0, 'J');
        $pdf->Ln(1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, '', 0);
        $pdf->Cell(10, 6, utf8_decode("Responsable:"), 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(25, 10, '', 0);

        $responsable = isset($res_fab->responsable) ? $res_fab->responsable : "N/A";

        $pdf->Cell(10, 6, utf8_decode(strtoupper($responsable)), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, '', 0);

        $fecha_ = isset($res_fab->created_at) ? $res_fab->created_at : "Sin valoración";

        $pdf->Cell(10, 10, utf8_decode("Fecha:"), 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(25, 10, '', 0);
        $pdf->Cell(10, 10, utf8_decode($fecha_), 0);

        return $pdf;
    }

    public function cartaServicioCobrable($data)
    {
        $value = $data;
        $carta_ = ModelRespuestaFab::where('id_st', $value->id_st)->where('estado', '1')->get();
        $info_c = $carta_->first();

        $fechaActual = date('Y-m-d');
        $fechaCarbon = Carbon::parse($fechaActual);
        Carbon::setLocale('es');
        $fechaFormateada = $fechaCarbon->isoFormat('LL');

        $pdf = new FPDF();

        $pdf->AddPage();

        $pdf->Image(public_path('logo/img_log_rojo.png'), 20, 10, 52, 0, 'PNG');
        $pdf->Ln(20);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode("Dosquebradas / Risaralda,  " . $fechaFormateada), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode("Señor(a):"), 0);

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode($value->nombre), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode("CC: " . $value->cedula), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode("Almacén : " . $value->almacen), 0);
        $pdf->Ln(13);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(59, 10, '', 0);
        $pdf->Cell(10, 10, utf8_decode("Respuesta al servicio técnico"), 0);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(90, 10, '', 0);
        $pdf->Cell(10, 10, utf8_decode("servicio cobrable"), 0, 0, 'C');
        $pdf->Ln(13);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 5, utf8_decode($value->nombre . " en nombre de Muebles Albura SAS y todo nuestro equipo de trabajo estamos atentos a resolver cualquier problema que se haya presentado con uno de nuestros productos."), 0, 'J');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode("Para Muebles Albura SAS el profesionalismo define nuestra forma de trabajo, es por eso que todos nuestros procesos confiables se encuentran regulados por la norma ISO 9001-2015 supervisado por Bureau Veritas con el número de certificación CO 23.08088 versión No. 1, revisado el 29 de diciembre 2023."), 0, 'J');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 5, utf8_decode("Orden de servicio, N°:"), 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(35, 10, '', 0);
        $pdf->Cell(10, 5, $value->id_st, 0);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 4, utf8_decode("Producto:"), 0);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(35, 10, '', 0);
        $pdf->Cell(10, 4, utf8_decode($value->articulo), 0);

        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("Diagnóstico: "), 0);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode($info_c->diagnostico), 0, 'J');
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("Solución: "), 0);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 10, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode($info_c->solucion), 0, 'J');

        $pdf->Ln(4);
        $pdf->Cell(11, 5, '', 0);
        $pdf->Cell(95, 5, $pdf->Image(public_path('firmas/smr_firma.png'), $pdf->GetX(), $pdf->GetY() + 13, 50), 0);
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 40, utf8_decode("Atentamente. "), 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 40, utf8_decode("Stefannia Marín R. "), 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 40, utf8_decode("Coordinadora SGC Muebles Albura SAS. "), 0);
        $pdf->Ln(20);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("_________________________________________________________________________ "), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 23, '', 0);
        $pdf->Cell(95, 15, utf8_decode("mueblesalbura.com.co "), 0);

        return $pdf;
    }

    public function cartaServicioGarantiaTiempo($data)
    {
        $value = $data;
        $carta_ = ModelRespuestaFab::where('id_st', $value->id_st)->where('estado', '1')->get();
        $info_c = $carta_->first();

        $fechaActual = date('Y-m-d');
        $fechaCarbon = Carbon::parse($fechaActual);
        Carbon::setLocale('es');
        $fechaFormateada = $fechaCarbon->isoFormat('LL');

        $pdf = new FPDF();
        $pdf->AddPage();

        $pdf->Image(public_path('logo/img_log_rojo.png'), 20, 10, 40, 0, 'PNG');
        $pdf->Ln(20);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode("Dosquebradas / Risaralda,  " . $fechaFormateada), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode("Señor(a):"), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode($value->nombre), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode("CC: " . $value->cedula), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(65, 8, utf8_decode("Almacén : " . $value->almacen), 0);
        $pdf->Ln(12);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(62, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("Respuesta al servicio técnico"), 0);
        $pdf->Ln(13);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 5, utf8_decode($value->nombre . " en nombre de Muebles Albura SAS y todo nuestro equipo de trabajo estamos atentos a resolver cualquier problema que se haya presentado con uno de nuestros productos."), 0, 'J');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode("Para Muebles Albura SAS el profesionalismo define nuestra forma de trabajo, es por eso que todos nuestros procesos confiables se encuentran regulados por la norma ISO 9001-2015 supervisado por Bureau Veritas con el número de certificación CO 23.08088 versión No. 1, revisado el 29 de diciembre 2023."), 0, 'J');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 5, utf8_decode("Orden de servicio, N°:"), 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(35, 10, '', 0);
        $pdf->Cell(10, 5, $value->id_st, 0);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 4, utf8_decode("Producto:"), 0);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(35, 10, '', 0);
        $pdf->Cell(10, 4, utf8_decode($value->articulo), 0);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode("Hemos investigado la razón de la causa del servicio técnico del producto " . $value->articulo . " bajo las normas de calidad y los estándares del Bureau Veritas y se determinó que el producto no está dentro del tiempo de garantía."), 0, 'J');
        $pdf->Ln(2);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("A continuación la descripción del problema técnico:"), 0);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("Diagnóstico: "), 0);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode($info_c->diagnostico), 0, 'J');
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("Solución: "), 0);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 10, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode($info_c->solucion), 0, 'J');
        $pdf->Ln(4);
        $pdf->Cell(11, 5, '', 0);
        $pdf->Cell(95, 5, $pdf->Image(public_path('firmas/smr_firma.png'), $pdf->GetX(), $pdf->GetY() + 13, 50), 0);
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 40, utf8_decode("Atentamente. "), 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 40, utf8_decode("Stefannia Marín R. "), 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 40, utf8_decode("Coordinadora SGC Muebles Albura SAS. "), 0);
        $pdf->Ln(20);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(95, 8, utf8_decode("_________________________________________________________________________ "), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 23, '', 0);
        $pdf->Cell(95, 15, utf8_decode("mueblesalbura.com.co "), 0);

        return $pdf;
    }
}
