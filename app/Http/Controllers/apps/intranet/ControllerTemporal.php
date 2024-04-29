<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelDocumentosTemporales;
use App\Http\Controllers\apps\intranet\ControllerDocumentacionIntranet as docs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ControllerTemporal extends Controller
{
    
    public function index($dpto)
    {
        $permiso = new docs();
        $docs = ModelDocumentosTemporales::ObtenerDocumentosTemporales($dpto);
        $permisos = $permiso->departamentos($dpto);
        return view('apps.intranet.docs_tmp.home', ['permiso' => $permisos, 'documentos' => $docs, 'seccion' => $dpto]);
    }

    public function CargarDocumentosTmp(Request $request)
    {
        if ($request->hasFile('archivos_tmp')) {

            $documentos =  $request->file('archivos_tmp');
            $dpto = $request->dpto;

            foreach ($documentos as $key => $value) {

                $nombre = $value->getClientOriginalName();
                $tipo = $value->getClientOriginalExtension();

                $nombre_doc = str_replace('.' . $tipo, '', $nombre);
                $nombre_cargue = uniqid() . "_" . $nombre;

                $response_file = $value->storeAs('public/' . $dpto, $nombre_cargue);
                $url_doc = Storage::url($dpto . "/" . $nombre_cargue);

                if ($response_file) {
                    $data = ([
                        'nombre_doc' => $nombre_doc,
                        'documento' => $nombre_cargue,
                        'tipo' => $tipo,
                        'url' => $url_doc,
                        'fecha_cargue' => date('Y-m-d'),
                        'fecha_eliminacion' => "2025-01-01",
                        'dpto' => $dpto,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    ModelDocumentosTemporales::CargarDocumentosTmp($data);
                }
            }

            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
