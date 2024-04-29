<?php

namespace App\Http\Controllers\apps\intranet\Bitacora;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\Bitacora\ModelBitacoraSolicitudes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ControllerProyectos extends Controller
{
    
 public function EnviarNotificacion($tarea, $consecutivo, $tipo, $id_asignado, $cc)
 {
     $email = ModelBitacoraSolicitudes::ObtenerEmailUser($id_asignado);
     $email_cc = $cc == 1 ? 'albura.development@gmail.com' : 'web.developer@mueblesalbura.com.co';
     Mail::send('email.asignacion_proyecto', ['tarea' => $tarea, 'consecutivo' => $consecutivo, 'tipo' => $tipo], function ($mail) use ($email, $email_cc) {
         $mail->to($email);
         $mail->cc($email_cc);
         $mail->subject('Asignación de tarea');
     });
 }

 public function crearNuevoProyecto(Request $request)
 {
     $request->validate([
         'tipo_proyecto' => 'required',
         'nombre_proyecto' => 'required',
         'descripcion_p' => 'required',
         'documentos_proyecto' => 'required'
     ]);

     $tipo_proyecto = $request->tipo_proyecto;
     $nombre_proyecto = $request->nombre_proyecto;
     $descripcion = $request->descripcion_p;

     $asignado = '1007328932';

     if ($request->hasFile('documentos_proyecto')) {

         $documentos = $request->file('documentos_proyecto');

         $data = ([
             'tipo_solicitud' => $tipo_proyecto,
             'nombre_solicitud' => $nombre_proyecto,
             'descripcion' => $descripcion,
             'fecha_creacion' => date('Y-m-d'),
             'estado' => 'creada',
             'porcentaje' => '0',
             'color' => 'danger',
             'id_solicitante' => Auth::user()->id,
             'nombre_solicitante' => Auth::user()->nombre,
             'categoria' => Auth::user()->dpto_user,
             'organizacion' => Auth::user()->dpto_user,

             'created_at' => Carbon::now(),
             'updated_at' => Carbon::now()
         ]);

         $reponse_id = ModelBitacoraSolicitudes::CrearNuevaSolicitud($data);

         if ($reponse_id > 0) {

             ModelBitacoraSolicitudes::AsignarProyecto($reponse_id, $asignado);

             foreach ($documentos as $key => $value) {

                 $nombre = $value->getClientOriginalName();
                 $tipo = $value->getClientOriginalExtension();
                 $tama = filesize($value);

                 $nombre_doc = str_replace('.' . $tipo, '', $nombre);
                 $nombre_cargue = uniqid() . "_" . $nombre;


                 $response_file = $value->storeAs('public/bitacora/', $nombre_cargue);
                 $url_doc = Storage::url("bitacora/" . $nombre_cargue);

                 if ($response_file) {
                     $data_doc = ([
                         'nombre_documento' => $nombre_doc,
                         'documento' => $nombre_cargue,
                         'url_doc' => $url_doc,
                         'tipo_doc' => $tipo,
                         'tama_doc' => $tama,
                         'id_solicitud' => $reponse_id,
                         'created_at' => Carbon::now(),
                         'updated_at' => Carbon::now()
                     ]);

                     ModelBitacoraSolicitudes::CargarDocumentosProyecto($data_doc);
                 }
             }

             self::EnviarNotificacion($nombre_proyecto, $reponse_id, $tipo_proyecto, $asignado, '1');

             return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
         }
     }
 }
}
