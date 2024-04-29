<?php

namespace App\Models\soap\crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SoapClient;

class ModelConsultasCRM extends Model
{
    use HasFactory;

    protected static function conexion_ws_siesa($parametros)
    {
        $url_servidor_db = env('SOAP_URL');
        return new SoapClient($url_servidor_db, $parametros);
    }

    protected static function paramentros_ws_siesa($consulta)
    {
        $estructura = "
        <Consulta>
        <NombreConexion>" . env('SOAP_CONNECTION') . "</NombreConexion>
        <IdCia>" . env('SOAP_ID_CIA') . "</IdCia>
        <IdProveedor>" . env('SOAP_PROVEEDOR') . "</IdProveedor>
        <IdConsulta>" . env('SOAP_QUERY') . "</IdConsulta>
        <Usuario>" . env('SOAP_USERNAME') . "</Usuario>
        <Clave>" . env('SOAP_PASSWORD') . "</Clave>
        <Parametros>
        <Sql> SET QUOTED_IDENTIFIER OFF; $consulta SET QUOTED_IDENTIFIER ON; </Sql>
        </Parametros>
        </Consulta>
        ";
        $parm['pvstrxmlParametros'] = $estructura;
        $parm['printTipoError']         = '1';
        $parm['cache_wsdl']             =  WSDL_CACHE_NONE;

        return $parm;
    }

    protected static function consulta_ws_ventas_cliente($fve, $co)
    {
        $consulta_soap = 'SELECT TOP(1)
        f350_rowid as rowid,
        f350_fecha as fecha,
        f200_id as cedula,
        f200_nombres as nombre,
        f200_apellido1 as ap1,
        f200_apellido2 as ap2,
        f015_telefono as celular,
        f015_celular as celular2,
        f015_email as email,
        f013_descripcion as ciudad,
        f015_id_barrio as barrio,
        f015_direccion1 as direccion,
        f461_id_cond_pago as forma_pago,
        f461_vlr_neto as valor_ttal
        FROM t350_co_docto_contable as t350
        INNER JOIN t200_mm_terceros as t200 ON(f200_rowid=f350_rowid_tercero)
        INNER JOIN t461_cm_docto_factura_venta as t461 ON(f350_rowid=f461_rowid_docto)
        INNER JOIN t015_mm_contactos ON(f015_rowid=f200_rowid_contacto)
        INNER JOIN t013_mm_ciudades ON(f013_id=f015_id_ciudad and f015_id_depto=f013_id_depto)
        WHERE f350_id_cia="2" and f350_id_tipo_docto ="FVE"
        and f350_consec_docto="' . $fve . '" and f350_id_co="' . $co . '" and f350_id_cia="2"';

        return $consulta_soap;
    }

    protected static function consulta_ws_ventas_productos($rowid)
    {
        $consulta_soap = 'SELECT f120_id as sku, f120_descripcion as producto, f470_cant_1 as cantidad, f470_vlr_neto as valor
        FROM t470_cm_movto_invent
        INNER JOIN t121_mc_items_extensiones ON(f470_rowid_item_ext=f121_rowid)
        INNER JOIN t120_mc_items ON(f121_rowid_item=f120_rowid)
        WHERE f470_id_cia="2" and f470_rowid_docto_fact="' . $rowid . '"';

        return $consulta_soap;
    }

    public static function ventasEfectivasInfoCliente($fve, $co)
    {
        $parametros_siesa = self::paramentros_ws_siesa(self::consulta_ws_ventas_cliente($fve, $co));
        $conexion_siesa = self::conexion_ws_siesa($parametros_siesa);
        $resultado = $conexion_siesa->EjecutarConsultaXML($parametros_siesa);

        $schema = @simplexml_load_string($resultado->EjecutarConsultaXMLResult->schema);
        $any = @simplexml_load_string($resultado->EjecutarConsultaXMLResult->any);

        if (@is_object($any->NewDataSet->Resultado)) {

            foreach ($any->NewDataSet->Resultado as $key => $value) {
                foreach ($value as $campo => $val) {
                    $valores[(string)$campo] = (string)$val;
                }
                unset($valores['ws_id']);
                $data[] = $valores;
                $valores = array();
            }
        }
        if (@$any->NewDataSet->Table) {
            foreach ($any->NewDataSet->Table as $key => $value) {
                echo "\n";
                echo "\nError Linea:\t " . $value->F_NRO_LINEA;
                echo "\nError Value:\t " . $value->F_VALOR;
                echo "\nError Desc:\t " . $value->F_DETALLE;
            }
        }

        return isset($data) ? $data : [];
    }

    public static function ventasEfectivasProductos($rowid)
    {
        $parametros_siesa = self::paramentros_ws_siesa(self::consulta_ws_ventas_productos($rowid));
        $conexion_siesa = self::conexion_ws_siesa($parametros_siesa);
        $resultado = $conexion_siesa->EjecutarConsultaXML($parametros_siesa);

        $schema = @simplexml_load_string($resultado->EjecutarConsultaXMLResult->schema);
        $any = @simplexml_load_string($resultado->EjecutarConsultaXMLResult->any);

        if (@is_object($any->NewDataSet->Resultado)) {

            foreach ($any->NewDataSet->Resultado as $key => $value) {
                foreach ($value as $campo => $val) {
                    $valores[(string)$campo] = (string)$val;
                }
                unset($valores['ws_id']);
                $data[] = $valores;
                $valores = array();
            }
        }
        if (@$any->NewDataSet->Table) {
            foreach ($any->NewDataSet->Table as $key => $value) {
                echo "\n";
                echo "\nError Linea:\t " . $value->F_NRO_LINEA;
                echo "\nError Value:\t " . $value->F_VALOR;
                echo "\nError Desc:\t " . $value->F_DETALLE;
            }
        }

        return isset($data) ? $data : [];
    }
}
