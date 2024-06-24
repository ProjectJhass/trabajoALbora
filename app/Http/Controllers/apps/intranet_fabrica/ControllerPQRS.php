<?php

namespace App\Http\Controllers\apps\intranet_fabrica;

use App\Http\Controllers\Controller;
use  App\Models\apps\intranet_fabrica\ModelPQRSFabrica;
use App\Models\apps\intranet_fabrica\orm\ModelRespuestaPQRS;
use App\Models\apps\intranet_fabrica\orm\ModelSolicitudesPQRS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ControllerPQRS extends Controller
{
    public function index() // vista por defecto -> PQRS pendientes
    {
        $pendientesTable = self::getSolicitudesPendientesTable();
        return view('apps.intranet_fabrica.fabrica.pqrs.pendientes', ['pendientesTable' => $pendientesTable]);
    }
    public function realizadas() // vista por defecto -> PQRS pendientes
    {
        $realizadosTable = self::getSolicitudesRealizadasTable();
        return view('apps.intranet_fabrica.fabrica.pqrs.realizadas', ['realizadosTable' => $realizadosTable]);
    }
    public function todas() // vista por defecto -> PQRS pendientes
    {
        $todosTable = self::getSolicitudesAllTable();
        return view('apps.intranet_fabrica.fabrica.pqrs.todas', ['todosTable' => $todosTable]);
    }
    public function nueva() // vista por defecto -> PQRS pendientes
    {
        return view('apps.intranet_fabrica.fabrica.pqrs.nueva');
    }
    public static function getSolicitudesAllTable()
    {
        $todos = ModelPQRSFabrica::getTodos();
        return view('apps.intranet_fabrica.fabrica.pqrs.tables.table-todos', ['data' => $todos]);
    }
    public static function getSolicitudesPendientesTable()
    {
        $pendientes = ModelPQRSFabrica::getPendientes();
        return view('apps.intranet_fabrica.fabrica.pqrs.tables.table-pendientes', ['data' => $pendientes]);
    }
    public static function getSolicitudesRealizadasTable()
    {
        $data = ModelPQRSFabrica::getRealizados();
        $realizados = [];
        foreach ($data as $index => $value) {
            $realizados[] = [
                'id' => $index + 1,
                'consecutivo' => $value->id,
                'estado' => $value->estado,
                'nombres' => $value->nombres,
                'apellidos' => $value->apellidos,
                'tipo_solicitud' => $value->tipo_solicitud,
            ];
        }
        return view('apps.intranet_fabrica.fabrica.pqrs.tables.table-realizados', ['data' => $realizados]);
    }

    public static function agregarNueva(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string',
            'apellidos' => 'required',
            'cargo' => 'required',
            'email' => 'required|email',
            'tipo' => 'required',
            'lugar' => 'required',
            'descripcion' => 'required',
            'anexos.*' => 'file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $dataEmail = ModelPQRSFabrica::createNueva($request->nombres, $request->apellidos, $request->cargo, $request->email, $request->tipo, $request->lugar, $request->descripcion);
        $id_pqrs = $dataEmail['numero_registro'];
        if ($request->hasFile('anexos')) {
            $anexos = $request->anexos;
            $payload = [];
            foreach ($anexos as $anexo) {
                $fileName = $anexo->getClientOriginalName();
                $fileExtension = $anexo->getClientMimeType();
                $fileSize = $anexo->getSize();
                $anexo->storeAs('public/archivos/' . $fileName);
                $payload[] = [$id_pqrs, $fileName, $fileExtension, $fileSize];
            }
            try {
                ModelPQRSFabrica::addAnexos($payload);
            } catch (\Throwable $th) {
                return response()->json(['error' => $th, 'message' => 'Error al agregar anexos.'], 500);
            }
        }
        $email = $request->email;
        $subject = "Registro Exitoso de Nueva PQRS";
        $view = 'apps.intranet_fabrica.fabrica.pqrs.emails.registro-exitoso';
        try {
            self::notificarSolicitudCreada($email, $subject, $dataEmail, $view);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th,  'message' => 'Error al enviar el correo electrónico.'], 500);
        }

        return response()->json(['response' => "PQRS creada satisfactoriamente", 'status' => true], 201, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public static function enviarEmail($emails, $subject, $dataEmail, $view)
    {
        Mail::send($view, ['data' => $dataEmail], function ($mail) use ($emails, $subject) {
            $mail->bcc($emails);
            $mail->subject($subject);
        });

        return true;
    }
    public static function notificarSolicitudCreada($email, $subject, $dataEmail, $view)
    {
        $emails = [$email, 'viviana.romero@mueblesalbura.com.co', 'diana.mora@mueblesalbura.com.co', 'sgc@mueblesalbura.com.co'];
        return self::enviarEmail($emails, $subject, $dataEmail, $view);
    }
    public static function responderSolicitud(Request $request)
    {
        $id = $request->id;
        $respuesta = ModelPQRSFabrica::responderSolicitud($id,  $request->respuesta);
        if ($respuesta) {

            $solicitud = ModelSolicitudesPQRS::find($id);
            $solicitud->update([
                'estado' => "Realizado",
            ]);
            $email = $respuesta->email;
            $subject = "Respuesta PQRS";
            $view = 'apps.intranet_fabrica.fabrica.pqrs.emails.respuesta-solicitud';
            try {
                self::enviarEmail($email, $subject, $respuesta, $view);
            } catch (\Throwable $th) {
                return response()->json(['error' => $th,  'message' => 'Error al enviar el correo electrónico.'], 500);
            }
            return response()->json(['response' => 'Respuesta registrada correctamente', 'status' => true], 201, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
    public static function showDetalleSolicitud(Request $request)
    {
        $id = $request->id;
        $solicitud = ModelSolicitudesPQRS::with(['infoAnexos', 'infoRespuestas'])->where("id", $id)->get();
        return view('apps.intranet_fabrica.fabrica.pqrs.detalleSolicitud', ['data' => $solicitud]);
    }
}
