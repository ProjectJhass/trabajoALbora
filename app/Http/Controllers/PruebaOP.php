<?php

namespace App\Http\Controllers;

use App\Models\apps\control_madera\ModelCortesPlanificados;
use App\Models\soap\st_CrearOP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PruebaOP extends Controller
{
    public function index()
    {
        $notas = "Prueba desde app";
        $linea2 = self::linea2Madera($notas);
        $linea3 = self::linea3Madera();

        return st_CrearOP::ejecutarConsultaWs($linea2, $linea3);
    }
    
    public function linea2Madera($notas)
    {
        $word_i = (['á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ']);  //palabras que se eliminan de la nota si están en ella
        $word_f = (['a', 'e', 'i', 'o', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'N']);  //Vocales y N

        $ced_ = strlen(Auth::user()->id);
        $user_creacion = Auth::user()->id . str_repeat(" ", (15 - $ced_));

        //Consulta a la orden de servicio y se captura la info
        $ost_info = ModelCortesPlanificados::find(17);
        //Proveedor
        $proveedor = "";
        $proveedor = substr($proveedor, 0, 30);
        $ref1 = $proveedor . str_repeat(" ", (30 - strlen($proveedor)));
        //Almacen
        $almacen = "";
        $almacen  = substr($almacen, 0, 30);
        $ref2 = $almacen . str_repeat(" ", (30 - strlen($almacen)));
        //concepto fabrica
        $valoracion_st = "";
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
        $F_CONSEC_AUTO_REG = '1';
        $f850_id_co = '001';
        $f850_id_tipo_docto = 'OP ';
        $f850_consec_docto = "00000001";
        $f850_fecha = date('Ymd');
        $f850_ind_estado = '1';
        $f850_ind_impresión = '0';
        $f850_id_clase_docto = '701';
        $f850_tercero_planificador = $user_creacion;
        $f850_id_tipo_docto_op_padre = str_repeat(" ", 3);
        $f850_consec_docto_op_padre = str_repeat("0", 8);
        $f850_id_instalacion = '001';
        $f850_clase_op = 'OP2';
        $f850_referencia_1 = $ref1; //Vacia
        $f850_referencia_2 = $ref2; //Vacia
        $f850_referencia_3 = $ref3; //Vacia
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

    public function linea3Madera()
    {
        //Consulta a la orden de servicio y se captura la info
        $ost_info = ModelCortesPlanificados::find(17);
        //$item
        $item = "940";
        $item_ = str_repeat("0", (7 - strlen($item))) . $item;

        //Cantidad
        $cantidad_ = !empty($ost_info->pulgadas_cortadas) ? trim(($ost_info->pulgadas_cortadas-$ost_info->pulgadas_no_utilizadas)) : 1;
        $cantidad_ = $cantidad_ > 0 ? $cantidad_ : 1;
        $cantidad_planeada = str_repeat("0", (15 - strlen($cantidad_))) . $cantidad_;
        $cantidad_planeada = $cantidad_planeada.".0000";

        $F_NUMERO_REG = "0000003";
        $F_TIPO_REG = "0851";
        $F_SUBTIPO_REG = "00";
        $F_VERSION_REG = "01";
        $F_CIA = "002";
        $f851_id_co  = "001";
        $f851_id_tipo_docto = "OP ";
        $f851_consec_docto = "00000001";
        $f851_nro_registro = "0000000001";
        $f851_id_item = $item_; //El codigo para crear OP (Ver img Teams - Email ing)
        $f851_referencia_item = str_repeat(" ", 50);
        $f851_codigo_barras = str_repeat(" ", 20);
        $f851_id_ext1_detalle = str_repeat(" ", 20);
        $f851_id_ext2_detalle = str_repeat(" ", 20);
        $f851_id_unidad_medida = "PGD ";
        $f851_porc_rendimiento = "100.0000";
        $f851_cant_planeada_base = $cantidad_planeada; // "000000000000001.0000"; //Cantidad real a retirar
        $f851_fecha_inicio = date("Ymd");
        $f851_fecha_terminacion = date("Ymd");
        $f851_id_metodo_lista = "0001";
        $f851_id_bodega_componentes = str_repeat(" ", 5); 
        $f851_id_metodo_ruta = "0001";
        $f851_id_lote = str_repeat(" ", 15);
        $f851_notas = str_repeat(" ", 2000);
        $f851_id_bodega = "00130";

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
