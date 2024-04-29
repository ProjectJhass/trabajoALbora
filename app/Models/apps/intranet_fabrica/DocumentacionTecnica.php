<?php

namespace App\Models\apps\intranet_fabrica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DocumentacionTecnica extends Model
{
    use HasFactory;

    public static function ObtenerSeccionesFabrica()
    {
        return DB::connection('db_fabrica')->table('seccion_fab')->get();
    }
    public static function ObtenerReferencias()
    {
        return DB::connection('db_fabrica')->table('referencias')->orderBy('nombre_referencia')->get();
    }

    public static function ObtenerNombreProducto($id_producto)
    {
        return DB::connection('db_fabrica')->table('referencias')->select('nombre_referencia')->where('id_referencia', '=', $id_producto)->get();
    }

    public static function ObtenerProductosPorSeccion($id_seccion)
    {

        return DB::connection('db_fabrica')->table('seccion_fab')
            ->join('seccion_producto', 'seccion_fab.id_seccion', '=', 'seccion_producto.id_seccion')
            ->join('referencias', 'referencias.id_referencia', '=', 'seccion_producto.id_referencia')
            ->where('seccion_fab.id_seccion', '=', $id_seccion)
            ->select('seccion_producto.id_producto', 'referencias.*')->get();
    }

    public static function ObtenerTitulosProductos($id_seccion, $id_referencia)
    {
        return DB::connection('db_fabrica')->table('seccion_producto')->where('id_seccion', '=', $id_seccion)->where('id_referencia', '=', $id_referencia)->get();
    }

    public static function ObtenerDocumentosTitulo($id_titulo)
    {
        return DB::connection('db_fabrica')->table('documentos')->where('id_produc_title', '=', $id_titulo)->get();
    }

    public static function AgregarTituloSeccion($titulo, $seccion, $referencia)
    {
        $query = false;
        if (!empty($titulo)) {
            $query = DB::connection('db_fabrica')->table('seccion_producto')->insertGetId(['titulo' => $titulo, 'id_seccion' => $seccion, 'id_referencia' => $referencia]);
        }
        return $query;
    }

    public static function GuardarInformacionNuevoDocuemento($nombre_doc, $tipo_doc, $tama_doc, $id_titulo)
    {
        $fecha = date('Y-m-d');
        return DB::connection('db_fabrica')->table('documentos')->insertGetId(['nombre_documento' => $nombre_doc, 'tipo_doc' => $tipo_doc, 'tama_doc' => $tama_doc, 'fecha_cargue' => $fecha, 'id_produc_title' => $id_titulo]);
    }

    public static function EliminarDocumentoDB($id_documento)
    {
        return DB::connection('db_fabrica')->table('documentos')->where('id_documento', '=', $id_documento)->delete();
    }

    public static function AgregarNuevaReferenciaFab($informacion)
    {
        return DB::connection('db_fabrica')->table('referencias')->insert($informacion);
    }

    public static function EliminarCarpetaDocumentacion($id_carpeta)
    {
        return DB::connection('db_fabrica')->table('seccion_producto')->where('id_producto', '=', $id_carpeta)->delete();
    }
}
