<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios\pdf;

use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use App\Models\apps\servicios_tecnicos\servicios\ModelRespuestaFab;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class ControllerFormat extends Controller
{
    public function createDocument(Request $request)
    {
        $id_st = $request->id_st;
        $info = ModelNuevaSolicitud::find($id_st);
        $carta_ = ModelRespuestaFab::where('id_st', $id_st)->where('estado', '1')->get();
        $info_val = $carta_->first();

        $fechaActual = date('Y-m-d');
        $fechaCarbon = Carbon::parse($fechaActual);
        Carbon::setLocale('es');
        $fechaFormateada = $fechaCarbon->isoFormat('LL');

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $imagePath = Storage::path('public/logo/fondo_hs_word.jpg');

        $section->addImage(
            $imagePath,
            array(
                'width'         => 620,
                'height'        => 842,
                'wrappingStyle' => 'behind',
                'positioning'   => 'absolute',
                'marginTop'     => -800  // Centra verticalmente
            )
        );

        $section->addText('Armenia Q, ' . $fechaFormateada, array('size' => 12));
        $section->addTextBreak();
        $section->addText('SEÑOR(A):', array('bold' => true));
        $section->addText($info->nombre, array('bold' => true));
        $section->addText('Dirección: ' . $info->direccion . ' ' . $info->barrio . ' ' . $info->ciudad);
        $section->addText('Tel. ' . $info->celular);
        $section->addText($info->ciudad, ', CO');

        $section->addTextBreak();
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(1400)->addText('ASUNTO:', array('bold' => true));
        $table->addCell(8600)->addText('Respuesta a valoración de servicio técnico.');

        $section->addTextBreak();
        $section->addText('Presentamos a usted un cordial saludo de parte de colchones Happy Sleep SAS.');
        $section->addText('Es un orgullo contar con usted como nuestro cliente, en respuesta a su solicitud y en cumplimiento de nuestra política de calidad a continuación se relaciona el diagnóstico y tratamiento que nuestro departamento de servicios técnicos dio a su producto.');

        $section->addTextBreak();
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(1800)->addText('PRODUCTO:', array('bold' => true));
        $table->addCell(8200)->addText($info->articulo);
        $table->addRow();
        $table->addCell(1800)->addText('DIAGNÓSTICO:', array('bold' => true));
        $table->addCell(8200)->addText($info_val->diagnostico);
        $table->addRow();
        $table->addCell(1800)->addText('SOLUCION:', array('bold' => true));
        $table->addCell(8200)->addText($info_val->solucion);
        $section->addTextBreak();

        $table = $section->addTable();
        $table->addRow();
        $table->addCell(2800)->addText('Fecha recepción:', array('bold' => true));
        $table->addCell(7200)->addText(date('d/m/Y', strtotime($info->created_at)));
        $table->addRow();
        $table->addCell(2800)->addText('Entrega', array('bold' => true));
        $table->addCell(7200)->addText(date('d/m/Y'));
        $table->addRow();
        $table->addCell(2800)->addText('Total, días hábiles:', array('bold' => true));
        $table->addCell(7200)->addText('15 días hábiles.');
        $table->addRow();
        $table->addCell(2800)->addText('Centro de experiencia:', array('bold' => true));
        $table->addCell(7200)->addText($info->ciudad);

        $section->addTextBreak();
        $section->addText('De acuerdo a su solicitud y en cumplimiento a nuestra política de calidad envío soporte técnico.');
        $section->addText('PQR 1887 / QRS 1718.');
        $section->addTextBreak();
        $section->addText('Atentamente,');
        $section->addTextBreak();

        $imageFirma = Storage::path('public/firmas/firma_valentina.png');
        $section->addImage($imageFirma, array(
            'width'         => 150,
            'wrappingStyle' => 'behind',
            'positioning'   => 'absolute'
        ));

        $table = $section->addTable();
        $table->addRow();
        $table->addCell(5000)->addText('Valentina Bernal Ariza.', array('bold' => true));
        $table->addCell(5000)->addText('Fecha recibida: _____________________');
        $table->addRow();
        $table->addCell(5000)->addText('Coordinador Servicio al Cliente', array('bold' => true));
        $table->addCell(5000)->addText('Firma: C.C. _____________________');
        $table->addRow();
        $table->addCell(5000)->addText('Colchones Happy Sleep S.A', array('bold' => true));

        $filename = 'respuesta_servicio_tecnico.docx';
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(public_path($filename));

        return response()->download(public_path($filename))->deleteFileAfterSend(true);
    }
}
