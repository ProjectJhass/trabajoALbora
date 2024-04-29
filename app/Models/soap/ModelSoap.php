<?php

namespace App\Models\soap;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SoapClient;

class ModelSoap extends Model
{
    use HasFactory;

    public static function conexion_siesa($parametros)
    {
        $url_servidor_db = env('SOAP_URL');
        return new SoapClient($url_servidor_db, $parametros);
    }

    public static function construccion_parametros($consulta)
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
        <Sql>SET QUOTED_IDENTIFIER OFF;" . $consulta . "SET QUOTED_IDENTIFIER ON;</Sql>
        </Parametros>
        </Consulta>
        ";
        $parm['pvstrxmlParametros'] = $estructura;
        $parm['printTipoError']         = '1';
        $parm['cache_wsdl']             = WSDL_CACHE_NONE;

        return $parm;
    }

    protected static function construccion_consulta($cedula)
    {
        $consulta_ws = '
        SELECT
        c0550_id_cia as empresa,
        f200_nit as cedula,
        f200_razon_social as nombre
        FROM w0550_contratos c
        INNER JOIN t200_mm_terceros t
        ON(t.f200_rowid=c.c0550_rowid_tercero)
        WHERE c0550_id_cia IN("2","5") and c0550_ind_estado="1" and f200_nit="' . $cedula . '"';
        return $consulta_ws;
    }

    protected static function consulta_usuarios()
    {
        $consulta_ws = '
        SELECT
        c0550_id_cia as empresa,
        f200_nit as cedula,
        f200_razon_social as nombre
        FROM w0550_contratos c
        INNER JOIN t200_mm_terceros t
        ON(t.f200_rowid=c.c0550_rowid_tercero)
        WHERE c0550_id_cia IN("2","5") and c0550_ind_estado="1"';
        return $consulta_ws;
    }

    public static function ObtenerInformacionUsuario($cedula)
    {
        $parametros_siesa = self::construccion_parametros(self::construccion_consulta($cedula));
        $conexion_siesa = self::conexion_siesa($parametros_siesa);
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

    public static function ObtenerTodosUsuarios()
    {
        $parametros_siesa = self::construccion_parametros(self::consulta_usuarios());
        $conexion_siesa = self::conexion_siesa($parametros_siesa);
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
