<?php

namespace App\Http\Controllers\apps\intranet\Bitacora;

use App\Http\Controllers\Controller;
use App\Mail\NotificacionCambioEstado;
use App\Models\apps\intranet\Bitacora\ModelAdmin;
use App\Models\apps\intranet\Bitacora\ModelBitacoraSolicitudes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\apps\intranet\Bitacora\ControllerProyectos as notificacion;
use App\Models\apps\intranet\Bitacora\ModelBitacora;

class ControllerAdmin extends Controller
{

    public function index()
    {
        $table = self::renderTableInfo('');
        return view('apps.intranet.bitacora.admin.proyectos', ['table' => $table]);
    }

    public function renderTableInfo($estado)
    {
        if ($estado == null || trim($estado) === "") {
            $solicitudes = ModelBitacora::where("estado", "<>", "Completado")->get();
        } else {
            $solicitudes = ModelBitacora::where("estado", $estado)->get();
        }
        return view('apps.intranet.bitacora.admin.table', ['solicitudes' => $solicitudes])->render();
    }

    public function getInfoSolicitudes(Request $request)
    {
        $estado = $request->estado;
        $table = self::renderTableInfo($estado);
        return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
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

        return view('apps.intranet.bitacora.admin.informacion', ['proyecto' => $proyecto, 'documentos' => $documentos, 'puntos' => $puntos_, 'seguimiento' => $seguimiento_, 'usuarios' => $usuarios, 'participantes' => $participantes]);
    }

    public function agregarPuntosP(Request $request)
    {
        $id_solicitud = $request->idSolicitud;
        switch ($request->accion) {
            case 'agregar-puntos':
                if (!empty($request->titulo_punto) && !empty($request->desciption_punto) && !empty($request->prioridad_punto)) {
                    $data = ([
                        'titulo_punto' => $request->titulo_punto,
                        'descripcion_p' => $request->desciption_punto,
                        'prioridad_p' => $request->prioridad_punto,
                        'estado_p' => 'Creado',
                        'porcentaje_p' => '0',
                        'color_p' => 'danger',
                        'id_solicitud' => $id_solicitud,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    if (ModelAdmin::CrearNuevoPuntoProyecto($data)) {
                        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                    }
                }
                break;
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
                $estado_ttal = $porcentaje_ttal == 100 ? 'Completado' : $request->estado;

                $data_up = ([
                    'prioridad_p' => $request->prioridad,
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
            case 'proyecto':

                $estado_s = $request->estado;
                $id_s = $request->idSolicitud;
                $solicitud = $request->nombre_solicitud;
                $prioridad = $request->prioridad;

                $estado_val = ModelAdmin::ValidarEstadoActualizar($estado_s, $id_s);

                $data_p = ([
                    'nombre_solicitud' => $solicitud,
                    'descripcion' => $request->descripcion,
                    'fecha_posible_entrega' => $request->fecha_p_entrega,
                    'estado' => $estado_s,
                    'prioridad' => $prioridad,
                    'updated_at' => Carbon::now()
                ]);
                $response = ModelAdmin::ActualizarProyectoSolicitado($data_p, $id_s);
                if ($response) {
                    if (!empty($estado_val)) {
                        Mail::to(ModelBitacoraSolicitudes::ObtenerEmailUser($estado_val))->cc('albura.development@gmail.com')->send(new NotificacionCambioEstado($solicitud, $estado_s, $prioridad));
                    }
                    return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                }
                break;
            case 'actualizar-participantes':

                if ($request->has('participantes_pr')) {
                    $cantidad_i = count($request->participantes_pr);
                    $participantes = ModelAdmin::CantidadInvolucrados($id_solicitud);
                    if ($cantidad_i >= $participantes) {
                        foreach ($request->participantes_pr as $key => $val) {
                            if (ModelAdmin::ValidarExistencia($id_solicitud, $val) == 0) {
                                $res = ModelBitacoraSolicitudes::AsignarProyecto($id_solicitud, $val);
                                if ($res) {
                                    $not = new notificacion();
                                    $not->EnviarNotificacion($request->proyecto, $id_solicitud, $request->tipo, $val, '2');
                                }
                            }
                        }
                    } else {
                        $text_user = implode(" and id_usuario <> ", $request->participantes_pr);
                        $consulta = "id_solicitud = '" . $id_solicitud . "' and (id_usuario <> " . $text_user . ")";
                        echo $consulta;
                        ModelAdmin::EliminarUsuariosProyecto($consulta);
                    }
                } else {
                    ModelAdmin::EliminarTodosUsuarios($id_solicitud);
                }

                return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);

                break;
        }
    }
}
