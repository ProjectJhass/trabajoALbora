<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\apps\intranet\ControllerCargarDocumentos as documents;
use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelCargarDocumentos;
use App\Models\apps\intranet\ModelObtenerDocsSeccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ControllerDocumentacionIntranet extends Controller
{
   
    public static function departamentos($dpto)
    {
        $dptos = ([
            'logistica' => (['dpto' => '1', 'permiso' => '1']),
            'cartera' => (['dpto' => '2', 'permiso' => '1']),
            'ventas' => (['dpto' => '3', 'permiso' => '1']),
            'rrhh' => (['dpto' => '4', 'permiso' => '1']),
            'auditoria' => (['dpto' => '5', 'permiso' => '1']),
            'contabilidad' => (['dpto' => '6', 'permiso' => '1']),
            'sistemas' => (['dpto' => '7', 'permiso' => '1']),
            'fabrica' => (['dpto' => '8', 'permiso' => '1']),
            'tesoreria' => (['dpto' => '9', 'permiso' => '1']),
            'mercadeo' => (['dpto' => '10', 'permiso' => '1'])
        ]);
        return $dptos[$dpto];
    }
    public function documentos(Request $request)
    {
        $seccion = $request->seccion;
        $memorando = $request->memo;
        $permisos = self::departamentos($seccion);
        $documentos = ModelObtenerDocsSeccion::ObtenerDocumentacionIntranet($memorando);
        return view('apps.intranet.intranet_documentacion.documentacion', ['documentos' => $documentos, 'permiso' => $permisos, 'seccion' => $memorando, 'dpto' => $seccion]);
    }

    public function cargar_documentos(Request $request)
    {
        $seccion = $request->seccion;
        $memorando = $request->memo;

        $docs = new documents;
        if ($request->hasFile('docs_log')) {
            $documentos =  $request->file('docs_log');
            $response = $docs->GuardarDocumentos($documentos, $memorando);

            if ($response) {
                return response()->json(['status' => true, 'dpto' => $seccion, 'seccion' => $memorando], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }
    }

    public function eliminar_documentos(Request $request)
    {
        $seccion = $request->memo;
        $id = $request->id;
        $documento = ModelCargarDocumentos::ObtenerNombreDocumento($id);
        if (Storage::delete("public/" . $seccion . "/" . $documento)) {
            ModelCargarDocumentos::EliminarDocumentoDB($id);
            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
