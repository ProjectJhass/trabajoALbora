<?php

namespace App\Http\Controllers\apps\control_madera;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\ModelConsecutivosFallidos;
use App\Models\apps\control_madera\ModelConsecutivosMadera;
use App\Models\apps\control_madera\ModelEtiquetasEnCustodia;
use App\Models\apps\control_madera\ModelInfoMadera;
use App\Models\apps\control_madera\ModelInfoMaquilla;
use App\Models\apps\control_madera\ModelInfoPrinter;
use App\Models\apps\control_madera\ModelInspeccionMateriaPrima;
use App\Models\apps\control_madera\ModelLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class ControllerPrinterQr extends Controller
{
    public function index()
    {
        $custodia = ModelEtiquetasEnCustodia::where("estado", "Sin procesar")->get();
        $data = ModelInfoPrinter::where('estado', '1')->get();
        $madera = ModelInfoMadera::where('estado', '1')->get();
        $info = $data->first();
        $conexion = $info->conexion;

        if ($info->conexion == 'red') {
            $estado = self::statusPrinter($info->ip, $info->puerto);
        } else {
            $estado = 'Impresora por cable';
        }

        $impresas = self::getInfoImpresiones();

        return view('apps.control_madera.app.printer.print', ['impresora' => $info, 'conexion' => $conexion, 'estado' => $estado, 'madera' => $madera, 'custodia' => $custodia, 'historyPrint' => $impresas]);
    }

    public function getInfoImpresiones()
    {
        $hoy = date('Y-m-d');
        $hoy_ = date('Y-m-d', strtotime(date("Y-m-d") . " + 1 day"));
        $info = ModelInspeccionMateriaPrima::whereBetween("created_at", [$hoy, $hoy_])->get();
        return view("apps.control_madera.app.printer.impresionesRealizadas", ["data" => $info])->render();
    }

    //Configuración y registrar nueva impresora en red

    public function tablePrinters()
    {
        $data = ModelInfoPrinter::all();
        return view('apps.control_madera.app.printer.config.table', ['info' => $data])->render();
    }

    public function config()
    {
        $printers = self::tablePrinters();
        return view('apps.control_madera.app.printer.config.config_printer', ['impresoras' => $printers]);
    }

    public function saveConfig(Request $request)
    {
        if ($request->isMethod("post")) {
            $id = $request->id_impresora;
            $nombre = $request->nombre_impresora;
            $ip = $request->ip_impresora;
            $puerto = $request->puerto_impresora;
            $conexion = $request->conexion_impresora;
            $impresora = $request->tipo_impresora;
            $estado = $request->estado_impresora;

            if ($estado == 1) {
                ModelInfoPrinter::where("estado", "1")->update(["estado" => "0"]);
            }

            if (empty($id)) {
                $response = ModelInfoPrinter::create([
                    'nombre' => $nombre,
                    'ip' => $ip,
                    'puerto' => $puerto,
                    'conexion' => $conexion,
                    'impresora' => $impresora,
                    'estado' => $estado
                ]);
                if ($response) {
                    $table = self::tablePrinters();
                    return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                } else {
                    return response()->json('', 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                }
            } else {
                $data = ModelInfoPrinter::find($id);
                $data->nombre = $nombre;
                $data->ip = $ip;
                $data->puerto = $puerto;
                $data->conexion = $conexion;
                $data->impresora = $impresora;
                $data->estado = $estado;
                $data->save();

                $table = self::tablePrinters();
                return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }
    }

    public function search_info(Request $request)
    {
        $data = ModelInfoPrinter::find($request->id);
        $id = $data->id;
        $nombre = $data->nombre;
        $ip  = $data->ip;
        $puerto = $data->puerto;
        $conexion = $data->conexion;
        $impresora = $data->impresora;
        $estado = $data->estado;

        $info  = array('Id' => $id, 'Nombre' => $nombre, "Ip" => $ip, "Puerto" => $puerto, "Estado" => $estado, 'Conexion' => $conexion, 'Impresora' => $impresora);
        return response()->json(['status' => true, 'info' => $info], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function printerUSB($cantidad_marquillas, $impresora, $id_inspeccion, $tipo_madera, $tipo_impresora)
    {
        $ultimoId = ModelConsecutivosMadera::max('id');
        $ultimoId = $ultimoId + 1;
        $consecutivo_ = $ultimoId;

        $printed_pages = 0;
        $error_printed = 0;

        for ($i = 0; $i < $cantidad_marquillas; $i++) {
            if (!self::sendToPrintUSB($printed_pages, $error_printed, $consecutivo_, $id_inspeccion, $tipo_madera, $impresora, $tipo_impresora)) {
                continue;
            }
            $consecutivo_++;
        }

        return ([$printed_pages, $error_printed, 'Impresora por cable']);
    }

    public function sendToPrintUSB(&$printed_pages, &$error_printed, $consecutivo, $id_, $madera_, $impresora, $tipo_impresora)
    {
        try {
            $connector = new WindowsPrintConnector($impresora);
            $printer = new Printer($connector);

            $printer->setJustification(1);

            if ($tipo_impresora == "zebra") {
                $printer->text(self::crearPdfZpl($consecutivo));
            } else {
                $printer->qrCode($consecutivo, 3, 16);
                $printer->feed(3);
                $printer->setFont(1);
                $printer->setTextSize(4, 4);
                $printer->text($consecutivo);
            }
            $printer->feed(5);
            $printer->cut();
            $printer->close();

            ModelConsecutivosMadera::create([
                'id' => $consecutivo,
                'estado' => 'Pendiente',
                'id_info_madera' => $id_,
                'tipo_madera' => $madera_,
                'usuario_creacion' => Auth::user()->nombre
            ]);

            $printed_pages++;

            return true;
        } catch (\Exception $e) {

            $info_error_printed = ModelConsecutivosFallidos::where("consecutivo", $consecutivo)->first();
            if ($info_error_printed) {
                $info_error_printed->id_impresion = $id_;
                $info_error_printed->tipo_madera = $madera_;
                $info_error_printed->save();
            } else {
                ModelConsecutivosFallidos::create([
                    'consecutivo' => $consecutivo,
                    'id_impresion' => $id_,
                    'tipo_madera' => $madera_,
                    'estado' => 'Fallido'
                ]);
            }
            $error_printed++;
            return false;
        }
    }


    public function crearPdfZpl($consecutivo)
    {
        $info = ModelInfoMaquilla::where('estado', '1')->get();
        $data = $info->first();
        $codigoZPL = base64_decode($data->marquilla);
        $codigoZPL = str_replace("<CONSECUTIVO_ALBURA>", $consecutivo, $codigoZPL);

        return $codigoZPL;
    }

    public function designMarquilla($codigoZPL)
    {
        $zpl = $codigoZPL;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://api.labelary.com/v1/printers/8dpmm/labels/4x6/0/");
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $zpl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        // curl_setopt($curl, CURLOPT_HTTPHEADER, array("Accept: application/pdf"));
        $result = curl_exec($curl);

        if (curl_getinfo($curl, CURLINFO_HTTP_CODE) == 200) {
            $file = fopen("marquilla/label.png", "w");
            fwrite($file, $result);
            fclose($file);
            return true;
        } else {
            return false;
        }

        curl_close($curl);
    }

    public function statusPrinter($ip, $puerto)
    {
        $printer_ip = $ip;
        $printer_port = $puerto;

        $socket = @stream_socket_client("tcp://$printer_ip:$printer_port", $errno, $errstr, 2);
        if (!$socket) {
            return "Error al conectar la impresora";
        }

        stream_set_timeout($socket, 2); // Establecer un tiempo de espera de lectura/escritura de 2 segundos

        // Intentar leer algún dato de la impresora para verificar la conexión
        $data = fread($socket, 1024);
        if ($data === false) {
            fclose($socket);
            return "Impresora sin conexión";
        }

        fclose($socket);
        return "Impresora en línea";
    }

    // Funcionalidad de impresora e imprimir documentos

    public function printInformacion($cantidad, $id_insert, $tipo_madera)
    {
        $cantidad = $cantidad;
        $data = ModelInfoPrinter::where('estado', '1')->get();
        $info = $data->first();

        //Imprimir impresora por red
        $printer_ip = $info->ip;
        $printer_port = $info->puerto;

        //Tipo de impresora
        $printer_tipo = $info->impresora;

        //Cantidad de impresiones
        $total_pages = $cantidad;
        //Ultimo consecutivo impreso
        $ultimoId = ModelConsecutivosMadera::max('id');
        $ultimoId = $ultimoId + 1;

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket === false) {
            return response()->json(['status' => false, 'mensaje' => 'Error de conexión', 'impresora' => 'Error al conectar la impresora'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        $result = socket_connect($socket, $printer_ip, $printer_port);
        if ($result === false) {
            return response()->json(['status' => false, 'mensaje' => 'Error de conexión', 'impresora' => 'Impresora sin conexión'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        $printed_pages = 0;
        $error_printed = 0;

        // Enviar el contenido a la impresora para cada página
        $consecutivo_ = $ultimoId;
        for ($page = 0; $page < $total_pages; $page++) {

            $codigoZPL = self::crearPdfZpl($consecutivo_);

            if ($printer_tipo == "zebra") {
                $content_to_print = $codigoZPL;
            } else {
                self::designMarquilla($codigoZPL);
                $content_to_print = file_get_contents(asset('marquilla/label.png'));
            }

            if (!self::sendPageToPrinter($socket, $content_to_print, $printed_pages, $error_printed, $consecutivo_, $id_insert, $tipo_madera)) {
                continue;
            }
            $consecutivo_++;
        }

        // Cerrar la conexión
        socket_close($socket);

        return ([$printed_pages, $error_printed, 'Impresora en linea']);
    }

    // Función para enviar una página a la impresora
    public function sendPageToPrinter($socket, $content_to_print, &$printed_pages, &$error_printed, $consecutivo, $id_, $madera_)
    {
        if (socket_write($socket, $content_to_print, strlen($content_to_print)) === false) {
            $info_error_printed = ModelConsecutivosFallidos::where("consecutivo", $consecutivo)->first();
            if ($info_error_printed) {
                $info_error_printed->id_impresion = $id_;
                $info_error_printed->tipo_madera = $madera_;
                $info_error_printed->save();
            } else {
                ModelConsecutivosFallidos::create([
                    'consecutivo' => $consecutivo,
                    'id_impresion' => $id_,
                    'tipo_madera' => $madera_,
                    'estado' => 'Fallido'
                ]);
            }

            $error_printed++;
            return false;
        }
        ModelConsecutivosMadera::create([
            'id' => $consecutivo,
            'estado' => 'Pendiente',
            'id_info_madera' => $id_,
            'tipo_madera' => $madera_,
            'usuario_creacion' => Auth::user()->nombre
        ]);
        $printed_pages++;
        return true;
    }

    public function generateQRCode(Request $request)
    {
        $cantidad_bloques = $request->txt_cantidad_bloques;
        $cantidad_marquillas = $request->txt_cantidad_print;
        $tipo_madera = $request->txt_tipo_madera;
        $subproceso = $request->subproceso;
        $vehiculo = $request->tipo_vehiculo;
        $placa = $request->txt_placa;
        $salvo_conducto = $request->txt_salvo_conducto;
        $consecutivo_ = $request->consecutivo;

        if ($cantidad_bloques != $cantidad_marquillas) {
            return response()->json(['status' => false, 'mensaje' => 'La cantidad de bloques y marquillas debe ser el mismo', 'impresora' => 'Impresora en línea'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        $query = ModelInfoPrinter::where('estado', '1')->get();
        if ($query->isEmpty()) {
            return response()->json(['status' => false, 'mensaje' => 'Debe habilitar una impresora para imprimir', 'impresora' => 'No hay impresoras'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        $impresora = $query->first();

        $nombre_print = $impresora->nombre;
        $conexion_ = $impresora->conexion;
        $tipo_ = $impresora->impresora;

        if (empty($consecutivo_)) {

            if (empty($cantidad_bloques) || empty($cantidad_marquillas) || empty($tipo_madera) || empty($subproceso) || empty($vehiculo)) {
                return response()->json(['status' => false, 'mensaje' => 'Debe llenar los campos obligatorios *', 'impresora' => 'Impresora en línea'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }

            $madera_ = ModelInfoMadera::find($tipo_madera);
            $nombre_madera = $madera_->nombre_madera;
            $incial_madera = substr($nombre_madera, 0, 1);

            $response = ModelInspeccionMateriaPrima::create([
                'id_madera' => $tipo_madera,
                'madera' => $nombre_madera,
                'tipo_vehiculo' => $vehiculo,
                'placa' => $placa,
                'conducto' => $salvo_conducto,
                'subproceso' => $subproceso,
                'total_bloques' => $cantidad_bloques,
                'usuario_creacion' => Auth::user()->nombre
            ]);

            $id_insert = $response->id;
        } else {
            $info_p = ModelInspeccionMateriaPrima::find($consecutivo_);
            $response = true;
            $id_insert = $consecutivo_;

            $cantidad_db = $info_p->total_bloques;
            $info_p->total_bloques = $cantidad_db + $cantidad_bloques;
            $info_p->save();

            $madera_ = ModelInfoMadera::find($info_p->id_madera);
            $nombre_madera = $madera_->nombre_madera;
            $incial_madera = substr($nombre_madera, 0, 1);
        }

        if ($response) {
            if ($conexion_ == 'red') {
                $info_printer = self::printInformacion($cantidad_marquillas, $id_insert, $incial_madera);
            } else {
                $info_printer = self::printerUSB($cantidad_marquillas, $nombre_print, $id_insert, $incial_madera, $tipo_);
            }

            $etiquetas_impresas = $info_printer[0];

            if (isset($request->etiquetas_custodia)) {
                $cantidad_c = $request->cant_etiquetas_custodia;

                $info_ = ModelEtiquetasEnCustodia::where("estado", "Sin procesar")->get();
                foreach ($info_ as $key => $value) {
                    $id_consecutivo = $value->id_consecutivo;
                    $info_consec = ModelConsecutivosMadera::find($id_consecutivo);
                    $info_consec->id_info_madera = $id_insert;
                    $info_consec->tipo_madera = $incial_madera;
                    $info_consec->usuario_creacion = Auth::user()->nombre;
                    $info_consec->estado = "Pendiente";
                    $info_consec->save();
                    ModelEtiquetasEnCustodia::where("estado", "Sin procesar")->where("id", $value->id)->update(['id_nueva_imp' => $id_insert, 'estado' => 'Procesado']);
                }

                $info_madera_p = ModelInspeccionMateriaPrima::find($id_insert);
                $cantidad_db = $info_madera_p->total_bloques;
                $info_madera_p->total_bloques = $cantidad_db + $cantidad_c;
                $info_madera_p->save();

                $etiquetas_impresas = $etiquetas_impresas + $cantidad_c;
            }

            $print_qr = new ControllerPrinterQr();
            $table = $print_qr->getInfoImpresiones();

            return response()->json(['status' => true, 'impresas' => $etiquetas_impresas, 'fallidas' => $info_printer[1], 'impresora' => $info_printer[2], 'id_printed' => $id_insert, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        return response()->json('', 401);
    }

    public function printedHistory(Request $request)
    {
        $tipo = $request->tipo;
        $id_printed =  $request->id_printed;

        if ($id_printed == 0) return response()->json(['status' => false, 'mensaje' => 'No hay información para mostrar'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);

        if ($tipo == 1) {
            $data = ModelConsecutivosMadera::select('id')->where('id_info_madera', $id_printed)->get();
        } else {
            $data = ModelConsecutivosFallidos::select('consecutivo as id')->where('id_impresion', $id_printed)->get();
        }

        $view = view('apps.control_madera.app.printer.history_printed', ['data' => $data, 'tipo' => $tipo])->render();

        return response()->json(['status' => false, 'mensaje' => $view], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function rePrintedNumber(Request $request)
    {
        $tipo =  $request->tipo;
        $consecutivo_  = $request->consecutivo;
        $id_madera  = $request->id_madera;

        //
        $madera_ = ModelInfoMadera::find($id_madera);
        $nombre_madera = $madera_->nombre_madera;
        $incial_madera = substr($nombre_madera, 0, 1);

        //
        $printer_tipo = '';
        $name_printer = '';

        if ($tipo == 1) {
            $data_consec = ModelConsecutivosMadera::find($consecutivo_);
            $data_consec->delete();
        } else {
            ModelConsecutivosFallidos::where('id_impresion', $id_madera)->where('consecutivo', $consecutivo_)->first()->delete();
        }

        ModelLogs::create([
            'accion' => 'El usuario ' . Auth::user()->nombre . ' ha re-impreso el consecutivo del bloque #' . $consecutivo_
        ]);

        $printed_pages = 0;
        $error_printed = 0;

        if ($printer_tipo == 'red') {

            $printer_ip = '1';
            $printer_port = '1';

            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            if ($socket === false) {
                return response()->json(['status' => false, 'mensaje' => 'Error de conexión', 'impresora' => 'Error al conectar la impresora'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }

            $result = socket_connect($socket, $printer_ip, $printer_port);
            if ($result === false) {
                return response()->json(['status' => false, 'mensaje' => 'Error de conexión', 'impresora' => 'Impresora sin conexión'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }

            $codigoZPL = self::crearPdfZpl($consecutivo_);

            if ($printer_tipo == "zebra") {
                $content_to_print = $codigoZPL;
            } else {
                self::designMarquilla($codigoZPL);
                $content_to_print = file_get_contents(asset('marquilla/label.png'));
            }

            if (!self::sendPageToPrinter($socket, $content_to_print, $printed_pages, $error_printed, $consecutivo_, $id_madera, $incial_madera)) {
                '';
            }
        } else {

            if (!self::sendToPrintUSB($printed_pages, $error_printed, $consecutivo_, $id_madera, $incial_madera, $name_printer, $printer_tipo)) {
                '';
            }
        }
    }

    public function infoRePrinterCodigoQr(Request $request)
    {
        //Consecutivo impreso
        $consecutivo = $request->consecutivo;

        ModelLogs::create([
            'accion' => 'El usuario ' . Auth::user()->nombre . ' ha re-impreso el consecutivo del bloque #' . $consecutivo
        ]);

        //Validar existencia de consecutivo impreso
        $data_val = ModelConsecutivosMadera::find($consecutivo);

        //Configuración de la impresora
        $data_impresora = ModelInfoPrinter::where('estado', '1')->first();
        if ($data_impresora) {
            $conexion = $data_impresora->conexion;
            $tipo_impresora = $data_impresora->impresora;

            switch ($conexion) {
                case 'red':

                    $ip = $data_impresora->ip;
                    $puerto = $data_impresora->puerto;

                    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
                    socket_connect($socket, $ip, $puerto);

                    $codigoZPL = self::crearPdfZpl($consecutivo);

                    switch ($tipo_impresora) {
                        case 'zebra':
                            $content_to_print = $codigoZPL;
                            break;

                        default:
                            self::designMarquilla($codigoZPL);
                            $content_to_print = file_get_contents(asset('marquilla/label.png'));
                            break;
                    }

                    socket_write($socket, $content_to_print, strlen($content_to_print));
                    socket_close($socket);
                    break;
                case 'cable':
                    $connector = new WindowsPrintConnector($data_impresora->nombre);
                    $printer = new Printer($connector);

                    $printer->setJustification(1);

                    if ($tipo_impresora == "zebra") {
                        $printer->text(self::crearPdfZpl($consecutivo));
                    } else {
                        $printer->qrCode($consecutivo, 3, 16);
                        $printer->feed(3);
                        $printer->setFont(1);
                        $printer->setTextSize(4, 4);
                        $printer->text($consecutivo);
                    }
                    $printer->feed(5);
                    $printer->cut();
                    $printer->close();
                    break;
            }

            if (!$data_val) {

                $valor_fallido = ModelConsecutivosFallidos::where("consecutivo", $consecutivo)->first();
                if ($valor_fallido) {
                    $id_info_madera = $valor_fallido->id_impresion;
                    $tipo_madera = $valor_fallido->tipo_madera;

                    ModelConsecutivosMadera::create([
                        'id' => $consecutivo,
                        'estado' => 'Pendiente',
                        'id_info_madera' => $id_info_madera,
                        'tipo_madera' => $tipo_madera,
                        'usuario_creacion' => Auth::user()->nombre
                    ]);

                    $valor_fallido->delete();
                }
            }

            return response()->json(['status' => true, 'mensaje' => 'Consecutivo re-impreso'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
        return response()->json(['status' => false], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
