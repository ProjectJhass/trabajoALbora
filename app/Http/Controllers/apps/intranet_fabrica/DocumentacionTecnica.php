<?php

namespace App\Http\Controllers\apps\intranet_fabrica;

use App\Models\apps\intranet_fabrica\DocumentacionTecnica as ModelDocumentacionTecnica;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentacionTecnica extends Controller
{
    public function ObtenerSeccionFabrica()
    {
        $secciones =  ModelDocumentacionTecnica::ObtenerSeccionesFabrica();
        $referencias = ModelDocumentacionTecnica::ObtenerReferencias();
        return view('apps.intranet_fabrica.fabrica.documentacion.doc_tecnica', ['secciones' => $secciones, 'referencias' => $referencias]);
    }


    public function ObtenerTitulosPorProducto(Request $request)
    {
        $this->validate($request, [
            'producto' => 'required'
        ]);
    }

    public function ObtenerTitulosProductoSection($seccion, $id_seccion, $id_producto)
    {
        $documentos = [];

        $informacion = ModelDocumentacionTecnica::ObtenerTitulosProductos($id_seccion, $id_producto);
        $response_producto = ModelDocumentacionTecnica::ObtenerNombreProducto($id_producto);
        foreach ($response_producto as $key => $val) {
            $nombre_producto = $val->nombre_referencia;
        }
        foreach ($informacion as $key => $value) {
            $id_titulo = $value->id_producto;
            $docs = ModelDocumentacionTecnica::ObtenerDocumentosTitulo($id_titulo);
            $docss = (count($docs) > 0) ? $docs : [];
            array_push($documentos, array('id_titulo' => $value->id_producto, 'titulo' => $value->titulo, 'documentos' => $docss));
        }

        return view('apps.intranet_fabrica.fabrica.documentacion.productos_seccion', ['seccion' => $seccion, 'id_seccion' => $id_seccion, 'id_referencia' => $id_producto, 'referencia' => $nombre_producto, 'informacion' => $documentos]);
    }

    public function CrearNuevoTituloSeccion(Request $request)
    {
        $response = ModelDocumentacionTecnica::AgregarTituloSeccion($request->titulo_seccion_prod, $request->id_seccion, $request->id_referencia);
        if ($response) {
            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function CargarNuevoDocumentoFab(Request $request)
    {
        $valor = $request->file('DocumentoSeccion' . $request->id_titulo);
        if (!empty($valor)) {

            $id_titulo = $request->id_titulo;

            $nombre = $valor->getClientOriginalName();
            $tama = filesize($valor);
            $tipo = $valor->getClientOriginalExtension();

            $nombre_doc = uniqid() . "_" . $nombre;

            $response_file = $request->file('DocumentoSeccion' . $request->id_titulo)->storeAs('public/documentacion-tecnica', $nombre_doc);
            if ($response_file) {
                ModelDocumentacionTecnica::GuardarInformacionNuevoDocuemento($nombre_doc, $tipo, $tama, $id_titulo);
                return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }
    }

    public function EliminarDocumentoFabrica(Request $request)
    {
        $id_documento = $request->id_documento;
        $nombre_doc = $request->nombre_documento;
        if (Storage::delete('documentacion-tecnica/' . $nombre_doc)) {
            ModelDocumentacionTecnica::EliminarDocumentoDB($id_documento);
            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function EliminarCarpetaFabrica(Request $request)
    {
        $id_carpeta = $request->id_carpeta;
        $response = ModelDocumentacionTecnica::EliminarCarpetaDocumentacion($id_carpeta);
        if ($response) {
            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
