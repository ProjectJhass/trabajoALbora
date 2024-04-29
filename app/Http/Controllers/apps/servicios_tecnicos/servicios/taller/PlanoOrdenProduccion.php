<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios\taller;

use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanoOrdenProduccion extends Controller
{

    public function linea2($st, $notas)
    {
        $word_i = (['á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ']);  //palabras que se eliminan de la nota si están en ella
        $word_f = (['a', 'e', 'i', 'o', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'N']);  //Vocales y N

        $ost_count = strlen(trim($st));
        $ced_ = strlen(Auth::user()->id);
        $ost = str_repeat("0", (8 - $ost_count)) . trim($st);  //rellena con ceros a la izquierda para que sea de 8 digitos.
        $user_creacion = Auth::user()->id . str_repeat(" ", (15 - $ced_));

        //Consulta a la orden de servicio y se captura la info
        $ost_info = ModelNuevaSolicitud::find($st);
        //Proveedor
        $proveedor = $ost_info->proveedor;
        $proveedor = substr($proveedor, 0, 30);
        $ref1 = $proveedor . str_repeat(" ", (30 - strlen($proveedor)));
        //Almacen
        $almacen = $ost_info->almacen;
        $almacen  = substr($almacen, 0, 30);
        $ref2 = $almacen . str_repeat(" ", (30 - strlen($almacen)));
        //concepto fabrica
        $valoracion_st = $ost_info->respuesta_st;
        $valoracion  = substr($valoracion_st, 0, 30);
        $ref3 = $valoracion . str_repeat(" ", (30 - strlen($valoracion)));

        //Notas
        $notas_i = trim(str_replace($word_i, $word_f, $notas));
        $notas_i = substr($notas_i, 0, 2000);
        $notas_ = $notas_i . str_repeat(" ", (2000 - strlen($notas_i)));

        $F_NUMERO_REG = '0000002';
        $F_TIPO_REG = '0850';
        $F_SUBTIPO_REG = '00';
        $F_VERSION_REG = '01';
        $F_CIA = '002';
        $F_CONSEC_AUTO_REG = '0';
        $f850_id_co = '001';
        $f850_id_tipo_docto = 'STE';
        $f850_consec_docto = $ost;
        $f850_fecha = date('Ymd');
        $f850_ind_estado = '1';
        $f850_ind_impresión = '0';
        $f850_id_clase_docto = '701';
        $f850_tercero_planificador = $user_creacion;
        $f850_id_tipo_docto_op_padre = str_repeat(" ", 3);
        $f850_consec_docto_op_padre = str_repeat("0", 8);
        $f850_id_instalacion = '001';
        $f850_clase_op = 'STE';
        $f850_referencia_1 = $ref1;
        $f850_referencia_2 = $ref2;
        $f850_referencia_3 = $ref3;
        $f850_notas = $notas_;
        $f850_id_co_pv = str_repeat(" ", 3);
        $f850_id_tipo_docto_pv = str_repeat(" ", 3);
        $f850_consec_docto_pv = str_repeat("0", 8);

        return $F_NUMERO_REG
            . $F_TIPO_REG
            . $F_SUBTIPO_REG
            . $F_VERSION_REG
            . $F_CIA
            . $F_CONSEC_AUTO_REG
            . $f850_id_co
            . $f850_id_tipo_docto
            . $f850_consec_docto
            . $f850_fecha
            . $f850_ind_estado
            . $f850_ind_impresión
            . $f850_id_clase_docto
            . $f850_tercero_planificador
            . $f850_id_tipo_docto_op_padre
            . $f850_consec_docto_op_padre
            . $f850_id_instalacion
            . $f850_clase_op
            . $f850_referencia_1
            . $f850_referencia_2
            . $f850_referencia_3
            . $f850_notas
            . $f850_id_co_pv
            . $f850_id_tipo_docto_pv
            . $f850_consec_docto_pv;
    }

    public function linea3($st)
    {
        $ost_count = strlen(trim($st));
        $ost = str_repeat("0", (8 - $ost_count)) . trim($st);  //rellena con ceros a la izquierda para que sea de 8 digitos.

        //Consulta a la orden de servicio y se captura la info
        $ost_info = ModelNuevaSolicitud::find($st);
        //$item
        $item = trim($ost_info->id_item);
        $item_ = str_repeat("0", (7 - strlen($item))) . $item;

        $F_NUMERO_REG = "0000003";
        $F_TIPO_REG = "0851";
        $F_SUBTIPO_REG = "00";
        $F_VERSION_REG = "01";
        $F_CIA = "002";
        $f851_id_co  = "001";
        $f851_id_tipo_docto = "STE";
        $f851_consec_docto = $ost;
        $f851_nro_registro = "0000000001";
        $f851_id_item = $item_;
        $f851_referencia_item = str_repeat(" ", 50);
        $f851_codigo_barras = str_repeat(" ", 20);
        $f851_id_ext1_detalle = str_repeat(" ", 20);
        $f851_id_ext2_detalle = str_repeat(" ", 20);
        $f851_id_unidad_medida = "UND ";
        $f851_porc_rendimiento = "100.0000";
        $f851_cant_planeada_base = "000000000000001.0000";
        $f851_fecha_inicio = date("Ymd");
        $f851_fecha_terminacion = date("Ymd");
        $f851_id_metodo_lista = str_repeat(" ", 4);
        $f851_id_bodega_componentes = str_repeat(" ", 5);
        $f851_id_metodo_ruta = "0001";
        $f851_id_lote = str_repeat(" ", 15);
        $f851_notas = str_repeat(" ", 2000);
        $f851_id_bodega = "00105";

        return $F_NUMERO_REG
            . $F_TIPO_REG
            . $F_SUBTIPO_REG
            . $F_VERSION_REG
            . $F_CIA
            . $f851_id_co
            . $f851_id_tipo_docto
            . $f851_consec_docto
            . $f851_nro_registro
            . $f851_id_item
            . $f851_referencia_item
            . $f851_codigo_barras
            . $f851_id_ext1_detalle
            . $f851_id_ext2_detalle
            . $f851_id_unidad_medida
            . $f851_porc_rendimiento
            . $f851_cant_planeada_base
            . $f851_fecha_inicio
            . $f851_fecha_terminacion
            . $f851_id_metodo_lista
            . $f851_id_bodega_componentes
            . $f851_id_metodo_ruta
            . $f851_id_lote
            . $f851_notas
            . $f851_id_bodega;
    }
}
