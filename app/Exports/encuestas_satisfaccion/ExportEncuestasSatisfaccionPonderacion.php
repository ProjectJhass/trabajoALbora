<?php

namespace App\Exports\encuestas_satisfaccion;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportEncuestasSatisfaccionPonderacion implements FromView, WithStyles
{

    protected $data;
    protected $process;
    protected $preguntas_seccion;
    protected $data_resum_seccion;

    public function __construct($data, $process, $preguntas_seccion, $data_resum_seccion)
    {
        $this->data = $data;
        $this->process = $process;
        $this->preguntas_seccion = $preguntas_seccion;
        $this->data_resum_seccion = $data_resum_seccion;
    }

    public function view(): View
    {
        return view('apps.intranet_fabrica.fabrica.encuesta_satisfaccion.ponderacion.export.exportar', [
            'data_peg' => $this->data,
            'data_pro' => $this->process,
            'data_sec_peg' => $this->preguntas_seccion,
            'data_resum_peg' => $this->data_resum_seccion
        ]);
    }

    public function calcularPonderacion($total_ponderacion, $total_conteo)
    {
        $resultado = round((($total_ponderacion * 100) / $total_conteo), 1);
        return $resultado > 16.6 ? 16.6 : $resultado;
    }

    public function styles(Worksheet $sheet)
    {

        // CONFIGURACIÓN GENERAL //

        $sheet->setShowGridlines(false);
        $sheet->getSheetView()->setZoomScale(80);

        $arr_values_areas = array_values($this->preguntas_seccion);

        $cantidad_preguntas = 1;
        $cantidad_columnas_secciones = 14;
        $cantidad_columnas_secciones_resultados = 14;

        // FIN CONFIGURACIÓN GENERAL //

        $sheet->getStyle('B3')->getFont()->setBold(true);
        $sheet->getStyle('B3')->getFont()->setSize(26);
        $sheet->getStyle('B3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B3')->getAlignment()->setVertical('center');

        // EXCELENTE - PORCENTAJE //

        $sheet->mergeCells('P3:S3');
        $sheet->setCellValue('P3', 'Excelente');
        $sheet->getStyle('P3')->getFont()->setName('Arial');
        $sheet->getStyle('P3')->getFont()->setSize(11);
        $sheet->getStyle('P3:S3')->getFont()->setBold(true);
        $sheet->getStyle('P3:S3')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $sheet->getStyle('P3:S3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('P3:S3')->getFill()->getStartColor()->setARGB('FF90EE90');

        $sheet->mergeCells('T3:V3');
        $sheet->setCellValue('T3', '> 95%');
        $sheet->getStyle('T3:V3')->getFont()->setBold(true);
        $sheet->getStyle('T3:V3')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('T3:V3')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $sheet->getStyle('T3:V3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);

        // FIN EXCELENTE - PORCENTAJE //

        // BUENO - PORCENTAJE //

        $sheet->mergeCells('P4:S4');
        $sheet->setCellValue('P4', 'Bueno');
        $sheet->getStyle('P4')->getFont()->setName('Arial');
        $sheet->getStyle('P4')->getFont()->setSize(11);
        $sheet->getStyle('P4:S4')->getFont()->setBold(true);
        $sheet->getStyle('P4:S4')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $sheet->getStyle('P4:S4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('P4:S4')->getFill()->getStartColor()->setARGB('FFFFFF00');

        $sheet->mergeCells('T4:V4');
        $sheet->setCellValue('T4', '< 95% ; >= 80%');
        $sheet->getStyle('T4:V4')->getFont()->setBold(true);
        $sheet->getStyle('T4:V4')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('T4:V4')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $sheet->getStyle('T4:V4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);

        // FIN BUENO - PORCENTAJE //

        // REGULAR - PORCENTAJE //

        $sheet->mergeCells('P5:S5');
        $sheet->setCellValue('P5', 'Regular');
        $sheet->getStyle('P5')->getFont()->setName('Arial');
        $sheet->getStyle('P5')->getFont()->setSize(11);
        $sheet->getStyle('P5:S5')->getFont()->setBold(true);
        $sheet->getStyle('P5:S5')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $sheet->getStyle('P5:S5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('P5:S5')->getFill()->getStartColor()->setARGB('FFFFA500');

        $sheet->mergeCells('T5:V5');
        $sheet->setCellValue('T5', '< 80% ; >= 70%');
        $sheet->getStyle('T5:V5')->getFont()->setBold(true);
        $sheet->getStyle('T5:V5')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('T5:V5')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $sheet->getStyle('T5:V5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);

        // FIN REGULAR - PORCENTAJE //

        // MALO - PORCENTAJE //

        $sheet->mergeCells('P6:S6');
        $sheet->setCellValue('P6', 'Malo');
        $sheet->getStyle('P6')->getFont()->setName('Arial');
        $sheet->getStyle('P6')->getFont()->setSize(11);
        $sheet->getStyle('P6:S6')->getFont()->setBold(true);
        $sheet->getStyle('P6:S6')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $sheet->getStyle('P6:S6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('P6:S6')->getFill()->getStartColor()->setARGB('FFFF0000');

        $sheet->mergeCells('T6:V6');
        $sheet->setCellValue('T6', '< 70%');
        $sheet->getStyle('T6:V6')->getFont()->setBold(true);
        $sheet->getStyle('T6:V6')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('T6:V6')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $sheet->getStyle('T6:V6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);

        // FIN REGULAR - PORCENTAJE //

        // GENERAL CALIFICACIÓN //

        $sheet->mergeCells('X3:AA4');
        $richTextCalificacion = new RichText();
        $text_bold = $richTextCalificacion->createTextRun('CL: ');
        $text_bold->getFont()->setBold(true);
        $richTextCalificacion->createText('CALIFICACIÓN');
        $sheet->setCellValue('X3', $richTextCalificacion);
        $sheet->getStyle('X3:AA4')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $sheet->getStyle('X3:AA4')->getAlignment()->setVertical('center');

        // FIN GENERAL CALIFIFACION //

        // GENERAL PONDERACIÓN //

        $sheet->mergeCells('X5:AA6');
        $richTextPonderacion = new RichText();
        $text_bold = $richTextPonderacion->createTextRun('PD: ');
        $text_bold->getFont()->setBold(true);
        $richTextPonderacion->createText('PONDERACIÓN');
        $sheet->setCellValue('X5', $richTextPonderacion);
        $sheet->getStyle('X5:AA6')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $sheet->getStyle('X5:AA6')->getAlignment()->setVertical('center');

        // FIN GENERAL PONDERACIÓN //

        // GENERAL DETERMINACIÓN DE RESPUESTAS //

        $sheet->mergeCells('AB3:AH6');
        $sheet->setCellValue('AB3', "S.E: SUPERA LO ESPERADO\nC.E: CUMPLE LO ESPERADO\nN.E: NO CUMPLE CON LO ESPERADO");
        $sheet->getStyle('AB3')->getAlignment()->setWrapText(true);
        $sheet->getStyle('AB3:AH6')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('AB3:AH6')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

        // FIN GENERAL DETERMINACIÓN DE RESPUESTAS //

        // TABLA DE CONTENIDOS DE RESPUESTAS - FACTORES //

        $sheet->mergeCells('B9:M11');
        $sheet->setCellValue('B9', 'FACTORES');
        $sheet->getStyle('B9')->getFont()->setBold(true);
        $sheet->getStyle('B9')->getFont()->setSize(16);
        $sheet->getStyle('B9:M11')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        $sheet->getStyle('B9:M11')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B9:M11')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('B9:M11')->getFill()->getStartColor()->setARGB('FFD9D9D9');

        // ÁREA DE TRABAJO //

        $area_de_trabajo = $arr_values_areas[0] ?? array();
        $fila_inicial_init_area_trabajo = 13;

        $posicion_inicial_area_trabajo = 12;

        $sheet->mergeCells('B' . $posicion_inicial_area_trabajo . ':M' . $posicion_inicial_area_trabajo);
        $sheet->setCellValue('B' . $posicion_inicial_area_trabajo, 'ÁREA DE TRABAJO (16,6%)');
        $sheet->getStyle('B12')->getFont()->setBold(true);
        $sheet->getStyle('B12')->getFont()->setSize(12);
        $sheet->getStyle('B' . $posicion_inicial_area_trabajo . ':M' . $posicion_inicial_area_trabajo)->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B' . $posicion_inicial_area_trabajo . ':M' . $posicion_inicial_area_trabajo)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        $sheet->getStyle('B' . $posicion_inicial_area_trabajo . ':M' . $posicion_inicial_area_trabajo)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('B' . $posicion_inicial_area_trabajo . ':M' . $posicion_inicial_area_trabajo)->getFill()->getStartColor()->setARGB('FFEAEAEA');

        foreach ($area_de_trabajo as $key_adt => $value_adt) {
            $cellNumberQuestion = 'B' . $fila_inicial_init_area_trabajo;

            $cellQuestion = 'C' . $fila_inicial_init_area_trabajo . ':M' . $fila_inicial_init_area_trabajo;
            $cellQuestion_ = 'C' . $fila_inicial_init_area_trabajo;

            $sheet->mergeCells($cellQuestion);
            $sheet->setCellValue($cellQuestion_, strtoupper($key_adt));
            $sheet->getStyle($cellQuestion_)->getFont()->setName('Arial');
            $sheet->getStyle($cellQuestion_)->getFont()->setSize(10);

            $sheet->setCellValue($cellNumberQuestion, $cantidad_preguntas);
            $sheet->getStyle($cellNumberQuestion)->getFont()->setBold(true);
            $sheet->getStyle($cellNumberQuestion)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            $sheet->getStyle($cellQuestion)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            if ($cantidad_preguntas == count($area_de_trabajo)) {
                $sheet->getStyle($cellNumberQuestion)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                $sheet->getStyle($cellQuestion)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            }
            $sheet->getStyle($cellNumberQuestion)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle($cellNumberQuestion)->getFill()->getStartColor()->setARGB('FFEAEAEA');
            $sheet->getStyle($cellNumberQuestion)->getAlignment()->setHorizontal('center')->setVertical('center');
            $fila_inicial_init_area_trabajo++;
            $cantidad_preguntas++;
        }

        // FIN ÁREA DE TRABAJO //

        // COMUNICACIÓN //

        $comunicacion = $arr_values_areas[1] ?? array();
        $fila_inicial_init_comunicacion = 19;

        $posicion_inicial_comunicacion = 18;

        $sheet->mergeCells('B' . $posicion_inicial_comunicacion . ':M' . $posicion_inicial_comunicacion);
        $sheet->setCellValue('B' . $posicion_inicial_comunicacion, 'COMUNICACIÓN (16,6%)');
        $sheet->getStyle('B' . $posicion_inicial_comunicacion)->getFont()->setBold(true);
        $sheet->getStyle('B' . $posicion_inicial_comunicacion)->getFont()->setSize(12);
        $sheet->getStyle('B' . $posicion_inicial_comunicacion . ':M' . $posicion_inicial_comunicacion)->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B' . $posicion_inicial_comunicacion . ':M' . $posicion_inicial_comunicacion)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        $sheet->getStyle('B' . $posicion_inicial_comunicacion . ':M' . $posicion_inicial_comunicacion)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('B' . $posicion_inicial_comunicacion . ':M' . $posicion_inicial_comunicacion)->getFill()->getStartColor()->setARGB('FFEAEAEA');

        foreach ($comunicacion as $key_adt => $value_adt) {
            $cellNumberQuestion = 'B' . $fila_inicial_init_comunicacion;

            $cellQuestion = 'C' . $fila_inicial_init_comunicacion . ':M' . $fila_inicial_init_comunicacion;
            $cellQuestion_ = 'C' . $fila_inicial_init_comunicacion;

            $sheet->mergeCells($cellQuestion);
            $sheet->setCellValue($cellQuestion_, strtoupper($key_adt));
            $sheet->getStyle($cellQuestion_)->getFont()->setName('Arial');
            $sheet->getStyle($cellQuestion_)->getFont()->setSize(10);

            $sheet->setCellValue($cellNumberQuestion, $cantidad_preguntas);
            $sheet->getStyle($cellNumberQuestion)->getFont()->setBold(true);
            $sheet->getStyle($cellNumberQuestion)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            $sheet->getStyle($cellQuestion)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            if ($cantidad_preguntas == (count($comunicacion) + count($area_de_trabajo))) {
                $sheet->getStyle($cellNumberQuestion)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                $sheet->getStyle($cellQuestion)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            }
            $sheet->getStyle($cellNumberQuestion)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle($cellNumberQuestion)->getFill()->getStartColor()->setARGB('FFEAEAEA');
            $sheet->getStyle($cellNumberQuestion)->getAlignment()->setHorizontal('center')->setVertical('center');
            $fila_inicial_init_comunicacion++;
            $cantidad_preguntas++;
        }

        // FIN COMUNICACIÓN //

        // LIDERAZGO //

        $liderazgo = $arr_values_areas[2] ?? array();
        $fila_inicial_init_liderazgo = 25;

        $posicion_inicial_liderazgo = 24;

        $sheet->mergeCells('B' . $posicion_inicial_liderazgo . ':M' . $posicion_inicial_liderazgo);
        $sheet->setCellValue('B' . $posicion_inicial_liderazgo, 'LIDERAZGO (16,6%)');
        $sheet->getStyle('B' . $posicion_inicial_liderazgo)->getFont()->setBold(true);
        $sheet->getStyle('B' . $posicion_inicial_liderazgo)->getFont()->setSize(12);
        $sheet->getStyle('B' . $posicion_inicial_liderazgo . ':M' . $posicion_inicial_liderazgo)->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B' . $posicion_inicial_liderazgo . ':M' . $posicion_inicial_liderazgo)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        $sheet->getStyle('B' . $posicion_inicial_liderazgo . ':M' . $posicion_inicial_liderazgo)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('B' . $posicion_inicial_liderazgo . ':M' . $posicion_inicial_liderazgo)->getFill()->getStartColor()->setARGB('FFEAEAEA');

        foreach ($liderazgo as $key_adt => $value_adt) {
            $cellNumberQuestion = 'B' . $fila_inicial_init_liderazgo;

            $cellQuestion = 'C' . $fila_inicial_init_liderazgo . ':M' . $fila_inicial_init_liderazgo;
            $cellQuestion_ = 'C' . $fila_inicial_init_liderazgo;

            $sheet->mergeCells($cellQuestion);
            $sheet->setCellValue($cellQuestion_, strtoupper($key_adt));
            $sheet->getStyle($cellQuestion_)->getFont()->setName('Arial');
            $sheet->getStyle($cellQuestion_)->getFont()->setSize(10);

            $sheet->setCellValue($cellNumberQuestion, $cantidad_preguntas);
            $sheet->getStyle($cellNumberQuestion)->getFont()->setBold(true);
            $sheet->getStyle($cellNumberQuestion)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            $sheet->getStyle($cellQuestion)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            if ($cantidad_preguntas == (count($liderazgo) + count($comunicacion) + count($area_de_trabajo))) {
                $sheet->getStyle($cellNumberQuestion)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                $sheet->getStyle($cellQuestion)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            }
            $sheet->getStyle($cellNumberQuestion)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle($cellNumberQuestion)->getFill()->getStartColor()->setARGB('FFEAEAEA');
            $sheet->getStyle($cellNumberQuestion)->getAlignment()->setHorizontal('center')->setVertical('center');
            $fila_inicial_init_liderazgo++;
            $cantidad_preguntas++;
        }

        // FIN LIDERAZGO //

        // TRABAJO EN EQUIPO //

        $trabajo_en_equipo = $arr_values_areas[3] ?? array();
        $fila_inicial_init_trabajo_en_equipo = 31;

        $posicion_inicial_trabajo_en_equipo = 30;

        $sheet->mergeCells('B' . $posicion_inicial_trabajo_en_equipo . ':M' . $posicion_inicial_trabajo_en_equipo);
        $sheet->setCellValue('B' . $posicion_inicial_trabajo_en_equipo, 'TRABAJO EN EQUIPO (16,6%)');
        $sheet->getStyle('B' . $posicion_inicial_trabajo_en_equipo)->getFont()->setBold(true);
        $sheet->getStyle('B' . $posicion_inicial_trabajo_en_equipo)->getFont()->setSize(12);
        $sheet->getStyle('B' . $posicion_inicial_trabajo_en_equipo . ':M' . $posicion_inicial_trabajo_en_equipo)->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B' . $posicion_inicial_trabajo_en_equipo . ':M' . $posicion_inicial_trabajo_en_equipo)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        $sheet->getStyle('B' . $posicion_inicial_trabajo_en_equipo . ':M' . $posicion_inicial_trabajo_en_equipo)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('B' . $posicion_inicial_trabajo_en_equipo . ':M' . $posicion_inicial_trabajo_en_equipo)->getFill()->getStartColor()->setARGB('FFEAEAEA');

        foreach ($trabajo_en_equipo as $key_adt => $value_adt) {
            $cellNumberQuestion = 'B' . $fila_inicial_init_trabajo_en_equipo;

            $cellQuestion = 'C' . $fila_inicial_init_trabajo_en_equipo . ':M' . $fila_inicial_init_trabajo_en_equipo;
            $cellQuestion_ = 'C' . $fila_inicial_init_trabajo_en_equipo;

            $sheet->mergeCells($cellQuestion);
            $sheet->setCellValue($cellQuestion_, strtoupper($key_adt));
            $sheet->getStyle($cellQuestion_)->getFont()->setName('Arial');
            $sheet->getStyle($cellQuestion_)->getFont()->setSize(10);

            $sheet->setCellValue($cellNumberQuestion, $cantidad_preguntas);
            $sheet->getStyle($cellNumberQuestion)->getFont()->setBold(true);
            $sheet->getStyle($cellNumberQuestion)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            $sheet->getStyle($cellQuestion)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            if ($cantidad_preguntas == (count($trabajo_en_equipo) + count($liderazgo) + count($comunicacion) + count($area_de_trabajo))) {
                $sheet->getStyle($cellNumberQuestion)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                $sheet->getStyle($cellQuestion)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            }
            $sheet->getStyle($cellNumberQuestion)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle($cellNumberQuestion)->getFill()->getStartColor()->setARGB('FFEAEAEA');
            $sheet->getStyle($cellNumberQuestion)->getAlignment()->setHorizontal('center')->setVertical('center');
            $fila_inicial_init_trabajo_en_equipo++;
            $cantidad_preguntas++;
        }

        // FIN TRABAJO EN EQUIPO //

        // CONDICIONES AMBIENTALES //

        $condiciones_ambientales = $arr_values_areas[4] ?? array();
        $fila_inicial_init_condicionales_ambientales = 37;

        $posicion_inicial_condiciones_ambientales = 36;

        $sheet->mergeCells('B' . $posicion_inicial_condiciones_ambientales . ':M' . $posicion_inicial_condiciones_ambientales);
        $sheet->setCellValue('B' . $posicion_inicial_condiciones_ambientales, 'CONDICIONES AMBIENTALES (16,6%)');
        $sheet->getStyle('B' . $posicion_inicial_condiciones_ambientales)->getFont()->setBold(true);
        $sheet->getStyle('B' . $posicion_inicial_condiciones_ambientales)->getFont()->setSize(12);
        $sheet->getStyle('B' . $posicion_inicial_condiciones_ambientales . ':M' . $posicion_inicial_condiciones_ambientales)->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B' . $posicion_inicial_condiciones_ambientales . ':M' . $posicion_inicial_condiciones_ambientales)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        $sheet->getStyle('B' . $posicion_inicial_condiciones_ambientales . ':M' . $posicion_inicial_condiciones_ambientales)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('B' . $posicion_inicial_condiciones_ambientales . ':M' . $posicion_inicial_condiciones_ambientales)->getFill()->getStartColor()->setARGB('FFEAEAEA');

        foreach ($condiciones_ambientales as $key_adt => $value_adt) {
            $cellNumberQuestion = 'B' . $fila_inicial_init_condicionales_ambientales;

            $cellQuestion = 'C' . $fila_inicial_init_condicionales_ambientales . ':M' . $fila_inicial_init_condicionales_ambientales;
            $cellQuestion_ = 'C' . $fila_inicial_init_condicionales_ambientales;

            $sheet->mergeCells($cellQuestion);
            $sheet->setCellValue($cellQuestion_, strtoupper($key_adt));
            $sheet->getStyle($cellQuestion_)->getFont()->setName('Arial');
            $sheet->getStyle($cellQuestion_)->getFont()->setSize(10);

            $sheet->setCellValue($cellNumberQuestion, $cantidad_preguntas);
            $sheet->getStyle($cellNumberQuestion)->getFont()->setBold(true);
            $sheet->getStyle($cellNumberQuestion)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            $sheet->getStyle($cellQuestion)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            if ($cantidad_preguntas == (count($condiciones_ambientales) + count($trabajo_en_equipo) + count($liderazgo) + count($comunicacion) + count($area_de_trabajo))) {
                $sheet->getStyle($cellNumberQuestion)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                $sheet->getStyle($cellQuestion)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            }
            $sheet->getStyle($cellNumberQuestion)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle($cellNumberQuestion)->getFill()->getStartColor()->setARGB('FFEAEAEA');
            $sheet->getStyle($cellNumberQuestion)->getAlignment()->setHorizontal('center')->setVertical('center');
            $fila_inicial_init_condicionales_ambientales++;
            $cantidad_preguntas++;
        }

        // FIN CONDICIONES AMBIENTALES //

        // MOTIVACIÓN Y ÉTICA EMPRESARIAL //

        $motivacion_y_etica_empresarial = $arr_values_areas[5] ?? array();
        $fila_inicial_init_motivacion_y_etica_empresarial = 43;

        $posicion_inicial_motivacion_y_etica_empresarial = 42;

        $sheet->mergeCells('B' . $posicion_inicial_motivacion_y_etica_empresarial . ':M' . $posicion_inicial_motivacion_y_etica_empresarial);
        $sheet->setCellValue('B' . $posicion_inicial_motivacion_y_etica_empresarial, 'MOTIVACIÓN Y ÉTICA EMPRESARIAL (16,6%)');
        $sheet->getStyle('B' . $posicion_inicial_motivacion_y_etica_empresarial)->getFont()->setBold(true);
        $sheet->getStyle('B' . $posicion_inicial_motivacion_y_etica_empresarial)->getFont()->setSize(12);
        $sheet->getStyle('B' . $posicion_inicial_motivacion_y_etica_empresarial . ':M' . $posicion_inicial_motivacion_y_etica_empresarial)->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B' . $posicion_inicial_motivacion_y_etica_empresarial . ':M' . $posicion_inicial_motivacion_y_etica_empresarial)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        $sheet->getStyle('B' . $posicion_inicial_motivacion_y_etica_empresarial . ':M' . $posicion_inicial_motivacion_y_etica_empresarial)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('B' . $posicion_inicial_motivacion_y_etica_empresarial . ':M' . $posicion_inicial_motivacion_y_etica_empresarial)->getFill()->getStartColor()->setARGB('FFEAEAEA');

        foreach ($motivacion_y_etica_empresarial as $key_adt => $value_adt) {
            $cellNumberQuestion = 'B' . $fila_inicial_init_motivacion_y_etica_empresarial;

            $cellQuestion = 'C' . $fila_inicial_init_motivacion_y_etica_empresarial . ':M' . $fila_inicial_init_motivacion_y_etica_empresarial;
            $cellQuestion_ = 'C' . $fila_inicial_init_motivacion_y_etica_empresarial;

            $sheet->mergeCells($cellQuestion);
            $sheet->setCellValue($cellQuestion_, strtoupper($key_adt));
            $sheet->getStyle($cellQuestion_)->getFont()->setName('Arial');
            $sheet->getStyle($cellQuestion_)->getFont()->setSize(10);

            $sheet->setCellValue($cellNumberQuestion, $cantidad_preguntas);
            $sheet->getStyle($cellNumberQuestion)->getFont()->setBold(true);
            $sheet->getStyle($cellNumberQuestion)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            $sheet->getStyle($cellQuestion)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            if ($cantidad_preguntas == (count($motivacion_y_etica_empresarial) + count($condiciones_ambientales) + count($trabajo_en_equipo) + count($liderazgo) + count($comunicacion) + count($area_de_trabajo))) {
                $sheet->getStyle($cellNumberQuestion)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                $sheet->getStyle($cellQuestion)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            }
            $sheet->getStyle($cellNumberQuestion)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle($cellNumberQuestion)->getFill()->getStartColor()->setARGB('FFEAEAEA');
            $sheet->getStyle($cellNumberQuestion)->getAlignment()->setHorizontal('center')->setVertical('center');
            $fila_inicial_init_motivacion_y_etica_empresarial++;
            $cantidad_preguntas++;
        }

        // FIN MOTIVACIÓN Y ÉTICA EMPRESARIAL //

        // FIN TABLA DE CONTENIDOS DE RESPUESTAS - FACTORES //

        // TABLA DE CONTENIDOS DE RESPUESTAS - SECCIONES //

        foreach ($this->data as $key_sec => $value_sec) {

            $total_conteo_preguntas_seccion_area_de_trabajo = 0;
            $total_respuestas_seccion_area_de_trabajo = 0;
            $total_ponderacion_seccion_area_de_trabajo = 0;
            $posicion_inicial_area_trabajo_ = 12;
            $fila_inicial_init_area_trabajo_ = 13;

            $total_conteo_preguntas_seccion_comunicacion = 0;
            $total_respuestas_seccion_comunicacion = 0;
            $total_ponderacion_seccion_comunicacion = 0;
            $posicion_inicial_comunicacion_ = 18;
            $fila_inicial_init_comunicacion_ = 19;

            $total_conteo_preguntas_seccion_liderazgo = 0;
            $total_respuestas_seccion_liderazgo = 0;
            $total_ponderacion_seccion_liderazgo = 0;
            $posicion_inicial_liderazgo_ = 24;
            $fila_inicial_init_liderazgo_ = 25;

            $total_conteo_preguntas_seccion_trabajo_en_equipo = 0;
            $total_respuestas_seccion_trabajo_en_equipo = 0;
            $total_ponderacion_seccion_trabajo_en_equipo = 0;
            $posicion_inicial_trabajo_en_equipo_ = 30;
            $fila_inicial_init_trabajo_en_equipo_ = 31;

            $total_conteo_preguntas_seccion_condiciones_ambientales = 0;
            $total_respuestas_seccion_condiciones_ambientales = 0;
            $total_ponderacion_seccion_condiciones_ambientales = 0;
            $posicion_inicial_condiciones_ambientales_ = 36;
            $fila_inicial_init_condicionales_ambientales_ = 37;

            $total_conteo_preguntas_seccion_motivacion_y_etica_empresarial = 0;
            $total_respuestas_seccion_motivacion_y_etica_empresarial = 0;
            $total_ponderacion_seccion_motivacion_y_etica_empresarial = 0;
            $posicion_inicial_motivacion_y_etica_empresarial_ = 42;
            $fila_inicial_init_motivacion_y_etica_empresarial_ = 43;

            $total_ponderacion_seccion_sumado_data_ = 0;

            // Calcula las columnas inicial y final
            $intial_column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($cantidad_columnas_secciones);
            $end_column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($cantidad_columnas_secciones + 2);
            $end_column_cl = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($cantidad_columnas_secciones + 1);

            // Fusionar las celdas
            $sheet->mergeCells($intial_column . '9:' . $end_column . '10');
            $sheet->mergeCells($intial_column . '11:' . $end_column_cl . '11');

            /* AREA DE TRABAJO */

            $sheet->mergeCells($intial_column . $posicion_inicial_area_trabajo_ . ':' . $end_column_cl . $posicion_inicial_area_trabajo_);
            foreach ($value_sec['ÁREA DE TRABAJO'] as $key_sec_peg => $value_sec_peg) {
                $total_conteo_preguntas_seccion_area_de_trabajo = $value_sec_peg['conteo_cantidad_preguntas'];
                $total_respuestas_seccion_area_de_trabajo += $value_sec_peg['porcentaje_respuestas'];
                $total_ponderacion_seccion_area_de_trabajo += $value_sec_peg['porcentaje_seccion_pregunta'];
            }
            $sheet->setCellValue($intial_column . $posicion_inicial_area_trabajo_, round($total_respuestas_seccion_area_de_trabajo, 2));
            $sheet->getStyle($intial_column . $posicion_inicial_area_trabajo_ . ':' . $end_column_cl . $posicion_inicial_area_trabajo_)->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle($intial_column . $posicion_inicial_area_trabajo_)->getFont()->setBold(true);
            $sheet->getStyle($intial_column . $posicion_inicial_area_trabajo_)->getFont()->setSize(11);
            $sheet->getStyle($intial_column . $posicion_inicial_area_trabajo_ . ':' . $end_column_cl . $posicion_inicial_area_trabajo_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue($end_column . $posicion_inicial_area_trabajo_, round((($total_ponderacion_seccion_area_de_trabajo * 100) / $total_conteo_preguntas_seccion_area_de_trabajo), 1) > 16.6 ? 16.6 . '%' : round((($total_ponderacion_seccion_area_de_trabajo * 100) / $total_conteo_preguntas_seccion_area_de_trabajo), 1) . '%');
            $sheet->getStyle($end_column . $posicion_inicial_area_trabajo_)->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle($end_column . $posicion_inicial_area_trabajo_)->getFont()->setBold(true);
            $sheet->getStyle($end_column . $posicion_inicial_area_trabajo_)->getFont()->setSize(11);
            $sheet->getStyle($end_column . $posicion_inicial_area_trabajo_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            foreach ($value_sec['ÁREA DE TRABAJO'] as $key_sec_peg => $value_sec_peg) {
                /* PROMEDIO */
                $sheet->setCellValue($intial_column . $fila_inicial_init_area_trabajo_, round($value_sec_peg['promedio_respuestas'], 1));
                $sheet->getStyle($intial_column . $fila_inicial_init_area_trabajo_)->getFont()->setSize(9);
                $sheet->getStyle($intial_column . $fila_inicial_init_area_trabajo_)->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle($intial_column . $fila_inicial_init_area_trabajo_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                /* PROMEDIO RESULTADO RESPUESTAS */
                $sheet->setCellValue($end_column_cl . $fila_inicial_init_area_trabajo_, round($value_sec_peg['porcentaje_respuestas'], 2));
                $sheet->getStyle($end_column_cl . $fila_inicial_init_area_trabajo_)->getFont()->setSize(9);
                $sheet->getStyle($end_column_cl . $fila_inicial_init_area_trabajo_)->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle($end_column_cl . $fila_inicial_init_area_trabajo_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                /* PROMEDIO PORCENTADO RESPUESTAS */
                $sheet->setCellValue($end_column . $fila_inicial_init_area_trabajo_, round($value_sec_peg['porcentaje_seccion_pregunta'], 3));
                $sheet->getStyle($end_column . $fila_inicial_init_area_trabajo_)->getFont()->setSize(9);
                $sheet->getStyle($end_column . $fila_inicial_init_area_trabajo_)->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle($end_column . $fila_inicial_init_area_trabajo_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $fila_inicial_init_area_trabajo_++;
            }

            /* FIN AREA DE TRABAJO */

            /* COMUNICACION */

            $sheet->mergeCells($intial_column . $posicion_inicial_comunicacion_ . ':' . $end_column_cl . $posicion_inicial_comunicacion_);
            foreach ($value_sec['COMUNICACIÓN'] as $key_sec_peg => $value_sec_peg) {
                $total_conteo_preguntas_seccion_comunicacion = $value_sec_peg['conteo_cantidad_preguntas'];
                $total_respuestas_seccion_comunicacion += $value_sec_peg['porcentaje_respuestas'];
                $total_ponderacion_seccion_comunicacion += $value_sec_peg['porcentaje_seccion_pregunta'];
            }
            $sheet->setCellValue($intial_column . $posicion_inicial_comunicacion_, round($total_respuestas_seccion_comunicacion, 2));
            $sheet->getStyle($intial_column . $posicion_inicial_comunicacion_ . ':' . $end_column_cl . $posicion_inicial_comunicacion_)->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle($intial_column . $posicion_inicial_comunicacion_)->getFont()->setBold(true);
            $sheet->getStyle($intial_column . $posicion_inicial_comunicacion_)->getFont()->setSize(11);
            $sheet->getStyle($intial_column . $posicion_inicial_comunicacion_ . ':' . $end_column_cl . $posicion_inicial_comunicacion_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue($end_column . $posicion_inicial_comunicacion_, round((($total_ponderacion_seccion_comunicacion * 100) / $total_conteo_preguntas_seccion_comunicacion), 1) > 16.6 ? 16.6 . '%' : round((($total_ponderacion_seccion_comunicacion * 100) / $total_conteo_preguntas_seccion_comunicacion), 1) . '%');
            $sheet->getStyle($end_column . $posicion_inicial_comunicacion_)->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle($end_column . $posicion_inicial_comunicacion_)->getFont()->setBold(true);
            $sheet->getStyle($end_column . $posicion_inicial_comunicacion_)->getFont()->setSize(11);
            $sheet->getStyle($end_column . $posicion_inicial_comunicacion_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            foreach ($value_sec['COMUNICACIÓN'] as $key_sec_peg => $value_sec_peg) {
                /* PROMEDIO */
                $sheet->setCellValue($intial_column . $fila_inicial_init_comunicacion_, round($value_sec_peg['promedio_respuestas'], 1));
                $sheet->getStyle($intial_column . $fila_inicial_init_comunicacion_)->getFont()->setSize(9);
                $sheet->getStyle($intial_column . $fila_inicial_init_comunicacion_)->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle($intial_column . $fila_inicial_init_comunicacion_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                /* PROMEDIO RESULTADO RESPUESTAS */
                $sheet->setCellValue($end_column_cl . $fila_inicial_init_comunicacion_, round($value_sec_peg['porcentaje_respuestas'], 2));
                $sheet->getStyle($end_column_cl . $fila_inicial_init_comunicacion_)->getFont()->setSize(9);
                $sheet->getStyle($end_column_cl . $fila_inicial_init_comunicacion_)->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle($end_column_cl . $fila_inicial_init_comunicacion_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                /* PROMEDIO PORCENTADO RESPUESTAS */
                $sheet->setCellValue($end_column . $fila_inicial_init_comunicacion_, round($value_sec_peg['porcentaje_seccion_pregunta'], 3));
                $sheet->getStyle($end_column . $fila_inicial_init_comunicacion_)->getFont()->setSize(9);
                $sheet->getStyle($end_column . $fila_inicial_init_comunicacion_)->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle($end_column . $fila_inicial_init_comunicacion_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $fila_inicial_init_comunicacion_++;
            }

            /* FIN COMUNICACION */

            /* LIDERAZGO */

            $sheet->mergeCells($intial_column . $posicion_inicial_liderazgo_ . ':' . $end_column_cl . $posicion_inicial_liderazgo_);
            foreach ($value_sec['LIDERAZGO'] as $key_sec_peg => $value_sec_peg) {
                $total_conteo_preguntas_seccion_liderazgo = $value_sec_peg['conteo_cantidad_preguntas'];
                $total_respuestas_seccion_liderazgo += $value_sec_peg['porcentaje_respuestas'];
                $total_ponderacion_seccion_liderazgo += $value_sec_peg['porcentaje_seccion_pregunta'];
            }
            $sheet->setCellValue($intial_column . $posicion_inicial_liderazgo_, round($total_respuestas_seccion_liderazgo, 2));
            $sheet->getStyle($intial_column . $posicion_inicial_liderazgo_ . ':' . $end_column_cl . $posicion_inicial_liderazgo_)->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle($intial_column . $posicion_inicial_liderazgo_)->getFont()->setBold(true);
            $sheet->getStyle($intial_column . $posicion_inicial_liderazgo_)->getFont()->setSize(11);
            $sheet->getStyle($intial_column . $posicion_inicial_liderazgo_ . ':' . $end_column_cl . $posicion_inicial_liderazgo_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue($end_column . $posicion_inicial_liderazgo_, round((($total_ponderacion_seccion_liderazgo * 100) / $total_conteo_preguntas_seccion_liderazgo), 1) > 16.6 ? 16.6 . '%' : round((($total_ponderacion_seccion_liderazgo * 100) / $total_conteo_preguntas_seccion_liderazgo), 1) . '%');
            $sheet->getStyle($end_column . $posicion_inicial_liderazgo_)->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle($end_column . $posicion_inicial_liderazgo_)->getFont()->setBold(true);
            $sheet->getStyle($end_column . $posicion_inicial_liderazgo_)->getFont()->setSize(11);
            $sheet->getStyle($end_column . $posicion_inicial_liderazgo_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            foreach ($value_sec['LIDERAZGO'] as $key_sec_peg => $value_sec_peg) {
                /* PROMEDIO */
                $sheet->setCellValue($intial_column . $fila_inicial_init_liderazgo_, round($value_sec_peg['promedio_respuestas'], 1));
                $sheet->getStyle($intial_column . $fila_inicial_init_liderazgo_)->getFont()->setSize(9);
                $sheet->getStyle($intial_column . $fila_inicial_init_liderazgo_)->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle($intial_column . $fila_inicial_init_liderazgo_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                /* PROMEDIO RESULTADO RESPUESTAS */
                $sheet->setCellValue($end_column_cl . $fila_inicial_init_liderazgo_, round($value_sec_peg['porcentaje_respuestas'], 2));
                $sheet->getStyle($end_column_cl . $fila_inicial_init_liderazgo_)->getFont()->setSize(9);
                $sheet->getStyle($end_column_cl . $fila_inicial_init_liderazgo_)->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle($end_column_cl . $fila_inicial_init_liderazgo_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                /* PROMEDIO PORCENTADO RESPUESTAS */
                $sheet->setCellValue($end_column . $fila_inicial_init_liderazgo_, round($value_sec_peg['porcentaje_seccion_pregunta'], 3));
                $sheet->getStyle($end_column . $fila_inicial_init_liderazgo_)->getFont()->setSize(9);
                $sheet->getStyle($end_column . $fila_inicial_init_liderazgo_)->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle($end_column . $fila_inicial_init_liderazgo_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $fila_inicial_init_liderazgo_++;
            }

            /* FIN LIDERAZGO */

            /* TRABAJO EN EQUIPO */

            $sheet->mergeCells($intial_column . $posicion_inicial_trabajo_en_equipo_ . ':' . $end_column_cl . $posicion_inicial_trabajo_en_equipo_);
            foreach ($value_sec['TRABAJO EN EQUIPO'] as $key_sec_peg => $value_sec_peg) {
                $total_conteo_preguntas_seccion_trabajo_en_equipo = $value_sec_peg['conteo_cantidad_preguntas'];
                $total_respuestas_seccion_trabajo_en_equipo += $value_sec_peg['porcentaje_respuestas'];
                $total_ponderacion_seccion_trabajo_en_equipo += $value_sec_peg['porcentaje_seccion_pregunta'];
            }
            $sheet->setCellValue($intial_column . $posicion_inicial_trabajo_en_equipo_, round($total_respuestas_seccion_trabajo_en_equipo, 2));
            $sheet->getStyle($intial_column . $posicion_inicial_trabajo_en_equipo_ . ':' . $end_column_cl . $posicion_inicial_trabajo_en_equipo_)->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle($intial_column . $posicion_inicial_trabajo_en_equipo_)->getFont()->setBold(true);
            $sheet->getStyle($intial_column . $posicion_inicial_trabajo_en_equipo_)->getFont()->setSize(11);
            $sheet->getStyle($intial_column . $posicion_inicial_trabajo_en_equipo_ . ':' . $end_column_cl . $posicion_inicial_trabajo_en_equipo_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue($end_column . $posicion_inicial_trabajo_en_equipo_, round((($total_ponderacion_seccion_trabajo_en_equipo * 100) / $total_conteo_preguntas_seccion_trabajo_en_equipo), 1) > 16.6 ? 16.6 . '%' : round((($total_ponderacion_seccion_trabajo_en_equipo * 100) / $total_conteo_preguntas_seccion_trabajo_en_equipo), 1) . '%');
            $sheet->getStyle($end_column . $posicion_inicial_trabajo_en_equipo_)->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle($end_column . $posicion_inicial_trabajo_en_equipo_)->getFont()->setBold(true);
            $sheet->getStyle($end_column . $posicion_inicial_trabajo_en_equipo_)->getFont()->setSize(11);
            $sheet->getStyle($end_column . $posicion_inicial_trabajo_en_equipo_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            foreach ($value_sec['TRABAJO EN EQUIPO'] as $key_sec_peg => $value_sec_peg) {
                /* PROMEDIO */
                $sheet->setCellValue($intial_column . $fila_inicial_init_trabajo_en_equipo_, round($value_sec_peg['promedio_respuestas'], 1));
                $sheet->getStyle($intial_column . $fila_inicial_init_trabajo_en_equipo_)->getFont()->setSize(9);
                $sheet->getStyle($intial_column . $fila_inicial_init_trabajo_en_equipo_)->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle($intial_column . $fila_inicial_init_trabajo_en_equipo_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                /* PROMEDIO RESULTADO RESPUESTAS */
                $sheet->setCellValue($end_column_cl . $fila_inicial_init_trabajo_en_equipo_, round($value_sec_peg['porcentaje_respuestas'], 2));
                $sheet->getStyle($end_column_cl . $fila_inicial_init_trabajo_en_equipo_)->getFont()->setSize(9);
                $sheet->getStyle($end_column_cl . $fila_inicial_init_trabajo_en_equipo_)->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle($end_column_cl . $fila_inicial_init_trabajo_en_equipo_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                /* PROMEDIO PORCENTADO RESPUESTAS */
                $sheet->setCellValue($end_column . $fila_inicial_init_trabajo_en_equipo_, round($value_sec_peg['porcentaje_seccion_pregunta'], 3));
                $sheet->getStyle($end_column . $fila_inicial_init_trabajo_en_equipo_)->getFont()->setSize(9);
                $sheet->getStyle($end_column . $fila_inicial_init_trabajo_en_equipo_)->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle($end_column . $fila_inicial_init_trabajo_en_equipo_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $fila_inicial_init_trabajo_en_equipo_++;
            }

            /* FIN TRABAJO EN EQUIPO */

            /* CONDICIONES AMBIENTALES */

            $sheet->mergeCells($intial_column . $posicion_inicial_condiciones_ambientales_ . ':' . $end_column_cl . $posicion_inicial_condiciones_ambientales_);
            foreach ($value_sec['CONDICIONES AMBIENTALES'] as $key_sec_peg => $value_sec_peg) {
                $total_conteo_preguntas_seccion_condiciones_ambientales = $value_sec_peg['conteo_cantidad_preguntas'];
                $total_respuestas_seccion_condiciones_ambientales += $value_sec_peg['porcentaje_respuestas'];
                $total_ponderacion_seccion_condiciones_ambientales += $value_sec_peg['porcentaje_seccion_pregunta'];
            }
            $sheet->setCellValue($intial_column . $posicion_inicial_condiciones_ambientales_, round($total_respuestas_seccion_condiciones_ambientales, 2));
            $sheet->getStyle($intial_column . $posicion_inicial_condiciones_ambientales_ . ':' . $end_column_cl . $posicion_inicial_condiciones_ambientales_)->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle($intial_column . $posicion_inicial_condiciones_ambientales_)->getFont()->setBold(true);
            $sheet->getStyle($intial_column . $posicion_inicial_condiciones_ambientales_)->getFont()->setSize(11);
            $sheet->getStyle($intial_column . $posicion_inicial_condiciones_ambientales_ . ':' . $end_column_cl . $posicion_inicial_condiciones_ambientales_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue($end_column . $posicion_inicial_condiciones_ambientales_, round((($total_ponderacion_seccion_condiciones_ambientales * 100) / $total_conteo_preguntas_seccion_condiciones_ambientales), 1) > 16.6 ? 16.6 . '%' : round((($total_ponderacion_seccion_condiciones_ambientales * 100) / $total_conteo_preguntas_seccion_condiciones_ambientales), 1) . '%');
            $sheet->getStyle($end_column . $posicion_inicial_condiciones_ambientales_)->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle($end_column . $posicion_inicial_condiciones_ambientales_)->getFont()->setBold(true);
            $sheet->getStyle($end_column . $posicion_inicial_condiciones_ambientales_)->getFont()->setSize(11);
            $sheet->getStyle($end_column . $posicion_inicial_condiciones_ambientales_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            foreach ($value_sec['CONDICIONES AMBIENTALES'] as $key_sec_peg => $value_sec_peg) {
                /* PROMEDIO */
                $sheet->setCellValue($intial_column . $fila_inicial_init_condicionales_ambientales_, round($value_sec_peg['promedio_respuestas'], 1));
                $sheet->getStyle($intial_column . $fila_inicial_init_condicionales_ambientales_)->getFont()->setSize(9);
                $sheet->getStyle($intial_column . $fila_inicial_init_condicionales_ambientales_)->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle($intial_column . $fila_inicial_init_condicionales_ambientales_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                /* PROMEDIO RESULTADO RESPUESTAS */
                $sheet->setCellValue($end_column_cl . $fila_inicial_init_condicionales_ambientales_, round($value_sec_peg['porcentaje_respuestas'], 2));
                $sheet->getStyle($end_column_cl . $fila_inicial_init_condicionales_ambientales_)->getFont()->setSize(9);
                $sheet->getStyle($end_column_cl . $fila_inicial_init_condicionales_ambientales_)->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle($end_column_cl . $fila_inicial_init_condicionales_ambientales_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                /* PROMEDIO PORCENTADO RESPUESTAS */
                $sheet->setCellValue($end_column . $fila_inicial_init_condicionales_ambientales_, round($value_sec_peg['porcentaje_seccion_pregunta'], 3));
                $sheet->getStyle($end_column . $fila_inicial_init_condicionales_ambientales_)->getFont()->setSize(9);
                $sheet->getStyle($end_column . $fila_inicial_init_condicionales_ambientales_)->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle($end_column . $fila_inicial_init_condicionales_ambientales_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $fila_inicial_init_condicionales_ambientales_++;
            }

            /* FIN CONDICIONES AMBIENTALES */

            /* MOTIVACIÓN Y ÉTICA EMPRESARIAL */

            $sheet->mergeCells($intial_column . $posicion_inicial_motivacion_y_etica_empresarial_ . ':' . $end_column_cl . $posicion_inicial_motivacion_y_etica_empresarial_);
            foreach ($value_sec['MOTIVACIÓN Y ÉTICA EMPRESARIAL'] as $key_sec_peg => $value_sec_peg) {
                $total_conteo_preguntas_seccion_motivacion_y_etica_empresarial = $value_sec_peg['conteo_cantidad_preguntas'];
                $total_respuestas_seccion_motivacion_y_etica_empresarial += $value_sec_peg['porcentaje_respuestas'];
                $total_ponderacion_seccion_motivacion_y_etica_empresarial += $value_sec_peg['porcentaje_seccion_pregunta'];
            }
            $sheet->setCellValue($intial_column . $posicion_inicial_motivacion_y_etica_empresarial_, round($total_respuestas_seccion_motivacion_y_etica_empresarial, 2));
            $sheet->getStyle($intial_column . $posicion_inicial_motivacion_y_etica_empresarial_ . ':' . $end_column_cl . $posicion_inicial_motivacion_y_etica_empresarial_)->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle($intial_column . $posicion_inicial_motivacion_y_etica_empresarial_)->getFont()->setBold(true);
            $sheet->getStyle($intial_column . $posicion_inicial_motivacion_y_etica_empresarial_)->getFont()->setSize(11);
            $sheet->getStyle($intial_column . $posicion_inicial_motivacion_y_etica_empresarial_ . ':' . $end_column_cl . $posicion_inicial_motivacion_y_etica_empresarial_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue($end_column . $posicion_inicial_motivacion_y_etica_empresarial_, round((($total_ponderacion_seccion_motivacion_y_etica_empresarial * 100) / $total_conteo_preguntas_seccion_motivacion_y_etica_empresarial), 1) > 16.6 ? 16.6 . '%' : round((($total_ponderacion_seccion_motivacion_y_etica_empresarial * 100) / $total_conteo_preguntas_seccion_motivacion_y_etica_empresarial), 1) . '%');
            $sheet->getStyle($end_column . $posicion_inicial_motivacion_y_etica_empresarial_)->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle($end_column . $posicion_inicial_motivacion_y_etica_empresarial_)->getFont()->setBold(true);
            $sheet->getStyle($end_column . $posicion_inicial_motivacion_y_etica_empresarial_)->getFont()->setSize(11);
            $sheet->getStyle($end_column . $posicion_inicial_motivacion_y_etica_empresarial_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            foreach ($value_sec['MOTIVACIÓN Y ÉTICA EMPRESARIAL'] as $key_sec_peg => $value_sec_peg) {
                /* PROMEDIO */
                $sheet->setCellValue($intial_column . $fila_inicial_init_motivacion_y_etica_empresarial_, round($value_sec_peg['promedio_respuestas'], 1));
                $sheet->getStyle($intial_column . $fila_inicial_init_motivacion_y_etica_empresarial_)->getFont()->setSize(9);
                $sheet->getStyle($intial_column . $fila_inicial_init_motivacion_y_etica_empresarial_)->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle($intial_column . $fila_inicial_init_motivacion_y_etica_empresarial_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                /* PROMEDIO RESULTADO RESPUESTAS */
                $sheet->setCellValue($end_column_cl . $fila_inicial_init_motivacion_y_etica_empresarial_, round($value_sec_peg['porcentaje_respuestas'], 2));
                $sheet->getStyle($end_column_cl . $fila_inicial_init_motivacion_y_etica_empresarial_)->getFont()->setSize(9);
                $sheet->getStyle($end_column_cl . $fila_inicial_init_motivacion_y_etica_empresarial_)->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle($end_column_cl . $fila_inicial_init_motivacion_y_etica_empresarial_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                /* PROMEDIO PORCENTADO RESPUESTAS */
                $sheet->setCellValue($end_column . $fila_inicial_init_motivacion_y_etica_empresarial_, round($value_sec_peg['porcentaje_seccion_pregunta'], 3));
                $sheet->getStyle($end_column . $fila_inicial_init_motivacion_y_etica_empresarial_)->getFont()->setSize(9);
                $sheet->getStyle($end_column . $fila_inicial_init_motivacion_y_etica_empresarial_)->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getStyle($end_column . $fila_inicial_init_motivacion_y_etica_empresarial_)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $fila_inicial_init_motivacion_y_etica_empresarial_++;
            }

            /* FIN MOTIVACIÓN Y ÉTICA EMPRESARIAL */

            // Establecer el valor en la celda inicial
            $sheet->setCellValue($intial_column . '9', "$key_sec\n N: " . array_values($value_sec['ÁREA DE TRABAJO'])[0]['personas_respondieron_encuesta']);
            $sheet->setCellValue($intial_column . '11', "CL");
            $sheet->setCellValue($end_column . '11', "PD");

            // Aplicar estilos
            $sheet->getStyle($intial_column . '9')->getAlignment()->setWrapText(true);

            $sheet->getStyle($intial_column . '9:' . $end_column . '10')->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle($intial_column . '11')->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle($end_column . '11')->getAlignment()->setHorizontal('center')->setVertical('center');

            $sheet->getStyle($intial_column . '9')->getFont()->setBold(true);
            $sheet->getStyle($intial_column . '9')->getFont()->setSize(11);

            $sheet->getStyle($intial_column . '11')->getFont()->setBold(true);
            $sheet->getStyle($intial_column . '11')->getFont()->setSize(11);

            $sheet->getStyle($end_column . '11')->getFont()->setBold(true);
            $sheet->getStyle($end_column . '11')->getFont()->setSize(11);

            $sheet->getStyle($intial_column . '9:' . $end_column . '10')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            $sheet->getStyle($intial_column . '9:' . $end_column . '10')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle($intial_column . '9:' . $end_column . '10')->getFill()->getStartColor()->setARGB('FFD9D9D9');

            $sheet->getStyle($intial_column . '11:' . $end_column_cl . '11')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle($intial_column . '11:' . $end_column_cl . '11')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle($intial_column . '11:' . $end_column_cl . '11')->getFill()->getStartColor()->setARGB('FFD9D9D9');

            $sheet->getStyle($end_column . '11')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle($end_column . '11')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle($end_column . '11')->getFill()->getStartColor()->setARGB('FFD9D9D9');

            $total_ponderacion_seccion_sumado_data_ =
                self::calcularPonderacion($total_ponderacion_seccion_area_de_trabajo, $total_conteo_preguntas_seccion_area_de_trabajo) +
                self::calcularPonderacion($total_ponderacion_seccion_comunicacion, $total_conteo_preguntas_seccion_comunicacion) +
                self::calcularPonderacion($total_ponderacion_seccion_liderazgo, $total_conteo_preguntas_seccion_liderazgo) +
                self::calcularPonderacion($total_ponderacion_seccion_trabajo_en_equipo, $total_conteo_preguntas_seccion_trabajo_en_equipo) +
                self::calcularPonderacion($total_ponderacion_seccion_condiciones_ambientales, $total_conteo_preguntas_seccion_condiciones_ambientales) +
                self::calcularPonderacion($total_ponderacion_seccion_motivacion_y_etica_empresarial, $total_conteo_preguntas_seccion_motivacion_y_etica_empresarial);

            // Incrementar la columna para la siguiente iteración
            $cantidad_columnas_secciones += 3; // Aumenta en 3 para dejar espacio entre secciones

            $fila_inicial_resultados = 49;
            $fila_intermediaria_resultados = 50;
            $fila_final_resultados = 53;

            // Calcula las columnas inicial y final
            $intial_column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($cantidad_columnas_secciones_resultados);
            $end_column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($cantidad_columnas_secciones_resultados + 2);

            // Fusionar las celdas
            $sheet->mergeCells($intial_column . "$fila_inicial_resultados:" . $end_column . "$fila_inicial_resultados");
            $sheet->mergeCells($intial_column . "$fila_intermediaria_resultados:" . $end_column . "$fila_final_resultados");

            $sheet->setCellValue($intial_column . "$fila_inicial_resultados", round($total_ponderacion_seccion_sumado_data_) . '%');
            $sheet->getStyle($intial_column . "$fila_inicial_resultados")->getFont()->setBold(true);
            $sheet->getStyle($intial_column . "$fila_inicial_resultados")->getFont()->setSize(11);
            $sheet->getStyle($intial_column . "$fila_inicial_resultados:" . $end_column . "$fila_inicial_resultados")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            $sheet->getStyle($intial_column . "$fila_inicial_resultados:" . $end_column . "$fila_inicial_resultados")->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle($intial_column . "$fila_inicial_resultados:" . $end_column . "$fila_inicial_resultados")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            if ($total_ponderacion_seccion_sumado_data_ > 95) {
                $sheet->getStyle($intial_column . "$fila_inicial_resultados:" . $end_column . "$fila_inicial_resultados")->getFill()->getStartColor()->setARGB('FF90EE90');
            } else if ($total_ponderacion_seccion_sumado_data_ < 95 && $total_ponderacion_seccion_sumado_data_ >= 80) {
                $sheet->getStyle($intial_column . "$fila_inicial_resultados:" . $end_column . "$fila_inicial_resultados")->getFill()->getStartColor()->setARGB('FFFFFF00');
            } else if ($total_ponderacion_seccion_sumado_data_ < 80 && $total_ponderacion_seccion_sumado_data_ >= 70) {
                $sheet->getStyle($intial_column . "$fila_inicial_resultados:" . $end_column . "$fila_inicial_resultados")->getFill()->getStartColor()->setARGB('FFFFA500');
            } else if ($total_ponderacion_seccion_sumado_data_ < 70) {
                $sheet->getStyle($intial_column . "$fila_inicial_resultados:" . $end_column . "$fila_inicial_resultados")->getFill()->getStartColor()->setARGB('FFFF0000');
            }

            $sheet->getStyle($intial_column . "$fila_intermediaria_resultados")->getFont()->setBold(true);
            $sheet->getStyle($intial_column . "$fila_intermediaria_resultados")->getFont()->setSize(11);
            if ($total_ponderacion_seccion_sumado_data_ > 95) {
                $sheet->setCellValue($intial_column . "$fila_intermediaria_resultados", "S.E");
            } else if ($total_ponderacion_seccion_sumado_data_ < 95 && $total_ponderacion_seccion_sumado_data_ >= 80) {
                $sheet->setCellValue($intial_column . "$fila_intermediaria_resultados", "C.E");
            } else {
                $sheet->setCellValue($intial_column . "$fila_intermediaria_resultados", "N.E");
            }
            $sheet->getStyle($intial_column . "$fila_intermediaria_resultados:" . $end_column . "$fila_final_resultados")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            $sheet->getStyle($intial_column . "$fila_intermediaria_resultados:" . $end_column . "$fila_final_resultados")->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle($intial_column . "$fila_intermediaria_resultados:" . $end_column . "$fila_final_resultados")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);

            // Incrementar la columna para la siguiente iteración
            $cantidad_columnas_secciones_resultados += 3; // Aumenta en 3 para dejar espacio entre secciones


            $sheet->mergeCells("B$fila_inicial_resultados:M$fila_final_resultados");
            $sheet->setCellValue("B$fila_inicial_resultados", 'RESULTADO');
            $sheet->getStyle("B$fila_inicial_resultados")->getFont()->setBold(true);
            $sheet->getStyle("B$fila_inicial_resultados")->getFont()->setSize(16);
            $sheet->getStyle("B$fila_inicial_resultados:M$fila_final_resultados")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
            $sheet->getStyle("B$fila_inicial_resultados:M$fila_final_resultados")->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle("B$fila_inicial_resultados:M$fila_final_resultados")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle("B$fila_inicial_resultados:M$fila_final_resultados")->getFill()->getStartColor()->setARGB('FFD9D9D9');
        }

        // FIN TABLA DE CONTENIDOS DE RESPUESTAS - SECCIONES //

    }
}
