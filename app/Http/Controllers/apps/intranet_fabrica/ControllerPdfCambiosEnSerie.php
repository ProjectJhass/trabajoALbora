<?php

namespace App\Http\Controllers\apps\intranet_fabrica;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet_fabrica\ModelCambiosEnSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\apps\intranet_fabrica\pdf\tablePdf as pdf;

class ControllerPdfCambiosEnSerie extends Controller
{
  
    protected static function ObtenerSeccion($id)
    {
        switch ($id) {
            case '1':
                $seccion = 'MÁQUINAS';
                break;
            case '2':
                $seccion = 'ENSAMBLE';
                break;
            case '3':
                $seccion = 'LIJA';
                break;
            case '4':
                $seccion = 'PINTURA';
                break;
            case '5':
                $seccion = 'EMPAQUE';
                break;
            case '6':
                $seccion = 'TAPICERIA';
                break;
            case '7':
                $seccion = 'DISEÑO';
                break;
            case '8':
                $seccion = 'PRODUCCIÓN';
                break;
        }
        return $seccion;
    }
    public function GenerarPDF($id)
    {
        $data = ModelCambiosEnSeries::ObtenerReporteCambio($id);
        $imagenes = ModelCambiosEnSeries::ObtenerImagenesReporte($id);
        $seccion = ModelCambiosEnSeries::ObtenerCambiosSeccion($id);

        $n = 0;

        $pdf = new pdf;
        $fecha = date('d-m-Y');

        $pdf->AddPage();
        $pdf->Image('img/BLANCO.png', 20, 10, 55, 14, 'PNG');
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(48, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode(" "), 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(35, 10, '', 0);
        $pdf->MultiCell(0, 7, utf8_decode("REPORTE Y ANÁLISIS DE CAMBIOS EN SERIE"), 0, 'C');
        $pdf->Ln(1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(10, 14, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);
        $pdf->Ln(7);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(30, 10, '', 0);
        $pdf->Cell(15, 13, utf8_decode("CÓDIGO: RG-PRD-03"), 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(45, 20, '', 0);
        $pdf->Cell(15, 13, utf8_decode("VERSIÓN: 04"), 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(35, 10, '', 0);
        $pdf->Cell(15, 13, utf8_decode("PÁGINA: 1"), 0);

        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);
        $pdf->Ln(11);
        $pdf->SetFont('Arial', 'U', 11);
        $pdf->Cell(2, 14, '', 0);
        $pdf->Cell(15, 8, utf8_decode("IDENTIFICACIÓN "), 0);

        foreach ($data as $key => $value) {

            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(10, 10, '', 0);
            $pdf->Cell(15, 8, utf8_decode("PRODUCTO / SERIE: "), 0);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(25, 20, '', 0);
            $pdf->Cell(15, 8, utf8_decode($value->producto), 0);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(30, 10, '', 0);
            $pdf->Cell(15, 8, utf8_decode("PIEZA: "), 0);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(10, 10, '', 0);
            $pdf->Cell(15, 8, utf8_decode($value->pieza), 0);

            $pdf->Ln(6);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(10, 10, '', 0);
            $pdf->Cell(15, 10, utf8_decode("OP: "), 0);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(25, 20, '', 0);
            $pdf->Cell(15, 10, utf8_decode($value->op), 0);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(30, 10, '', 0);
            $pdf->Cell(15, 10, utf8_decode("FECHA: "), 0);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(10, 10, '', 0);
            $pdf->Cell(15, 10, $fecha, 0);
            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(2, 10, '', 0);
            $pdf->Cell(15, 14, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);
            $pdf->Ln(7);
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(2, 10, '', 0);
            $pdf->Cell(15, 12, utf8_decode("DESCRIPCIÓN DEL PROBLEMA / SUGERENCIA"), 0);
            $pdf->Ln(4);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(2, 10, '', 0);
            $pdf->Cell(15, 11, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);
            $pdf->Ln(12);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(3, 15, '', 0);
            $pdf->MultiCell(0, 7, utf8_decode($value->problema), 0, '');

            $pdf->Ln(2);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(2, 10, '', 0);
            $pdf->Cell(15, 14, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);
            $pdf->Ln(7);
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(2, 10, '', 0);
            $pdf->Cell(15, 12, utf8_decode("DESCRIPCIÓN DEL CAMBIO / MEJORA"), 0);
            $pdf->Ln(4);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(2, 10, '', 0);
            $pdf->Cell(15, 11, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);
            $pdf->Ln(12);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(3, 15, '', 0);
            $pdf->MultiCell(0, 7, utf8_decode($value->cambio), 0, '');
        }

        if ($value->imagen == 'SI') {
            if (count($imagenes) == 1) {
                foreach ($imagenes as $key => $val) {
                    $pdf->Ln(6);
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->Cell(30, 10, '', 0);
                    $pdf->Image(Storage::path('imagenes-cambios-series/' . $val->nombre_archivo), $pdf->GetX(), $pdf->GetY(), 130, 70);
                }
            } else {
                foreach ($imagenes as $key => $val) {
                    $n++;
                    switch ($n) {
                        case '1':
                            $pdf->Ln(6);
                            $pdf->SetFont('Arial', '', 12);
                            $pdf->Cell(10, 10, '', 0);
                            $pdf->Image(Storage::path('imagenes-cambios-series/' . $val->nombre_archivo), $pdf->GetX(), $pdf->GetY(), 85, 50);
                            break;
                        case '2':
                            $pdf->SetFont('Arial', '', 12);
                            $pdf->Cell(90, 10, '', 0);
                            $pdf->Image(Storage::path('imagenes-cambios-series/' . $val->nombre_archivo), $pdf->GetX(), $pdf->GetY(), 85, 50);
                            break;
                        case '3':
                            $pdf->Ln(55);
                            $pdf->SetFont('Arial', '', 12);
                            $pdf->Cell(10, 10, '', 0);
                            $pdf->Image(Storage::path('imagenes-cambios-series/' . $val->nombre_archivo), $pdf->GetX(), $pdf->GetY(), 85, 50);
                            break;
                        case '4':
                            $pdf->SetFont('Arial', '', 12);
                            $pdf->Cell(90, 10, '', 0);
                            $pdf->Image(Storage::path('imagenes-cambios-series/' . $val->nombre_archivo), $pdf->GetX(), $pdf->GetY(), 85, 50);
                            break;
                    }
                }
            }
        }

        $pdf->Ln($pdf->GetY());
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 14, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);
        $pdf->Ln(7);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 12, utf8_decode("ANÁLISIS DEL CAMBIO POR SECCIÓN"), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 11, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);
        $pdf->Ln(1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 11, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 13, utf8_decode("SECCIÓN"), 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(60, 20, '', 0);
        $pdf->Cell(15, 13, utf8_decode("ACTIVIDAD"), 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(55, 10, '', 0);
        $pdf->Cell(15, 13, utf8_decode("RESPONSABLE"), 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 11, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);
        $pdf->Ln(6);

        foreach ($seccion as $key => $val) {
            $pdf->Ln(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(3, 10, '', 0);
            $pdf->SetWidths(array(48, 80, 20, 40));
            $pdf->Row(array(utf8_decode(self::ObtenerSeccion($val->id_seccion)), utf8_decode($val->actividad), '', utf8_decode($val->responsable)));
            $pdf->Ln(1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(2, 10, '', 0);
            $pdf->Cell(15, 11, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);
        }

        $pdf->Ln(1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(2, 10, '', 0);
        $pdf->Cell(15, 11, utf8_decode("________________________________________________________________________________________________________________________________________"), 0);
        $pdf->Ln(20);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(3, 10, '', 0);
        $pdf->Cell(15, 13, utf8_decode("REVISA: "), 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 20, '', 0);
        $pdf->Cell(15, 13, utf8_decode("APRUEBA: "), 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(55, 10, '', 0);
        $pdf->Cell(15, 13, utf8_decode("FECHA DE APROBACIÓN: "), 0);

        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(3, 10, '', 0);
        $pdf->SetWidths(array(48));
        $pdf->Row(array($pdf->Image(Storage::path('firmas-fabrica/diana.jpg'), $pdf->GetX(), $pdf->GetY(), 0, 14)));

        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(70, 0, '', 0);
        $pdf->SetWidths(array(48));
        $pdf->Row(array($pdf->Image(Storage::path('firmas-fabrica/viviana.jpg'), $pdf->GetX(), $pdf->GetY(), 0, 14)));

        $pdf->SetFont('Arial', 'U', 10);
        $pdf->Cell(150, 0, '', 0);
        $pdf->SetWidths(array(48));
        $pdf->Row(array($fecha));
        $pdf->Ln(1);

        return $pdf;

    }
}
