<?php

namespace App\Models\soap;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SimpleXMLElement;
use SoapClient;

class st_CrearOP extends Model
{
    use HasFactory;

    public static function conexion_siesa($parametros)
    {
        $url_servidor_db = env('SOAP_URL');
        return new SoapClient($url_servidor_db, $parametros);
    }

    protected static function paramentros_ws_siesa($plano_1, $plano_2)
    {
        $estructura = "<?xml version='1.0' encoding='utf-8'?><Importar>
        <NombreConexion>" . env('SOAP_CONNECTION') . "</NombreConexion>
        <IdCia>" . env('SOAP_ID_CIA') . "</IdCia>
        <Usuario>" . env('SOAP_USERNAME') . "</Usuario>
        <Clave>" . env('SOAP_PASSWORD') . "</Clave>
        <Datos>
        <Linea>000000100000001002</Linea>
        <Linea>" . $plano_1 . "</Linea>
        <Linea>" . $plano_2 . "</Linea>
        <Linea>000000499990001002</Linea>
        </Datos>
        </Importar>";

        $parm['pvstrDatos'] = $estructura;
        $parm['printTipoError']         = '1';
        $parm['cache_wsdl']             = WSDL_CACHE_NONE;

        return $parm;
    }

    public static function ejecutarConsultaWs($plano1, $plano2)
    {
        $parametros_siesa = self::paramentros_ws_siesa($plano1, $plano2);
        $conexion_siesa = self::conexion_ws_siesa($parametros_siesa);
        $resultado = $conexion_siesa->ImportarXML($parametros_siesa);

        $any = $resultado->ImportarXMLResult->any;
        $dataArray = [];
        $xmlString = $any;
        $xml = new SimpleXMLElement($xmlString);
        $tables = $xml->xpath('//Table');
        foreach ($tables as $table) {
            $data = [
                'f_valor' => (string)$table->f_valor,
                'f_detalle' => (string)$table->f_detalle,
            ];
            $dataArray[] = $data;
        }

        return count($dataArray) == 0 ? true : $dataArray;
    }
}
