<?php

namespace App\Models\soap;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SoapClient;

class st_ModelConsultas extends Model
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

    protected static function consulta_ws_faturas($cedula, $almacen)
    {
        $consulta_soap = 'SELECT t1.f350_rowid as id, t1.f350_id_tipo_docto as factura, t1.f350_consec_docto as num_fac, t1.f350_fecha as fecha_fac, a.f350_id_tipo_docto as rem, a.f350_consec_docto as num_rem, a.f350_fecha as fecha_rem
        FROM t350_co_docto_contable as t1
        LEFT JOIN (SELECT f350_rowid, f350_id_co, f350_id_tipo_docto, f350_consec_docto, f350_fecha, f460_rowid_docto_factura FROM t350_co_docto_contable
        INNER JOIN t460_cm_docto_remision_venta ON(f350_rowid=f460_rowid_docto) WHERE f350_ind_estado="1") as a 
        ON(t1.f350_rowid=f460_rowid_docto_factura) INNER JOIN t200_mm_terceros as t200 ON(f200_rowid=t1.f350_rowid_tercero)
        WHERE f200_id="' . $cedula . '" and t1.f350_id_cia="2" and t1.f350_ind_estado="1" and t1.f350_id_co="' . $almacen . '" and t1.f350_id_tipo_docto ="FVE"';
        return $consulta_soap;
    }

    protected static function consulta_ws_productos($id_factura)
    {
        $consulta_soap = 'SELECT 
        f120_id as id, 
        f120_descripcion as producto,
        f121_id_ext1_detalle as ext1,
        f121_id_ext2_detalle as ext2 
        FROM t470_cm_movto_invent
        INNER JOIN t121_mc_items_extensiones ON(f470_rowid_item_ext=f121_rowid)
        INNER JOIN t120_mc_items ON(f121_rowid_item=f120_rowid)
        WHERE f470_id_cia="2" and f470_rowid_docto_fact ="' . $id_factura . '"';
        return $consulta_soap;
    }

    protected static function consulta_ws_cliente($id_factura)
    {
        $consulta_soap = 'SELECT TOP(1)
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
        f461_id_cond_pago as forma_pago
        FROM t350_co_docto_contable as t350
        INNER JOIN t200_mm_terceros as t200 ON(f200_rowid=f350_rowid_tercero)
        INNER JOIN t461_cm_docto_factura_venta as t461 ON(f350_rowid=f461_rowid_docto)
        INNER JOIN t015_mm_contactos ON(f015_rowid=f200_rowid_contacto)
        INNER JOIN t013_mm_ciudades ON(f013_id=f015_id_ciudad and f015_id_depto=f013_id_depto)
        WHERE f350_id_cia="2" and f461_rowid_docto="' . $id_factura . '"';

        return $consulta_soap;
    }

    protected static function consulta_ws_Infocliente($cedula)
    {
        $consulta_soap = 'SELECT TOP(1)
        f200_id as cedula,
        f200_nombres as nombre,
        f200_apellido1 as ap1,
        f200_apellido2 as ap2,
        f015_telefono as celular,
        f015_celular as celular2,
        f015_email as email
        FROM t200_mm_terceros
        INNER JOIN t015_mm_contactos ON(f015_rowid=f200_rowid_contacto)
        WHERE f200_id="' . $cedula . '"';

        return $consulta_soap;
    }

    protected static function get_ws_all_products()
    {
        $consulta_soap = 'SELECT 
        f120_id as id,
        f120_rowid as rowid,
        f120_descripcion as producto,
        f121_id_ext1_detalle as ext1,
        f121_id_ext2_detalle as ext2 
        FROM t120_mc_items RIGHT JOIN t121_mc_items_extensiones ON(f121_rowid_item=f120_rowid)
        WHERE f120_id_cia="2" and f120_id_tipo_inv_serv IN ("INV143005","INVMCIACON") ORDER BY producto ASC';

        return $consulta_soap;
    }

    protected static function consulta_all_productos()
    {
        $consulta_soap = 'SELECT f120_descripcion as producto FROM t120_mc_items WHERE f120_id_cia="2"
        and f120_id_tipo_inv_serv IN ("INV143005","INVMCIACON") ORDER BY producto ASC';
        return $consulta_soap;
    }

    public static function facturasClientes($cedula, $almacen)
    {
        $parametros_siesa = self::paramentros_ws_siesa(self::consulta_ws_faturas($cedula, $almacen));
        $conexion_siesa = self::conexion_ws_siesa($parametros_siesa);
        $resultado = $conexion_siesa->EjecutarConsultaXML($parametros_siesa);

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

        return isset($data) ? $data : [];
    }

    public static function productosClientes($id_factura)
    {
        $parametros_siesa = self::paramentros_ws_siesa(self::consulta_ws_productos($id_factura));
        $conexion_siesa = self::conexion_ws_siesa($parametros_siesa);
        $resultado = $conexion_siesa->EjecutarConsultaXML($parametros_siesa);

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

        return isset($data) ? $data : [];
    }

    public static function infoCliente($id_factura)
    {
        $parametros_siesa = self::paramentros_ws_siesa(self::consulta_ws_cliente($id_factura));
        $conexion_siesa = self::conexion_ws_siesa($parametros_siesa);
        $resultado = $conexion_siesa->EjecutarConsultaXML($parametros_siesa);

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

        return isset($data) ? $data : [];
    }

    public static function allProductosSiesa()
    {
        $parametros_siesa = self::paramentros_ws_siesa(self::get_ws_all_products());
        $conexion_siesa = self::conexion_ws_siesa($parametros_siesa);
        $resultado = $conexion_siesa->EjecutarConsultaXML($parametros_siesa);

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

        return isset($data) ? $data : [];
    }

    public static function getInfoCliente($cedula_)
    {
        $parametros_siesa = self::paramentros_ws_siesa(self::consulta_ws_Infocliente($cedula_));
        $conexion_siesa = self::conexion_ws_siesa($parametros_siesa);
        $resultado = $conexion_siesa->EjecutarConsultaXML($parametros_siesa);

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

        return isset($data) ? $data : [];
    }
}
