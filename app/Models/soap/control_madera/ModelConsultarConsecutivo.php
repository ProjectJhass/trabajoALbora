<?php

namespace App\Models\soap\control_madera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SoapClient;

class ModelConsultarConsecutivo extends Model
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

    public static function ObtenerConsecutivo()
    {
        $consulta = 'SELECT TOP(1) f850_consec_docto as consecutivo FROM t850_mf_op_docto 
        WHERE f850_id_tipo_docto="OP" and f850_ind_estado="1" and f850_usuario_aprobacion="albura" 
        ORDER BY f850_consec_docto DESC ';

        $consecutivo = '';

        $parametros_siesa = self::construccion_parametros($consulta);
        $conexion_siesa = self::conexion_siesa($parametros_siesa);
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
        $data_i = isset($data) ? $data : [];
        foreach ($data_i as $key => $value) {
            $consecutivo = $value['consecutivo'];
        }

        return $consecutivo;
    }
}
