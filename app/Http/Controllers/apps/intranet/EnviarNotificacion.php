<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EnviarNotificacion extends Controller
{
    protected function GenerarEmailsEnviarNotificacion($dptos)
    {

        $correos_enviar = array();

        $emails_logistica = [
            "logistica@mueblesalbura.com.co",
            "asistente.logistica@mueblesalbura.com.co",
            "serviciostecnicos@mueblesalbura.com.co",
            "bodega.ppal@mueblesalbura.com.co",
            "suministros@mueblesalbura.com.co"
        ];
        $emails_tesoreria = [
            "tesoreria@mueblesalbura.com.co"
        ];
        $emails_cartera = [
            "angela.orozco@mueblesalbura.com.co",
            "cartera@mueblesalbura.com.co"
        ];
        $emails_ventas = [
            "asistentecomercial@mueblesalbura.com.co",
            "ventasenlinea@mueblesalbura.com.co",
            "sandram.gonzalez@mueblesalbura.com.co",
            "mariap.orrego@mueblesalbura.com.co",
            "ventasweb@mueblesalbura.com.co",
            "tiendaenlinea@mueblesalbura.com.co"
        ];
        $emails_rrhh = [
            "salomon.hinojosa@mueblesalbura.com.co",
            "sst@mueblesalbura.com.co",
            "recursoshumanos@mueblesalbura.com.co",
            "edith.betancourt@mueblesalbura.com.co"
        ];
        $emails_auditoria = [
            "rosa.tellez@mueblesalbura.com.co",
            "auditoria.ppal@mueblesalbura.com.co"
        ];
        $emails_contabilidad = [
            "paula.jimenez@mueblesalbura.com.co",
            "contabilidad@mueblesalbura.com.co",
            "cumplimiento@mueblesalbura.com.co",
            "autorizaciones@mueblesalbura.com.co",
            "asistentecontabilidad@mueblesalbura.com.co"
        ];
        $emails_sistemas = [
            "web.developer@mueblesalbura.com.co",
            "albura.development@gmail.com"
            /* "sistemas@mueblesalbura.com.co" */
        ];

        $emails_ppal = [
            "logistica@mueblesalbura.com.co",
            "asistente.logistica@mueblesalbura.com.co",
            "serviciostecnicos@mueblesalbura.com.co",
            "bodega.ppal@mueblesalbura.com.co",
            "suministros@mueblesalbura.com.co",
            "tesoreria@mueblesalbura.com.co",
            "angela.orozco@mueblesalbura.com.co",
            "cartera@mueblesalbura.com.co",
            "asistentecomercial@mueblesalbura.com.co",
            "ventasenlinea@mueblesalbura.com.co",
            "sandram.gonzalez@mueblesalbura.com.co",
            "mariap.orrego@mueblesalbura.com.co",
            "ventasweb@mueblesalbura.com.co",
            "tiendaenlinea@mueblesalbura.com.co",
            "salomon.hinojosa@mueblesalbura.com.co",
            "sst@mueblesalbura.com.co",
            "recursoshumanos@mueblesalbura.com.co",
            "rosa.tellez@mueblesalbura.com.co",
            "auditoria.ppal@mueblesalbura.com.co",
            "paula.jimenez@mueblesalbura.com.co",
            "contabilidad@mueblesalbura.com.co",
            "cumplimiento@mueblesalbura.com.co",
            "autorizaciones@mueblesalbura.com.co",
            "asistentecontabilidad@mueblesalbura.com.co",
            "web.developer@mueblesalbura.com.co",
            "sistemas@mueblesalbura.com.co",
            "edith.betancourt@mueblesalbura.com.co"
        ];

        $emails_regionales = [
            "regional.piloto@mueblesalbura.com.co",
            "regional.armenia@mueblesalbura.com.co",
            "regional.ibague@mueblesalbura.com.co",
            "regional.pereira@mueblesalbura.com.co",
            "regional.girardot@mueblesalbura.com.co"
        ];

        $emails_002 = [
            "armenia02@mueblesalbura.com.co"
        ];
        $emails_004 = [
            "ibague04@mueblesalbura.com.co",
            "bodegaibague@mueblesalbura.com.co"
        ];
        $emails_008 = [
            "dosquebradas08@mueblesalbura.com.co",
        ];
        $emails_010 = [
            "pereira10@mueblesalbura.com.co",
        ];
        $emails_011 = [
            "girardot11@mueblesalbura.com.co",
            "bodegagirardot@mueblesalbura.com.co",
        ];
        $emails_012 = [
            "neiva12@mueblesalbura.com.co"
        ];
        $emails_014 = [
            "pereira14@mueblesalbura.com.co"
        ];
        $emails_017 = [
            "manizales17@mueblesalbura.com.co",
            "bodegamanizales@mueblesalbura.com.co"
        ];
        $emails_025 = [
            "ibague25@mueblesalbura.com.co",
            "bodegaibague@mueblesalbura.com.co",
        ];
        $emails_027 = [
            "girardot27@mueblesalbura.com.co",
            "bodegagirardot@mueblesalbura.com.co",
        ];
        $emails_028 = [
            "pereira28@mueblesalbura.com.co",
        ];
        $emails_036 = [
            "cali36@mueblesalbura.com.co"
        ];

        $emails_almacenes = [
            "armenia02@mueblesalbura.com.co",
            "regional.armenia@mueblesalbura.com.co",
            "ibague04@mueblesalbura.com.co",
            "bodegaibague@mueblesalbura.com.co",
            "regional.ibague@mueblesalbura.com.co",
            "dosquebradas08@mueblesalbura.com.co",
            "pereira10@mueblesalbura.com.co",
            "regional.pereira@mueblesalbura.com.co",
            "girardot11@mueblesalbura.com.co",
            "bodegagirardot@mueblesalbura.com.co",
            "regional.girardot@mueblesalbura.com.co",
            "neiva12@mueblesalbura.com.co",
            "pereira14@mueblesalbura.com.co",
            "manizales17@mueblesalbura.com.co",
            "bodegamanizales@mueblesalbura.com.co",
            "ibague25@mueblesalbura.com.co",
            "girardot27@mueblesalbura.com.co",
            "pereira28@mueblesalbura.com.co",
            "cali36@mueblesalbura.com.co"
        ];

        $emails_fabrica = [
            "viviana.romero@mueblesalbura.com.co",
            "diana.mora@mueblesalbura.com.co",
            "dbgdiseno@gmail.com",
            "costos@mueblesalbura.com.co",
            "sgc@mueblesalbura.com.co",
            "asistenteproduccion@mueblesalbura.com.co",
            "mercadeo@happysleep.com.co",
            "logistica@mueblesalbura.com.co",
            "bodega.ppal@mueblesalbura.com.co",
            "serviciostecnicos@mueblesalbura.com.co",
            "mariap.orrego@mueblesalbura.com.co",
            "sandram.gonzalez@mueblesalbura.com.co",
            "santiago.murillo@mueblesalbura.com.co"
        ];

        $emails_todos = [
            "leonardo.garcia@mueblesalbura.com.co",
            "cartera@mueblesalbura.com.co",
            "logistica@mueblesalbura.com.co",
            "asistente.logistica@mueblesalbura.com.co",
            "rosa.tellez@mueblesalbura.com.co",
            "auditoria.ppal@mueblesalbura.com.co",
            "salomon.hinojosa@mueblesalbura.com.co",
            "sst@mueblesalbura.com.co",
            "recursoshumanos@mueblesalbura.com.co",
            "paula.jimenez@mueblesalbura.com.co",
            "contabilidad@mueblesalbura.com.co",
            "cumplimiento@mueblesalbura.com.co",
            "autorizaciones@mueblesalbura.com.co",
            "asistentecontabilidad@mueblesalbura.com.co",
            "tesoreria@mueblesalbura.com.co",
            "web.developer@mueblesalbura.com.co",
            "sistemas@mueblesalbura.com.co",
            "asistentecomercial@mueblesalbura.com.co",
            "ventasenlinea@mueblesalbura.com.co",
            "sandram.gonzalez@mueblesalbura.com.co",
            "mariap.orrego@mueblesalbura.com.co",
            "ventasweb@mueblesalbura.com.co",
            "tiendaenlinea@mueblesalbura.com.co",
            "suministros@mueblesalbura.com.co",
            "serviciostecnicos@mueblesalbura.com.co",
            "bodega.ppal@mueblesalbura.com.co",
            "bodegamanizales@mueblesalbura.com.co",
            "bodegaibague@mueblesalbura.com.co",
            "bodegagirardot@mueblesalbura.com.co",
            "armenia02@mueblesalbura.com.co",
            "ibague04@mueblesalbura.com.co",
            "ibague25@mueblesalbura.com.co",
            "girardot27@mueblesalbura.com.co",
            "dosquebradas08@mueblesalbura.com.co",
            "pereira10@mueblesalbura.com.co",
            "girardot11@mueblesalbura.com.co",
            "neiva12@mueblesalbura.com.co",
            "manizales17@mueblesalbura.com.co",
            "cali36@mueblesalbura.com.co",
            "pereira28@mueblesalbura.com.co",
            "pereira14@mueblesalbura.com.co",
            "regional.pereira@mueblesalbura.com.co",
            "regional.armenia@mueblesalbura.com.co",
            "regional.ibague@mueblesalbura.com.co",
            "regional.girardot@mueblesalbura.com.co",
            "regional.piloto@mueblesalbura.com.co"
        ];

        foreach ($dptos as $key => $value) {
            switch ($value) {
                case 'LOGISTICA':
                    foreach ($emails_logistica as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case 'CARTERA':
                    foreach ($emails_cartera as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case 'VENTAS':
                    foreach ($emails_ventas as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case 'RRHH':
                    foreach ($emails_rrhh as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case 'AUDITORIA':
                    foreach ($emails_auditoria as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case 'CONTABILIDAD':
                    foreach ($emails_contabilidad as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case 'TESORERIA':
                    foreach ($emails_tesoreria as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case 'SISTEMAS':
                    foreach ($emails_sistemas as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case 'REGIONALES':
                    foreach ($emails_regionales as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case '002':
                    foreach ($emails_002 as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case '004':
                    foreach ($emails_004 as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case '008':
                    foreach ($emails_008 as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case '010':
                    foreach ($emails_010 as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case '011':
                    foreach ($emails_011 as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case '012':
                    foreach ($emails_012 as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case '014':
                    foreach ($emails_014 as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case '017':
                    foreach ($emails_017 as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case '025':
                    foreach ($emails_025 as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case '027':
                    foreach ($emails_027 as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case '028':
                    foreach ($emails_028 as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case '036':
                    foreach ($emails_036 as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case 'PPAL':
                    foreach ($emails_ppal as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case 'ALMACENES':
                    foreach ($emails_almacenes as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case 'FABRICA':
                    foreach ($emails_fabrica as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                case 'TODOS':
                    foreach ($emails_todos as $key => $value) {
                        array_push($correos_enviar, $value);
                    }
                    break;
                default:
                    array_push($correos_enviar, 'albura.development@gmail.com');
                    break;
            }
        }
        return $correos_enviar;
    }

    public function index(Request $request)
    {
        if ($request->has('notificar_usuarios')) {
            $dptos = $request->notificar_usuarios;
            $emails = self::GenerarEmailsEnviarNotificacion($dptos);

            $dpto = strtoupper($request->departamento);
            $seccion = strtoupper(str_replace('-', ' ', $request->seccion));

            Mail::send('apps.intranet.email.documento', ['docs' => session('nombre_documentacion_up'), 'dpto' => $dpto, 'carpeta' => $seccion, 'responsable' => Auth::user()->nombre], function ($mail) use ($emails) {
                $mail->to($emails);
                $mail->subject('Cargue de documentación INTRANET');
            });

            session()->forget('nombre_documentacion_up');

            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
