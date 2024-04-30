<?php

namespace App\Http\Controllers\apps\intranet_fabrica;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet_fabrica\ModelCambiosEnSeries;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\apps\intranet_fabrica\ControllerGenerarPdf as generarPDF;
use App\Models\apps\intranet_fabrica\ModelEncuestaSatisfaccion;
use Illuminate\Support\Facades\Mail;

class CambiosEnSeries extends Controller
{
    public function VisualizarFormulario()
    {
        return view('apps.intranet_fabrica.fabrica.cambios_series.cambios');
    }

    public function GuardarInformacionFormularioCambios(Request $request)
    {
        //Primera parte, se agrega a la tabla de reportes
        $imagen = isset($request->AgregarImagenes) ? 'SI' : 'NO';
        $n = 0;

        $insert_id = ModelCambiosEnSeries::GuardarInformacionReporte(
            array(
                [
                    'producto' => $request->producto,
                    'pieza' => $request->pieza,
                    'op' => $request->op,
                    'problema' => $request->problema,
                    'cambio' => $request->cambio,
                    'imagen' => $imagen
                ]
            )
        );
        if ($insert_id > 0) {
            if ($imagen == 'SI') {
                if ($request->hasFile('imagen')) {
                    $imagenes = $request->file('imagen');
                    foreach ($imagenes as $file) {
                        $nombre = uniqid() . "_" . $file->getClientOriginalName();
                        $tama = filesize($file);
                        $tipo = $file->getClientOriginalExtension();

                        $response_file = $file->storeAs('public/imagenes-cambios-series', $nombre);
                        if ($response_file) {
                            ModelCambiosEnSeries::GuardarImagenesDeReporte($tipo, $nombre, $insert_id);
                        }
                    }
                }
            }

            for ($i = 1; $i <= 8; $i++) {
                $actividad = empty($request['actividad' . $i]) ? 'No hay cambios' : $request['actividad' . $i];
                $responsable = empty($request['responsable' . $i]) ? 'NA' : $request['responsable' . $i];
                ModelCambiosEnSeries::AgregarCambiosPorSeccion($i, $actividad, $responsable, $insert_id);
            }

            $info_pdf = new generarPDF;
            $pdf = $info_pdf->GenerarPDF($insert_id);

            $to = (['santiago.murillo@mueblesalbura.com.co','diana.mora@mueblesalbura.com.co', 'sgc@mueblesalbura.com.co', 'costos@mueblesalbura.com.co', 'asistenteproduccion@mueblesalbura.com.co', 'viviana.romero@mueblesalbura.com.co','auditoria@mueblesalbura.com.co']);

            Mail::send('emails.cambio_serie', [], function ($mail) use ($to, $pdf) {
                $mail->to($to);
                $mail->subject('Reporte y analisis de cambios');
                $mail->attachData($pdf->output('S'), 'reporte y analisis de cambios en serie.pdf');
            });

            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function GenerarPDFSeries(Request $request)
    {
        $id_reporte = $request->id_reporte;
        $n = 0;

        $reporte = ModelCambiosEnSeries::ObtenerReporteCambio($id_reporte);
        $imagenes = ModelCambiosEnSeries::ObtenerImagenesReporte($id_reporte);
        $secciones = ModelCambiosEnSeries::ObtenerCambiosSeccion($id_reporte);

        foreach ($imagenes as $key => $val) {
            $nombre_i = $val->nombre_archivo;
            if (!empty($nombre_i)) {
                $n++;
            }
        }

        $infoPersonal = ModelEncuestaSatisfaccion::ObtenerInformacionUsuarioAlm(1);
        $respuestas_user = ModelEncuestaSatisfaccion::ObtenerRepuestasUsuarioEncuestaSatisfaccion(1);

        return Pdf::loadView('fabrica.cambios_series.formato', array('info' => $infoPersonal, 'preguntas' => $respuestas_user))->stream();
    }
}
