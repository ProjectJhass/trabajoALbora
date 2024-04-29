<?php

namespace App\Models\soap;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SoapClient;

class cotizador_consultas extends Model
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

    public static function consulta_ws_productos()
    {
        $consulta_soap = 'SELECT f120_id as sku, f120_descripcion as producto, a.f126_precio as precio, f132_cant_existencia_1 as cantidad
        FROM t126_mc_items_precios a
        INNER JOIN (SELECT f126_rowid_item, MAX(f126_fecha_activacion) fecha_max
        FROM t126_mc_items_precios WHERE
        f126_id_cia ="2" and f126_id_lista_precio = "101"
        GROUP BY (f126_rowid_item)) b ON a.f126_rowid_item = b.f126_rowid_item AND a.f126_fecha_activacion = b.fecha_max
        INNER JOIN t120_mc_items c ON(a.f126_rowid_item=c.f120_rowid)
        INNER JOIN t121_mc_items_extensiones ON(f120_rowid=f121_rowid_item)
        INNER JOIN t132_mc_items_instalacion ON(f121_rowid=f132_rowid_item_ext)
        WHERE f120_id_cia="2"
        and a.f126_id_lista_precio = "101"
        and f121_ind_estado="1"
        and c.f120_id_tipo_inv_serv IN ("INV143005","INVMCIACON")
        and f132_id_instalacion="001"';

        return $consulta_soap;
    }

    public static function productosCotizadorWS()
    {
        $parametros_siesa = self::paramentros_ws_siesa(self::consulta_ws_productos());
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
