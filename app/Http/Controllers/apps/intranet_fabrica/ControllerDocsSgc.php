<?php

namespace App\Http\Controllers\apps\intranet_fabrica;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet_fabrica\ModelDocsSgc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ControllerDocsSgc extends Controller
{
    public function index()
    {
        return view('apps.intranet_fabrica.fabrica.sgc.docs_sgc');
    }

    public function ObtenerDocumentosNivel1($seccion)
    {
        $documentos = ModelDocsSgc::ObtenerDocuementosSGC($seccion, '0');
        switch ($seccion) {
            case '1':
                $titulo = "Revisión por la dirección y gestion de calidad";
                break;
            case '2':
                $titulo = "Producción";
                break;
            case '3':
                $titulo = "Talento humano";
                break;
            case '4':
                $titulo = "Compras y almacenamiento";
                break;
            case '5':
                $titulo = "Mantenimiento y metrología";
                break;
        }
        return view('apps.intranet_fabrica.fabrica.sgc.carpetas_1', ['seccion' => $seccion, 'titulo' => $titulo, 'documentos' => $documentos]);
    }

    public function ObtenerDocumentosNivel2($seccion, $carpeta_seccion)
    {
        $documentos = ModelDocsSgc::ObtenerDocuementosSGC($seccion, $carpeta_seccion);
        return view('apps.intranet_fabrica.fabrica.sgc.carpetas_2', ['carpeta' => $seccion, 'subcarpeta' => $carpeta_seccion, 'documentos' => $documentos]);
    }

    public function CargarDocumentacionSGC(Request $request)
    {
        if ($request->hasFile('DocumentosSGC')) {
            $documento = $request->file('DocumentosSGC');
            $nombre = $documento->getClientOriginalName();
            $tama = filesize($documento);
            $tipo = $documento->getClientOriginalExtension();

            $nombre_doc = str_replace('.' . $tipo, '', $nombre);
            $nombre_cargue = uniqid() . "_" . $nombre;

            $response_file = $documento->storeAs('documentacion-sgc', $nombre_cargue);
            if ($response_file) {
                $data = ([
                    'nombre_doc' => $nombre_doc,
                    'documento' => $nombre_cargue,
                    'tama' => $tama,
                    'tipo' => $tipo,
                    'carpeta' => $request->carpeta,
                    'subcarpeta' => $request->subcarpeta
                ]);
                ModelDocsSgc::CargarDocumentoSGC($data);
                return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }
    }

    public function EliminarDocumentoSGC(Request $request)
    {

        $nombre_doc = $request->nombre_doc;
        $id_documento = $request->id_documento;

        if (Storage::delete('documentacion-sgc/' . $nombre_doc)) {
            ModelDocsSgc::EliminarDocumentoSGC($id_documento);
            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
