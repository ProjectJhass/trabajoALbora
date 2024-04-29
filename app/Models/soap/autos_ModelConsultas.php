<?php

namespace App\Models\soap;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SoapClient;

class autos_ModelConsultas extends Model
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

    public static function GenerarConsultaGasolinaAuto($id_auto, $auxiliar, $fecha_i, $fecha_f)
    {
        $consulta_soap = 'SELECT f351_rowid_auxiliar, SUM(f351_valor_db) as valor
        FROM t351_co_mov_docto
        WHERE f351_ind_estado="1" and f351_id_cia="2"
        and f351_rowid_auxiliar="' . $auxiliar . '"
        and f351_rowid_ccosto="' . $id_auto . '"
        and f351_fecha BETWEEN "' . $fecha_i . '" and "' . $fecha_f . '" GROUP BY (f351_rowid_auxiliar)';
        return $consulta_soap;
    }

    public static function GenerarGastosMantenimientoMeses($id_auto, $auxiliar, $year, $month)
    {
        $consulta_soap = 'SELECT f351_rowid_ccosto, SUM(f351_valor_db) as valor, MONTH(f351_fecha) as mes, YEAR(f351_fecha) as year
        FROM t351_co_mov_docto
        WHERE f351_ind_estado="1"
        and f351_id_cia="2"
        and f351_rowid_auxiliar ="' . $auxiliar . '"
        and f351_rowid_ccosto ="' . $id_auto . '"
        and YEAR(f351_fecha) ="' . $year . '" and MONTH(f351_fecha)="' . $month . '"
        GROUP BY f351_rowid_ccosto, MONTH(f351_fecha), YEAR(f351_fecha)';
        return $consulta_soap;
    }

    public static function ConstruccionConsulta($row_id, $fecha_i, $fecha_f, $id_auxiliar)
    {
        $consulta_soap = '
            SELECT f351_notas as concepto,f351_fecha as fecha,f351_valor_db as valor
            FROM t351_co_mov_docto WHERE f351_ind_estado="1" and f351_rowid_ccosto="' . $row_id . '" and f351_id_cia="2" and f351_rowid_auxiliar="' . $id_auxiliar . '" and CAST(f351_fecha as date) BETWEEN CAST("' . $fecha_i . '" as date) and CAST("' . $fecha_f . '" as date)
        ';
        return $consulta_soap;
    }
    
    public static function ObtenerGastoGasolinaRangoAuto($id_auto, $fecha_i, $fecha_f)
    {
        $auxiliar = '3624';
        $gasolina = 0;

        $parametros_siesa = self::paramentros_ws_siesa(self::GenerarConsultaGasolinaAuto($id_auto, $auxiliar, $fecha_i . "T00:00:00", $fecha_f . "T23:59:59"));
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

        $data = isset($data) ? $data : [];

        foreach ($data as $key => $value) {
            $gasolina = $value['valor'];
        }

        return $gasolina;
    }

    public static function ObtenerGastosMttoRangoAuto($id_auto, $fecha_i, $fecha_f)
    {
        $auxiliar = '3618';
        $gasto_mtto = 0;

        $parametros_siesa = self::paramentros_ws_siesa(self::GenerarConsultaGasolinaAuto($id_auto, $auxiliar, $fecha_i . "T00:00:00", $fecha_f . "T23:59:59"));
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

        $data = isset($data) ? $data : [];

        foreach ($data as $key => $value) {
            $gasto_mtto = $value['valor'];
        }

        return $gasto_mtto;
    }

    public static function ObtenerInformacionMantenimientoAutos($row_id, $fecha_i, $fecha_f)
    {
        $auxiliar = '3618';
        $parametros_siesa = self::paramentros_ws_siesa(self::ConstruccionConsulta($row_id, $fecha_i, $fecha_f, $auxiliar));
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

    public static function ObtenerGastosGasolinaMeses($id_auto, $year, $month)
    {
        $auxiliar = '3624';

        $parametros_siesa = self::paramentros_ws_siesa(self::GenerarGastosMantenimientoMeses($id_auto, $auxiliar, $year, $month));
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

        $data = isset($data) ? $data : [];
        $valor_gasto = 0;
        foreach ($data as $key => $value) {
            $valor_gasto = $value['valor'];
        }

        return $valor_gasto;
    }

    public static function ObtenerGastosMttoMeses($id_auto, $year, $month)
    {
        $auxiliar = '3618';

        $parametros_siesa = self::paramentros_ws_siesa(self::GenerarGastosMantenimientoMeses($id_auto, $auxiliar, $year, $month));
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

        $data = isset($data) ? $data : [];

        $valor_gasto = 0;
        foreach ($data as $key => $value) {
            $valor_gasto = $value['valor'];
        }

        return $valor_gasto;
    }
}
