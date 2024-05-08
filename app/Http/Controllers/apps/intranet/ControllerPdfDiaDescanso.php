<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelFirmasDescansosCompensatorios;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;

class PDF extends FPDF
{
    /*  function Footer()
    {
        $this->SetY(-10);
        $this->SetFont('Arial', '', 5);
        $this->Cell(0, 10, ("Plataforma Intranet Albura - 800.009.732-6 Muebles Albura S.A.S / " . date("Y-m-d H:i:s")), 0, 0, 'R');
    } */
}

class ControllerPdfDiaDescanso extends Controller
{
    public function generarPdfCertificado($id)
    {
        $info_user = ModelFirmasDescansosCompensatorios::find($id);

        $fecha = Carbon::createFromFormat('Y-m-d', date("Y-m-d"));
        $fechaFormateada = $fecha->isoFormat('DD [de] MMMM [del] YYYY');
        $fechaFormmat = $fecha->isoFormat('DD [días del mes de] MMMM [del] YYYY');

        $fecha_compensatorio = 'N/A';
        $fecha_dominical = 'N/A';

        if (!empty($info_user->dia_compensatorio)) {
            $fecha_compensatorio = Carbon::createFromFormat('Y-m-d', $info_user->dia_compensatorio);
            $fecha_compensatorio = $fecha_compensatorio->isoFormat('DD [de] MMMM [del] YYYY');
        }
        if (!empty($info_user->dominical_laborado)) {
            $fecha_dominical = Carbon::createFromFormat('Y-m-d', $info_user->dominical_laborado);
            $fecha_dominical = $fecha_dominical->isoFormat('DD [de] MMMM [del] YYYY');
        }




        $pdf = new PDF('P', 'mm', 'Letter');
        $pdf->AddPage();
        /* $pdf->Image(public_path("img/blanco.png"), 15, 10, 70, 0, 'PNG'); */
        $pdf->Image(public_path("img/fondo_cartas.jpg"), 0, 0, 215, 0, 'JPG');
        $pdf->Ln(20);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(200, 13, utf8_decode("CERTIFICADO DE DÍA DE DESCANSO COMPENSATORIO"), 0, 0, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 20, '', 0);
        $pdf->Cell(10, 13, ("Dosquebradas Risaralda, " . $fechaFormateada), 0);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 20, '', 0);
        $pdf->Cell(10, 13, ("HACE CONSTAR QUE:"), 0);
        $pdf->Ln(15);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode("El (La) Sr(a). " . $info_user->nombre . " identificado(a) con cédula de ciudadanía N° " . $info_user->cedula . ", por la jornada de domingo trabajada, ha cumplido exitosamente con el día de descanso compensatorio el día " . $fecha_compensatorio . "."), 0, 'J');
        $pdf->Ln(1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 8, ("Y, el siguiente informe detallado:"), 0, 'J');

        $pdf->Ln(1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 13, "Centro de experiencia:", 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 10, '', 0);
        $pdf->Cell(10, 13, $info_user->almacen, 0);
        $pdf->Ln(7);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 13, "Ciudad:", 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 10, '', 0);
        $pdf->Cell(10, 13, $info_user->ciudad . " - " . $info_user->depto, 0);
        $pdf->Ln(7);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 13, "Dominical laborado:", 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 10, '', 0);
        $pdf->Cell(10, 13, $fecha_dominical, 0);
        $pdf->Ln(7);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 13, utf8_decode("Día compensatorio:"), 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 10, '', 0);
        $pdf->Cell(10, 13, $fecha_compensatorio, 0);
        $pdf->Ln(14);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 6, utf8_decode("Esta elección del trabajador se llevó a cabo de acuerdo con las políticas y procedimientos establecidos por la empresa Muebles Albura SAS, conforme a la normativa laboral. Evidencia fotográfica para constancia de firma y aceptación por parte del empleado."), 0, 'J');
        $pdf->Ln(1);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(95, 50, $pdf->Image(public_path($info_user->url_firma), 78, 145, 70), 0);
        $pdf->Ln(65);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 20, '', 0);
        $pdf->MultiCell(0, 5, utf8_decode("Para constancia, se expide digitalmente el presente certificado en Dosquebradas Risaralda a los " . $fechaFormmat . " desde la plataforma Intranet Albura."), 0, 'J');
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 13, "IP Cliente:", 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(10, 13, $info_user->ip, 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 13, "Fecha registro:", 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(10, 13, $info_user->created_at, 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 13, "Nombre de la foto:", 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(10, 13, utf8_decode($info_user->nombre_firma), 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 13, utf8_decode("Tamaño de la foto:"), 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(10, 13, filesize(public_path($info_user->url_firma)) . " bytes", 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 10, '', 0);
        $pdf->Cell(10, 13, "Formato de la foto:", 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(10, 13, 'image/png', 0);
        $pdf->Output();

        // return $pdf;
    }
}
