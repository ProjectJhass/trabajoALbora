<?php

namespace App\Http\Controllers\apps\intranet\Bitacora;

use App\Http\Controllers\Controller;
use App\Mail\NotificacionCambioEstado;
use App\Models\apps\intranet\Bitacora\ModelAdmin;
use App\Models\apps\intranet\Bitacora\ModelAsignado;
use App\Models\apps\intranet\Bitacora\ModelBitacoraSolicitudes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ControllerAsignado extends Controller
{
    public function index(Request $request)
    {
        $estado = $request->estado;
        $solicitudes = ModelAsignado::ObtenerSolicitudesProgreso($estado, Auth::user()->id);

        return view('apps.intranet.bitacora.asignado.proyectos', ['solicitudes' => $solicitudes]);
    }

    public function ObtenerInformacion(Request $request)
    {
        $puntos_ = [];
        $seguimiento_ = [];

        $id_solicitud = $request->idSolicitud;

        $usuarios = ModelAdmin::ObtenerUsuariosBD();
        $participantes = ModelAdmin::SolicitudesUsuarios($id_solicitud);

        $proyecto = ModelBitacoraSolicitudes::ObtenerSolicitudUser($id_solicitud);
        $documentos = ModelBitacoraSolicitudes::ObtenerDocumentosSolicitud($id_solicitud);

        $puntos = ModelBitacoraSolicitudes::ObtenerPuntosProyecto($id_solicitud);
        foreach ($puntos as $key => $value) {
            array_push($puntos_, ([
                'id_punto' => $value->id_punto,
                'punto' => $value->titulo_punto,
                'descripcion' => $value->descripcion_p,
                'prioridad' => $value->prioridad_p,
                'estado' => $value->estado_p,
                'porcentaje' => $value->porcentaje_p,
                'color' => $value->color_p,
                'seguimiento' => ModelBitacoraSolicitudes::ObtenerSegPuntosDocs($value->id_punto)
            ]));
        }

        $seguimiento = ModelAdmin::ObtenerSeguimientoSolicitud($id_solicitud);
        foreach ($seguimiento as $key => $val) {
            array_push($seguimiento_, ([
                'seguimiento' => $val->seguimiento,
                'responsable' => $val->responsable,
                'fecha' => date("Y-m-d", strtotime($val->fecha)),
                'documentos' => ModelAdmin::ObtenerDocumentosSegSolicitud($val->id_seguimiento)
            ]));
        }

        return view('apps.intranet.bitacora.asignado.informacion', ['proyecto' => $proyecto, 'documentos' => $documentos, 'puntos' => $puntos_, 'seguimiento' => $seguimiento_, 'usuarios' => $usuarios, 'participantes' => $participantes]);
    }

    public function agregarPuntosP(Request $request)
    {
        $id_solicitud = $request->idSolicitud;
        switch ($request->accion) {

            case 'agregar-seg-general':
                $comentario_seguimiento = $request->seguimiento_general;
                $data_seg = ([
                    'seguimiento' => $comentario_seguimiento,
                    'responsable' => Auth::user()->nombre,
                    'id_solicitud' => $id_solicitud,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                $response = ModelAdmin::AgregarSeguimientoSolicitud($data_seg);
                if ($response > 0) {
                    if ($request->hasFile('documentos_general')) {

                        $documentos = $request->file('documentos_general');

                        foreach ($documentos as $key => $value) {

                            $nombre = $value->getClientOriginalName();
                            $tipo = $value->getClientOriginalExtension();
                            $tama = filesize($value);

                            $nombre_doc = str_replace('.' . $tipo, '', $nombre);
                            $nombre_cargue = uniqid() . "_" . $nombre;


                            $response_file = $value->storeAs('public/bitacora/seguimientos/', $nombre_cargue);
                            $url_doc = Storage::url("bitacora/seguimientos/" . $nombre_cargue);

                            if ($response_file) {
                                $data_doc = ([
                                    'nom_doc_seg' => $nombre_doc,
                                    'doc_seg' => $nombre_cargue,
                                    'url_doc_seg' => $url_doc,
                                    'tipo_doc_seg' => $tipo,
                                    'tama_doc_seg' => $tama,
                                    'id_comentario_seg' => $response,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ]);
                                ModelAdmin::AgregarDocumentosSeguimientos($data_doc);
                            }
                        }
                    }
                    return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                }

                break;
            case 'agregar-seg-punto':
                if (!empty($request->id_punto_seg) && !empty($request->seguimiento_general)) {
                    $id_punto = $request->id_punto_seg;
                    $comentario = $request->seguimiento_general;
                    $data_s = ([
                        'seg_punto' => $comentario,
                        'responsable' => Auth::user()->nombre,
                        'id_punto_solicitud' => $id_punto,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    $id_comm_seg = ModelAdmin::AgregarSeguimientoPuntos($data_s);
                    if ($id_comm_seg > 0) {
                        if ($request->hasFile('documentos_general')) {

                            $documentos = $request->file('documentos_general');

                            foreach ($documentos as $key => $value) {

                                $nombre = $value->getClientOriginalName();
                                $tipo = $value->getClientOriginalExtension();
                                $tama = filesize($value);

                                $nombre_doc = str_replace('.' . $tipo, '', $nombre);
                                $nombre_cargue = uniqid() . "_" . $nombre;


                                $response_file = $value->storeAs('public/bitacora/seguimientos/', $nombre_cargue);
                                $url_doc = Storage::url("bitacora/seguimientos/" . $nombre_cargue);

                                if ($response_file) {
                                    $data_doc = ([
                                        'nom_doc_p' => $nombre_doc,
                                        'doc_punto' => $nombre_cargue,
                                        'url_doc_p' => $url_doc,
                                        'tipo_doc_p' => $tipo,
                                        'tama_doc_p' => $tama,
                                        'id_comment_seg_p' => $id_comm_seg,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]);
                                    ModelAdmin::AgregarDocsSeguimientoPuntos($data_doc);
                                }
                            }
                        }
                        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                    }
                }
                break;

            case 'actualizar-avance':

                $porcentaje_avance = $request->avance;

                $data_c = ModelAdmin::ObtenerSeguimientoPunto($request->id_punto);
                $porcentaje_actual = $data_c['valor'];

                $ban = $porcentaje_avance == $porcentaje_actual ? true : false;
                $porcentaje_n = !$ban ? ($porcentaje_avance + $porcentaje_actual) : $porcentaje_actual;
                $porcentaje_ttal = $porcentaje_n > 100 ? 100 : $porcentaje_n;
                $estado_ttal = $porcentaje_ttal == 100 ? 'Completado' : 'En proceso';

                $fecha_completado = ($estado_ttal != 'Completado') ? NULL : date('Y-m-d');

                $data_up = ([
                    'fecha_terminado_p' => $fecha_completado,
                    'estado_p' => $estado_ttal,
                    'porcentaje_p' => $porcentaje_ttal,
                    'color_p' => ($estado_ttal != 'Completado') ? 'info' : 'success',
                    'updated_at' => Carbon::now()
                ]);
                $response = ModelAdmin::ActualizarSeguimientoPunto($data_up, $request->id_punto);
                if ($response) {

                    $porcentaje = ModelAdmin::ObtenerPromedioPorc($data_c['id']);
                    $data_p = ([
                        'estado' => $porcentaje != 100 ? 'En proceso' : 'Completado',
                        'porcentaje' => round($porcentaje),
                        'color' => $porcentaje != 100 ? 'info' : 'success',
                        'updated_at' => Carbon::now()
                    ]);
                    ModelAdmin::ActualizarProyectoSolicitado($data_p, $data_c['id']);

                    if (round($porcentaje) == '100') {
                        $estado_val = ModelAdmin::ValidarEstadoActualizar('Completado', $data_c['id']);
                        if (!empty($estado_val)) {
                            Mail::to(ModelBitacoraSolicitudes::ObtenerEmailUser($estado_val))->cc('albura.development@gmail.com')->send(new NotificacionCambioEstado('#' . $data_c['id'], 'Completado', ''));
                        }
                    }

                    return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                }
                break;
        }
    }
}
