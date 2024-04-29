<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelCargarDocumentos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ControllerCargarDocumentos extends Controller
{
    
    public function GuardarDocumentos($documentos, $seccion)
    {
        $nom_documentos = '';
        foreach ($documentos as $key => $value) {

            $nombre = $value->getClientOriginalName();
            $tipo = $value->getClientOriginalExtension();

            $nombre_doc = str_replace('.' . $tipo, '', $nombre);
            $nombre_cargue = uniqid() . "_" . $nombre;

            $nom_documentos .= $nombre_doc . ", ";

            $response_file = $value->storeAs('public/' . $seccion, $nombre_cargue);
            $url_doc = Storage::url($seccion . "/" . $nombre_cargue);

            if ($response_file) {
                $data = ([
                    'nombre_doc' => $nombre_doc,
                    'documento' => $nombre_cargue,
                    'tipo' => $tipo,
                    'url' => $url_doc,
                    'fecha_cargue' => date('Y-m-d'),
                    'seccion' => $seccion,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                ModelCargarDocumentos::CargarDocumentacion($data);
            }
        }

        session(['nombre_documentacion_up' => $nom_documentos]);

        return true;
    }
}
