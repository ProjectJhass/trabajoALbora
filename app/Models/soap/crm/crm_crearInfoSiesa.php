<?php

namespace App\Models\soap\crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SoapClient;

class crm_crearInfoSiesa extends Model
{
    use HasFactory;

    public static function conexion_siesa($parametros)
    {
        $url_servidor_db = env('SOAP_URL');
        return new SoapClient($url_servidor_db, $parametros);
    }

    public static function paramentros_ws_siesa($plano_1, $plano_2, $plano_3)
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
        <Linea>" . $plano_3 . "</Linea>
        <Linea>000000599990001002</Linea>
        </Datos>
        </Importar>";

        $parm['pvstrDatos'] = $estructura;
        $parm['printTipoError']         = '1';
        $parm['cache_wsdl']             = WSDL_CACHE_NONE;

        return $parm;
    }
}
