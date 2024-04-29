<?php

namespace App\Http\Controllers\apps\cotizador;

use App\Http\Controllers\Controller;
use App\Models\apps\cotizador\ModelSueldosIntereses;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;

class ControllerPdfFogade extends Controller
{
    public function GenerarDocumentoFogade()
    {
        session(['DocumentoFogadeSession' => session('IdSession')]);
        $info_saldos = ModelSueldosIntereses::find(1);
        $porcetaje_fianza = $info_saldos->valor_fianza;
        $pdf = self::EstructuraDocumentoFogade($porcetaje_fianza);
        $name = utf8_decode(trim("DOCUMENTO FOGADE " . strtoupper(session('primer_nombre') . " " . session('segundo_nombre') . " " . session('primer_apellido') . " " . session('segundo_apellido'))));
        $pdf->Output($name . ".pdf", "D");
       // exit();
    }

    protected static function EstructuraDocumentoFogade($porcetaje_fianza)
    {
        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->Ln(0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(8, 10, '', 0);
        $pdf->Cell(0, 12, utf8_decode("Anexo"), 0, 0, 'C');
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'U', 11);
        $pdf->Cell(8, 10, '', 0);
        $pdf->Cell(0, 15, utf8_decode('"ACEPTACIÓN DE LAS CONDICIONES Y EL VALOR DE LA FIANZA"'), 0, 0, 'C');

        $pdf->Ln(15);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(8, 10, '', 0);
        $pdf->Cell(0, 15, utf8_decode('Señores'), 0, 0, 'L');
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(8, 10, '', 0);
        $pdf->Cell(0, 19, utf8_decode('MUEBLES ALBURA S.A.S'), 0, 0, 'L');
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(8, 10, '', 0);
        $pdf->Cell(0, 22, utf8_decode('NIT 800.009.732-6'), 0, 0, 'L');


        $pdf->Ln(20);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(8, 10, '', 0);
        $pdf->MultiCell(0, 5, utf8_decode('Mediante el presente documento, informo que durante la explicación de las condiciones del negocio a suscribir entre las partes, me detallaron y me indicaron las condiciones del afianzador.'), 0, "J");


        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(8, 10, '', 0);
        $pdf->MultiCell(0, 5, utf8_decode('Por lo cual, declaro que conozco la totalidad de las estipulaciones de la fianza con el FONDO DE GARANTÍAS Y DESARROLLO S.A.S - FOGADE y acepto su obligatoriedad a la hora de tomar el crédito.'), 0, "J");

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(8, 10, '', 0);
        $pdf->Cell(0, 10, utf8_decode('Y en ese orden, manifiesto expresamente que:'), 0);

        $pdf->Ln(14);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(16, 10, '', 0);
        $pdf->Cell(10, 5, utf8_decode("(i)"), 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(1, 10, '', 0);
        $pdf->MultiCell(0, 5, utf8_decode('Conozco el contenido de la fianza y que mi afianzador es el FONDO DE GARANTÍAS Y DESARROLLO S.A.S - FOGADE.'), 0, "J");

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(16, 10, '', 0);
        $pdf->Cell(10, 5, utf8_decode("(ii)"), 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(1, 10, '', 0);
        $pdf->MultiCell(0, 5, utf8_decode('Reconozco incondicional e irrevocablemente su contenido, así como los derechos allí incorporados a favor de la sociedad MUEBLES ALBURA S.A.S'), 0, "J");

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(16, 10, '', 0);
        $pdf->Cell(10, 5, utf8_decode("(iii)"), 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(1, 10, '', 0);
        $pdf->MultiCell(0, 5, utf8_decode('Soy el único responsable del pago del valor de la fianza más el IVA.'), 0, "J");

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(16, 10, '', 0);
        $pdf->Cell(10, 5, utf8_decode("(iv)"), 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(1, 10, '', 0);
        $pdf->MultiCell(0, 5, utf8_decode('Conozco su valor, el cual se detalla a continuación:'), 0, "J");

        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(27.35, 8, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Comisión"), 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(50, 8, '', 0);
        $pdf->Cell(15, 8, $porcetaje_fianza . " %", 0);

        $pdf->Ln(7);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(27.35, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Valor"), 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(50, 20, '', 0);
        $pdf->Cell(15, 8, ("$ ") . number_format(session('valor_fianza_cotizador')), 0);

        $pdf->Ln(12);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(16, 10, '', 0);
        $pdf->Cell(10, 5, utf8_decode("(v)"), 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(1, 10, '', 0);
        $pdf->MultiCell(0, 5, utf8_decode('Acepto que el pago del valor de la fianza se hará junto con la cuota inicial para que se conceda y se entregue el crédito otorgado por MUEBLES ALBURA S.A.S'), 0, "J");

        $pdf->Ln(7);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(8, 10, '', 0);
        $pdf->Cell(15, 8, utf8_decode("Cordialmente,"), 0);

        $pdf->Ln(24);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(8, 10, '', 0);
        $pdf->Cell(15, 14, utf8_decode("___________________________________________________________________________________________________________________________________"), 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(8, 10, '', 0);
        $pdf->Cell(15, 14, utf8_decode("FIRMA DEL CLIENTE"), 0);


        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(8, 10, '', 0);
        $pdf->Cell(1, 5, utf8_decode("NOMBRE DEL CLIENTE"), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(44, 10, '', 0);
        $pdf->Cell(0, 5, utf8_decode("__________________________________________________________________________________________________"), 0);

        $pdf->Ln(7);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(8, 10, '', 0);
        $pdf->Cell(1, 5, utf8_decode("C.C. No."), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(15, 20, '', 0);
        $pdf->Cell(1, 5, utf8_decode("__________________________________________"), 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(58, 10, '', 0);
        $pdf->Cell(15, 5, utf8_decode("Expedida en"), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(7, 10, '', 0);
        $pdf->Cell(15, 5, utf8_decode("____________________________________________________________"), 0);

        $pdf->Ln(7);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(8, 10, '', 0);
        $pdf->Cell(1, 5, utf8_decode("DIRECCIÓN DE NOTIFICACIÓN"), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(57, 10, '', 0);
        $pdf->Cell(0, 5, utf8_decode("_________________________________________________________________________________________"), 0);

        $pdf->Ln(7);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(8, 10, '', 0);
        $pdf->Cell(1, 5, utf8_decode("TELEFONO"), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(0, 5, utf8_decode("____________________________________________________________________________________________________________________"), 0);



        $pdf->Ln(7);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(8, 10, '', 0);
        $pdf->Cell(1, 5, utf8_decode("Ciudad"), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(15, 20, '', 0);
        $pdf->Cell(56.2, 5, utf8_decode("_______________________________________________________________________,"), 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(43, 10, '', 0);
        $pdf->Cell(1, 5, utf8_decode("día"), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(5, 10, '', 0);
        $pdf->Cell(3, 5, utf8_decode("_______"), 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(8, 10, '', 0);
        $pdf->Cell(1, 5, utf8_decode("mes"), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(7, 10, '', 0);
        $pdf->Cell(4, 5, utf8_decode("__________"), 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(11, 10, '', 0);
        $pdf->Cell(1, 5, utf8_decode("año"), 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(7, 10, '', 0);
        $pdf->Cell(15, 5, utf8_decode("____________"), 0);

        return $pdf;
    } 
}
