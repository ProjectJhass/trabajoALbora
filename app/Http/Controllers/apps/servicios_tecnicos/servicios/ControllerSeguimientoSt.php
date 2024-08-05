<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios;

use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\servicios\emailsAlmacenes;
use App\Models\apps\servicios_tecnicos\servicios\ModelDatosIngresoTaller;
use App\Models\apps\servicios_tecnicos\servicios\ModelDatosRecogida;
use App\Models\apps\servicios_tecnicos\servicios\ModelDefinirOrden;
use App\Models\apps\servicios_tecnicos\servicios\ModelEvidenciasIngresoTaller;
use App\Models\apps\servicios_tecnicos\servicios\ModelEvidenciasRecogidas;
use App\Models\apps\servicios_tecnicos\servicios\ModelEvidenciasSeguimiento;
use App\Models\apps\servicios_tecnicos\servicios\ModelEvidenciasVisita;
use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use App\Models\apps\servicios_tecnicos\servicios\ModelRespuestaFab;
use App\Models\apps\servicios_tecnicos\servicios\ModelSeguimientoGeneral;
use App\Models\apps\servicios_tecnicos\servicios\ModelSeguimientoTaller;
use App\Models\apps\servicios_tecnicos\servicios\ModelSeguimientoVisita;
use App\Models\apps\servicios_tecnicos\servicios\ModelValoracionFab;
use App\Models\apps\servicios_tecnicos\servicios\infoAlmacenes;
use App\Http\Controllers\apps\servicios_tecnicos\servicios\seguimiento\ControllerSeguimiento;
use App\Mail\NotificacionCliente;
use App\Mail\NotificacionDevolucionCliente;
use App\Mail\NotificacionNoGarantia;
use App\Mail\NotificacionRespuestaFab;
use App\Mail\NotificacionValoracionFab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ControllerSeguimientoSt extends Controller
{
    protected function mailCartaFab($id_st)
    {
        $info = ModelNuevaSolicitud::find($id_st);
        $item = $info->articulo;
        $proveedor = $info->proveedor;

        if ($proveedor == 'HAPPY SLEEP') {
            $emails = emailsAlmacenes::where('almacen', 'HAPPYSLEEP')->pluck('email')->toArray();
        } else {
            $emails = emailsAlmacenes::where('almacen', 'BODEGA_020')->pluck('email')->toArray();
        }

        Mail::to($emails)->later(now()->addSeconds(5), new NotificacionRespuestaFab($item, $id_st));
    }

    protected function mailCliente($id_st)
    {
        $info = ModelNuevaSolicitud::find($id_st);
        $almacen = $info->almacen;
        $proveedor = $info->proveedor;
        $email_cliente = $info->email;

        if (/*$proveedor == 'HAPPY SLEEP'*/$almacen == 'HAPPYSLEEP') {
            $emails = emailsAlmacenes::where('almacen', 'HAPPYSLEEP')->pluck('email')->toArray();
        } else {
            $emails = emailsAlmacenes::whereIn('almacen', [$almacen, 'BODEGA_020'])->pluck('email')->toArray();
            $emails[] = $email_cliente;
        }

        Mail::to($emails)->later(now()->addSeconds(5), new NotificacionCliente($info->id_st, $info->articulo, $info->respuesta_st));
    }

    protected function mailNoGarantia($id_st)
    {
        $info = ModelNuevaSolicitud::find($id_st);

        $proveedor = $info->proveedor;
        $concepto = $info->respuesta_st;
        $id = $info->id_st;
        $item = $info->articulo;

        if ($proveedor == 'HAPPY SLEEP') {
            $emails = emailsAlmacenes::where('almacen', 'HAPPYSLEEP')->pluck('email')->toArray();
        } else {
            $emails = emailsAlmacenes::where('almacen', 'BODEGA_020')->pluck('email')->toArray();
        }

        Mail::to($emails)->later(now()->addSeconds(5), new NotificacionNoGarantia($id, $concepto, $item));
    }

    public function mailValoracionFab($id_st)
    {
        $info = ModelNuevaSolicitud::find($id_st);

        if ($info->proveedor == "HAPPY SLEEP" || $info->almacen = "HAPPYSLEEP") {
            $emails = emailsAlmacenes::whereIn('almacen', ['FABRICA', 'HAPPYSLEEP'])->pluck('email')->toArray();
        } else {
            $emails = emailsAlmacenes::where('almacen', 'FABRICA')->pluck('email')->toArray();
        }

        Mail::to($emails)->later(now()->addSeconds(5), new NotificacionValoracionFab($info->articulo, $info->id_st));
    }

    protected function infoCountEstados($almacen, $query, $estado, $user)
    {
        if ($almacen == 'HAPPYSLEEP') {
            switch ($query) {
                case '1':
                    $valor = ModelNuevaSolicitud::where(function ($query) use ($almacen) {
                        $query->where('proveedor', 'HAPPY SLEEP')
                            ->orWhere('almacen', $almacen);
                    })->whereNotIn('estado', ['Recoger', 'Por definir', 'Definido', 'En devolucion'])->count();
                    break;
                case '2':
                    $valor = ModelNuevaSolicitud::where(function ($query) use ($almacen) {
                        $query->where('proveedor', 'HAPPY SLEEP')
                            ->orWhere('almacen', $almacen);
                    })->where('respuesta_st', 'No garantia')->where('estado', 'Por definir')->count();
                    break;
                case '3':
                    $valor = ModelNuevaSolicitud::where(function ($query) use ($almacen) {
                        $query->where('proveedor', 'HAPPY SLEEP')
                            ->orWhere('almacen', $almacen);
                    })->where('estado', $estado)->where('respuesta_st', '<>', 'No garantia')->count();
                case '4':
                    $valor = ModelNuevaSolicitud::where(function ($query) use ($almacen) {
                        $query->where('proveedor', 'HAPPY SLEEP')
                            ->orWhere('almacen', $almacen);
                    })->where('estado', $estado)->where('respuesta_st', '=', 'Definido')->count();
                    break;
            }
        } else {
            switch ($query) {
                case '1':
                    $valor = ModelNuevaSolicitud::whereNotIn('estado', ['Recoger', 'Por definir', 'Definido', 'En devolucion'])->count();
                    break;
                case '2':
                    $valor = ModelNuevaSolicitud::where('respuesta_st', 'No garantia')
                        ->where('estado', 'Por definir')
                        ->count();
                    break;
                case '3':
                    $valor = ModelNuevaSolicitud::where('estado', $estado)
                        ->where('respuesta_st', '<>', 'No garantia')
                        ->count();
                case '4':
                    $valor = ModelNuevaSolicitud::where('estado', $estado)
                        ->where('respuesta_st', '=', 'Definido')
                        ->count();
                    break;
            }
        }

        return $valor;
    }

    protected function getInfoEstado($proveedor, $estado, $almacen, $fecha_i, $fecha_f, $servicio)
    {
        if ($almacen == 'HAPPYSLEEP') {
            $info = ModelNuevaSolicitud::where(function ($query) use ($almacen) {
                $query->where('proveedor', 'HAPPY SLEEP')
                    ->orWhere('almacen', $almacen);
            })->where('estado', '=', $estado)->where('respuesta_st', '<>', 'No garantia');
        } else {
            $info = ModelNuevaSolicitud::where('estado', $estado)
                ->where('respuesta_st', '<>', 'No garantia');
        }
        if (!empty($almacen) && $almacen != 'PPAL') {
            $info->where('almacen', '=', $almacen);
        }
        if (!empty($fecha_i) && !empty($fecha_f)) {
            // Ambas fechas están presentes
            $info->whereBetween('servicios_tecnicos.created_at', [$fecha_i, $fecha_f]);
        } elseif (!empty($fecha_i)) {
            // Solo fecha de inicio
            $info->where('servicios_tecnicos.created_at', '>=', $fecha_i);
        } elseif (!empty($fecha_f)) {
            // Solo fecha final
            $info->where('servicios_tecnicos.created_at', '<=', $fecha_f);
        }
        if (!empty($servicio)) {
            $info->where('tipo_servicio', '=', $servicio);
        }
        if (!empty($proveedor)) {
            $info->where('servicios_tecnicos.proveedor', '=', $proveedor);
        }

        return view('apps.servicios_tecnicos.servicios_tecnicos.creados.table_seguimiento', ['st' => $info->get()])->render();
    }

    protected function getDefinirGar($proveedor, $concepto, $almacen, $fecha_i, $fecha_f, $servicio)
    {
        if ($almacen == 'HAPPYSLEEP') {
            $info = ModelNuevaSolicitud::where(function ($query) use ($almacen) {
                $query->where('proveedor', 'HAPPY SLEEP')
                    ->orWhere('almacen', $almacen);
            })->where('respuesta_st', $concepto)->where('estado', 'Por definir');
        } else {
            $info = ModelNuevaSolicitud::where('respuesta_st', $concepto)->where('estado', 'Por definir');
        }
        if (!empty($fecha_i) && !empty($fecha_f)) {
            // Ambas fechas están presentes
            $info->whereBetween('servicios_tecnicos.created_at', [$fecha_i, $fecha_f]);
        } elseif (!empty($fecha_i)) {
            // Solo fecha de inicio
            $info->where('servicios_tecnicos.created_at', '>=', $fecha_i);
        } elseif (!empty($fecha_f)) {
            // Solo fecha final
            $info->where('servicios_tecnicos.created_at', '<=', $fecha_f);
        }
        if (!empty($servicio)) {
            $info->where('tipo_servicio', '=', $servicio);
        }
        if (!empty($proveedor)) {
            $info->where('servicios_tecnicos.proveedor', '=', $proveedor);
        }

        return view('apps.servicios_tecnicos.servicios_tecnicos.creados.table_seguimiento', ['st' => $info->get()])->render();
    }

    protected function getInfoAllSt($proveedor, $id, $almacen, $fecha_i = null, $fecha_f = null, $servicio)
    {
        if ($almacen == 'BODEGA_020' ||  $almacen == 'PPAL') {
            $info = ModelNuevaSolicitud::whereNotIn('estado', ['Recoger', 'Por definir', 'Definido', 'En devolucion']);
            if (!empty($fecha_i) && !empty($fecha_f)) {
                // Ambas fechas están presentes
                $info->whereBetween('servicios_tecnicos.created_at', [$fecha_i, $fecha_f]);
            } elseif (!empty($fecha_i)) {
                // Solo fecha de inicio
                $info->where('servicios_tecnicos.created_at', '>=', $fecha_i);
            } elseif (!empty($fecha_f)) {
                // Solo fecha final
                $info->where('servicios_tecnicos.created_at', '<=', $fecha_f);
            }
            if (!empty($proveedor)) {
                $info->where('servicios_tecnicos.proveedor', '=', $proveedor);
            }
            if (!empty($servicio)) {
                $info->where('tipo_servicio', '=', $servicio);
            }
            return view('apps.servicios_tecnicos.servicios_tecnicos.creados.table_seguimiento', ['st' => $info->get()])->render();
        }

        switch ($almacen) {
            case 'HAPPYSLEEP':
                $info = ModelNuevaSolicitud::where(function ($query) use ($almacen) {
                    $query->where('proveedor', 'HAPPY SLEEP')
                        ->orWhere('almacen', $almacen);
                })->whereNotIn('estado', ['Recoger', 'Por definir', 'Definido', 'En devolucion']);
                break;

            default:
                $info = ModelNuevaSolicitud::whereNotIn('estado', ['Recoger', 'Por definir', 'Definido', 'En devolucion']);
                if (!empty($almacen)) {
                    $info->where('almacen', '=', $almacen);
                }
                break;
        }
        if (!empty($fecha_i) && !empty($fecha_f)) {
            // Ambas fechas están presentes
            $info->whereBetween('servicios_tecnicos.created_at', [$fecha_i, $fecha_f]);
        } elseif (!empty($fecha_i)) {
            // Solo fecha de inicio
            $info->where('servicios_tecnicos.created_at', '>=', $fecha_i);
        } elseif (!empty($fecha_f)) {
            // Solo fecha final
            $info->where('servicios_tecnicos.created_at', '<=', $fecha_f);
        }

        if (!empty($proveedor)) {
            $info->where('servicios_tecnicos.proveedor', '=', $proveedor);
        }
        if (!empty($servicio)) {
            $info->where('tipo_servicio', '=', $servicio);
        }
        return view('apps.servicios_tecnicos.servicios_tecnicos.creados.table_seguimiento', ['st' => $info->get()])->render();
    }

    protected function table_seguimiento()
    {
        $almacen = Auth::user()->almacen;
        $data_info = ModelNuevaSolicitud::where('almacen', $almacen)->where('estado', '<>', 'Definido')->get();
        return view('apps.servicios_tecnicos.servicios_tecnicos.creados.table_seguimiento', ['st' => $data_info])->render();
    }

    public function timeLineOst($id_st)
    {
        $data = ModelNuevaSolicitud::where('id_st', $id_st)->get();

        $comment_visita = ModelSeguimientoVisita::where('id_st', $id_st)->orderBy('created_at', 'desc')->get();
        $comment_general = ModelSeguimientoGeneral::where('id_st', $id_st)->orderBy('created_at', 'desc')->get();
        $valoracion = ModelValoracionFab::where('id_st', $id_st)->where('estado', '1')->orderBy('created_at', 'desc')->get();
        $recogida = ModelDatosRecogida::where('id_st', $id_st)->orderBy('created_at', 'desc')->get();
        $i_taller = ModelDatosIngresoTaller::where('id_st', $id_st)->get();
        $carta_ = ModelRespuestaFab::where('id_st', $id_st)->whereIn('estado', ['1', '2'])->get();

        $seg_taller = ModelSeguimientoTaller::with('evidencias')->where('id_st', $id_st)->orderBy('created_at', 'desc')->get();
        $datos = $seg_taller->map(function ($item) {
            return [
                'seguimiento' => $item->seguimiento,
                'responsable' => $item->responsable,
                'fecha' => $item->created_at,
                'evidencias' => $item->evidencias
            ];
        })->all();

        $collect_definir = ModelDefinirOrden::where('id_st', $id_st)->get();
        if ($collect_definir->isNotEmpty()) {
            $info_definir = $collect_definir->first();
            $comments = array([
                'fecha_responsable' => $info_definir->created_at->format('Y-m-d'),
                'comentario' => $info_definir->observaciones,
                'responsable' => $info_definir->responsable,
            ]);

            $url_d = $info_definir->url;
        } else {
            $url_d = '';
            $comments = array();
        }

        $coments = self::getComents($comment_visita);
        $coment_g = self::getComents($comment_general);
        $coment_d = self::getComentsDef($comments);
        $coment_seg = self::getseguimiento($datos);

        return  view('apps.servicios_tecnicos.servicios_tecnicos.gestion.formulario', [
            'data' => $data,
            'comment_g' => $coment_g,
            'comentarios_v' => $coments,
            'id_ost' => $id_st,
            'valoracion' => $valoracion,
            'com_definir' => $coment_d,
            'url_def' => $url_d,
            'recogida' => $recogida,
            'i_taller' => $i_taller,
            'seguimientos' => $coment_seg,
            'carta_respuesta' => $carta_
        ])->render();
    }

    protected function getComents($coments)
    {
        return view('apps.servicios_tecnicos.servicios_tecnicos.gestion.comentarios', ['data' => $coments])->render();
    }

    protected function getseguimiento($coments)
    {
        return view('apps.servicios_tecnicos.servicios_tecnicos.gestion.seguimiento_taller', ['data' => $coments])->render();
    }

    protected function getComentsDef($coments)
    {
        return view('apps.servicios_tecnicos.servicios_tecnicos.gestion.coment_def', ['data' => $coments])->render();
    }

    public function home_st()
    {
        $almacen_p = Auth::user()->almacen;
        $id_user = Auth::user()->id;
        $proveedor = Auth::user()->empresa;
        $almacenes = infoAlmacenes::all();
        $table = self::getInfoAllSt($proveedor, $id_user, $almacen_p, '', '', '');

        $vlrs = array([
            'proceso' => self::infoCountEstados($almacen_p, 1, '', $id_user),
            'garantia' => self::infoCountEstados($almacen_p, 2, '', $id_user),
            'recoger' => self::infoCountEstados($almacen_p, 3, 'Recoger', $id_user),
            'definir' => self::infoCountEstados($almacen_p, 3, 'En devolucion', $id_user), //por definir
            'historial' => self::infoCountEstados($almacen_p, 4, 'Definido', $id_user)
        ]);

        return view('apps.servicios_tecnicos.servicios_tecnicos.creados.seguimiento', ['table' => $table, 'valores' => $vlrs, 'almacenes' => $almacenes]);
    }

    public function viewInfoGeneralOst(Request $request)
    {
        $id_st = $request->id_st;
        $seccion = $request->seccion;
        $form = self::timeLineOst($id_st);
        return view('apps.servicios_tecnicos.servicios_tecnicos.gestion.orden_st', ['form' => $form, 'seccion' => $seccion]);
    }

    public function getViewInfoEvidencias($id_st, $estado_ost, $seccion)
    {
        switch ($seccion) {
            case 'visita':
                $img = ModelEvidenciasVisita::where('id_st', $id_st)->get();
                break;
            case 'recogida':
                $img = ModelEvidenciasRecogidas::where('id_st', $id_st)->get();
                break;
            case 'taller_ingreso':
                $img = ModelEvidenciasIngresoTaller::where('id_st', $id_st)->where('tabla', 'taller_ingreso')->get();
                break;
            case 'taller_reparado':
                $img = ModelEvidenciasIngresoTaller::where('id_st', $id_st)->where('tabla', 'taller_reparado')->get();
                break;
        }

        return view('apps.servicios_tecnicos.servicios_tecnicos.gestion.evidencias', ['evidencias' => $img, 'id_st' => $id_st, 'estado' => $estado_ost, 'seccion' => $seccion])->render();
    }

    public function getInfoEvidenciasSt(Request $request)
    {
        $id_st = $request->id_st;
        $estado_ost = $request->estado;

        $seccion = $request->seccion;
        $categoria = $request->categoria;

        $info = self::getViewInfoEvidencias($id_st, $estado_ost, $seccion, $categoria);
        return response()->json(['evidencias' => $info], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function deleteInfoEvidenciasSt(Request $request)
    {
        $id = $request->id;
        $seccion = $request->seccion;
        $categoria = $request->categoria;

        switch ($seccion) {
            case 'visita':
                $evidencia = ModelEvidenciasVisita::findOrFail($id);
                $id_st = $evidencia->id_st;

                $name = str_replace("/storage/", "", $evidencia->url);

                if (Storage::exists("public/" . $name)) {
                    Storage::delete("public/" . $name);
                }

                ModelEvidenciasVisita::where('id', $id)->delete();
                $img = ModelEvidenciasVisita::where('id_st', $id_st)->get();

                break;
            case 'recogida':
                $evidencia = ModelEvidenciasRecogidas::findOrFail($id);
                $id_st = $evidencia->id_st;

                $name = str_replace("/storage/", "", $evidencia->url);

                if (Storage::exists("public/" . $name)) {
                    Storage::delete("public/" . $name);
                }
                ModelEvidenciasRecogidas::where('id', $id)->delete();
                $img = ModelEvidenciasRecogidas::where('id_st', $id_st)->get();
                break;
            case 'taller_ingreso': //ModelEvidenciasIngresoTaller
                $evidencia = ModelEvidenciasIngresoTaller::findOrFail($id);
                $id_st = $evidencia->id_st;

                $name = str_replace("/storage/", "", $evidencia->url);

                if (Storage::exists("public/" . $name)) {
                    Storage::delete("public/" . $name);
                }
                ModelEvidenciasIngresoTaller::where('id', $id)->delete();
                $img = ModelEvidenciasIngresoTaller::where('id_st', $id_st)->where('tabla', 'taller_ingreso')->get();
                break;
            case 'taller_reparado':
                $evidencia = ModelEvidenciasIngresoTaller::findOrFail($id);
                $id_st = $evidencia->id_st;

                $name = str_replace("/storage/", "", $evidencia->url);

                if (Storage::exists("public/" . $name)) {
                    Storage::delete("public/" . $name);
                }
                ModelEvidenciasIngresoTaller::where('id', $id)->delete();
                $img = ModelEvidenciasIngresoTaller::where('id_st', $id_st)->where('tabla', 'taller_reparado')->get();
                break;
        }

        $info = view('apps.servicios_tecnicos.servicios_tecnicos.gestion.evidencias', ['evidencias' => $img, 'id_st' => $id_st, 'estado' => '', 'seccion' => $seccion, 'categoria' => $categoria])->render();

        return response()->json(['evidencias' => $info], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function updateInfoEvidenciasVisita(Request $request)
    {
        if ($request->hasFile('evidencias_visita')) {

            $id_ost = $request->id_ev_ost;

            $ost = ModelNuevaSolicitud::find($id_ost);
            $concepto_fab = $ost->respuesta_st;

            $addEvidencias = new ControllerNuevaSolicitud();

            $responsable = Auth::user()->nombre;
            $fecha = date('Y-m-d');

            $addEvidencias->addEvidenciasSt($id_ost, $request->file('evidencias_visita'), $request->observaciones_visita, $responsable, $fecha, $concepto_fab);
            $form = self::timeLineOst($id_ost);

            return response()->json(['form' => $form], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
        return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function modelInfoEvidenciasOst($seccion, $name_, $tipo, $tama, $url_doc, $id_ost)
    {
        switch ($seccion) {
            case 'visita':
                ModelEvidenciasVisita::create([
                    'nombre_img' => $name_,
                    'tipo' => $tipo,
                    'tama' => $tama,
                    'url' => $url_doc,
                    'tabla' => 'visita',
                    'id_comentario' => '0',
                    'id_st' => $id_ost
                ]);
                break;
            case 'recogida':
                ModelEvidenciasRecogidas::create([
                    'nombre_img' => $name_,
                    'tipo' => $tipo,
                    'tama' => $tama,
                    'url' => $url_doc,
                    'tabla' => 'recogida',
                    'id_comentario' => '0',
                    'id_st' => $id_ost
                ]);
                break;
            case 'taller_ingreso':
                ModelEvidenciasIngresoTaller::create([
                    'nombre_img' => $name_,
                    'tipo' => $tipo,
                    'tama' => $tama,
                    'url' => $url_doc,
                    'tabla' => 'taller_ingreso',
                    'id_comentario' => '0',
                    'id_st' => $id_ost
                ]);
                break;
            case 'taller_reparado':
                ModelEvidenciasIngresoTaller::create([
                    'nombre_img' => $name_,
                    'tipo' => $tipo,
                    'tama' => $tama,
                    'url' => $url_doc,
                    'tabla' => 'taller_reparado',
                    'id_comentario' => '0',
                    'id_st' => $id_ost
                ]);
                break;
        }
    }

    public function addEvidenciasSolicitudSt(Request $request)
    {
        $extensions = (['png', 'jpg', 'jpeg', 'tiff', 'webp', 'mp4']);

        if ($request->hasFile('file_evidencia_ost')) {
            $id_ost = $request->id_ost_evidencias;
            $seccion = $request->seccion_evidencias;
            $imagenes = $request->file_evidencia_ost;

            foreach ($imagenes as $file) {
                $tipo = $file->getClientOriginalExtension();

                if (in_array($tipo, $extensions)) {
                    $name_ = str_replace("." . $tipo, "", $file->getClientOriginalName());
                    $nombre = uniqid() . "_" . $file->getClientOriginalName();
                    $tama = filesize($file);

                    $response_file = $file->storeAs('public/evidencias', $nombre);
                    $url_doc = Storage::url("public/evidencias/" . $nombre);

                    if ($response_file) {
                        self::modelInfoEvidenciasOst($seccion, $name_, $tipo, $tama, $url_doc, $id_ost);
                    }
                }
            }

            $view_img = self::getViewInfoEvidencias($id_ost, '', $seccion);
            return response()->json(['evidencias' => $view_img], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
        return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function addComentariosGeneralesOst(Request $request)
    {
        $id = $request->id_ost;
        $comentario = $request->comentario;

        $response = ModelSeguimientoGeneral::create([
            'comentario' => $comentario,
            'responsable' => Auth::user()->nombre,
            'id_st' => $id,
            'fecha_responsable' => date('Y-m-d')
        ]);

        if ($response) {
            $form = self::timeLineOst($id);
            return response()->json(['form' => $form], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function addValoracionFabrica(Request $request)
    {
        $concepto = $request->concepto_valoracion;
        $responsable = Auth::user()->nombre;

        if (!empty($concepto) && !empty($responsable)) {

            $observaciones = $request->observaciones_valoracion;

            $diagnostico = $request->diagnostico_carta_fab;
            $solucion = $request->solucion_carta_fab;

            $id_st = $request->id_ost_fab;

            $responsable = $responsable;

            if ($concepto != 'No garantia' && $concepto != 'No garantia por tiempo' && empty($observaciones)) {
                return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }

            ModelValoracionFab::where('id_st', $id_st)->update(['estado' => 0]);

            $response_1 =  ModelValoracionFab::create([
                'concepto' => $concepto,
                'observaciones' => empty($observaciones) ? 'La orden de servicio no cumple con los requerimientos necesarios para garantía.' : $observaciones,
                'responsable' => $responsable,
                'estado' => '1',
                'id_st' => $id_st
            ]);

            if ($concepto == 'No garantia' || $concepto == 'No garantia por tiempo') {
                if (!empty($diagnostico) && !empty($solucion)) {

                    $ost = ModelNuevaSolicitud::find($id_st);
                    $ost->respuesta_st = $concepto;
                    $ost->proceso = 'Servicio tecnico';
                    $ost->estado = 'Por definir';
                    $ost->save();

                    $response_2 =  ModelRespuestaFab::create([
                        'concepto' => $concepto,
                        'diagnostico' => $diagnostico,
                        'solucion' => $solucion,
                        'estado' => '1',
                        'responsable' => $responsable,
                        'id_st' => $id_st
                    ]);

                    if ($response_1 && $response_2) {
                        $form = self::timeLineOst($id_st);
                        self::mailNoGarantia($id_st);

                        return response()->json(['form' => $form], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                    }
                    if ($response_1) {
                        ModelValoracionFab::where('id_valoracion', $response_1->id_valoracion)->delete();
                    } else {
                        if ($response_2) {
                            ModelRespuestaFab::where('id_respuesta', $response_2->id_respuesta)->delete();
                        }
                    }
                }
                return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }

            if ($response_1) {

                $seg_ = new ControllerSeguimiento();
                $seg_->updateSeguimiento($id_st, 3);
                $seg_->agregarSeguimiento($id_st, 4);

                $ost = ModelNuevaSolicitud::find($id_st);
                $ost->respuesta_st = $concepto;
                $ost->proceso = 'Almacen';
                $ost->estado = 'Recoger';
                $ost->save();

                self::mailCliente($id_st);

                $form = self::timeLineOst($id_st);
                return response()->json(['form' => $form], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }

        return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function searInformacionSolicitudes(Request $request)
    {
        $estado = $request->estado_solicitud;

        $proveedor = Auth::user()->empresa;
        $id_user = Auth::user()->id;
        $almacen = Auth::user()->almacen;

        $fecha_i = $request->fecha_inicial;
        $fecha_f = $request->fecha_final;

        $proveedor = $request->proveedor;
        if (!empty($request->almacen)) {
            $almacen = $request->almacen;
        }
        $servicio = $request->servicio;

        switch ($estado) {
            case 'all':
                $data = self::getInfoAllSt($proveedor, $id_user, $almacen, $fecha_i, $fecha_f, $servicio);
                break;
            case 'No garantia':
                $data = self::getDefinirGar($proveedor, $estado, $almacen, $fecha_i, $fecha_f, $servicio);
                break;
            default:
                $data = self::getInfoEstado($proveedor, $estado, $almacen, $fecha_i, $fecha_f, $servicio);
                break;
        }

        return response()->json(['info' => $data], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function definirOrdenServicioT(Request $request)
    {
        $id_st = $request->id_ost_definir;
        $obs = $request->observaciones_definir;
        $evidencia = $request->evidencias_doc_definir;
        $responsable = Auth::user()->nombre;

        $ost = ModelNuevaSolicitud::find($id_st);

        $seguir_ = false;

        if ($ost->respuesta_st == 'Cobrable') {
            $seguir_ = true;
        } else {
            if (/*$request->hasFile('evidencias_doc_definir') &&*/!empty($obs) && !empty($responsable)) {
                $seguir_ = true;
            }
        }

        if ($seguir_) {

            $name_ = '';
            $nombre = '';
            $tipo = '';
            $tama = '';
            $url_doc = '';

            if ($request->hasFile('evidencias_doc_definir')) {
                $tipo = $evidencia->getClientOriginalExtension();
                $name_ = str_replace("." . $tipo, "", $evidencia->getClientOriginalName());
                $nombre = uniqid() . "_" . $evidencia->getClientOriginalName();
                $tama = filesize($evidencia);

                $evidencia->storeAs('public/evidencias', $nombre);
                $url_doc = Storage::url("public/evidencias/" . $nombre);
            }

            $response = ModelDefinirOrden::create([
                'observaciones' => $obs,
                'responsable' => $responsable,
                'nom_doc' => $name_,
                'documento' => $nombre,
                'tipo' => $tipo,
                'tama' => $tama,
                'url' => $url_doc,
                'id_st' => $id_st
            ]);
            if ($response) {

                $seg_ = new ControllerSeguimiento();
                $seg_->updateSeguimiento($id_st, 7);

                $ost->proceso = 'Cliente';
                $ost->estado = 'Definido';
                $ost->save();

                $form = self::timeLineOst($id_st);
                return response()->json(['form' => $form], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }

            if (Storage::exists("public/evidencias/" . $nombre)) {
                Storage::delete("public/evidencias/" . $nombre);
            }

            return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
        return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function updateOrdenDefinida(Request $request)
    {

        $evidencia = $request->evidencias_doc_definir;
        $id_st = $request->id_ost_definir;

        if ($request->hasFile('evidencias_doc_definir')) {
            $tipo = $evidencia->getClientOriginalExtension();
            $name_ = str_replace("." . $tipo, "", $evidencia->getClientOriginalName());
            $nombre = uniqid() . "_" . $evidencia->getClientOriginalName();
            $tama = filesize($evidencia);

            $evidencia->storeAs('public/evidencias', $nombre);
            $url_doc = Storage::url("public/evidencias/" . $nombre);

            $info_orden = ModelDefinirOrden::where('id_st', $id_st)->first();
            $info_orden->nom_doc = $name_;
            $info_orden->documento = $nombre;
            $info_orden->tipo = $tipo;
            $info_orden->tama = $tama;
            $info_orden->url = $url_doc;
            $info_orden->save();

            $form = self::timeLineOst($id_st);
            return response()->json(['form' => $form], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function updateValoracionFabGerencia(Request $request)
    {
        $id = $request->id_ost_val;
        $concepto = $request->concepto_valoracion_ger;
        $obs = $request->obs_val_ger;
        $responsable = Auth::user()->nombre;

        if (!empty($id) && !empty($concepto) && !empty($obs) && !empty($responsable)) {

            ModelValoracionFab::where('id_st', $id)->update(['estado' => 0]);

            $response =  ModelValoracionFab::create([
                'concepto' => $concepto,
                'observaciones' => $obs,
                'responsable' => $responsable,
                'estado' => '1',
                'id_st' => $id
            ]);

            if ($response) {

                $seg_ = new ControllerSeguimiento();
                $seg_->updateSeguimiento($id, 3);
                $seg_->agregarSeguimiento($id, 4);

                $ost = ModelNuevaSolicitud::find($id);
                $ost->respuesta_st = $concepto;
                $ost->proceso = 'Almacen';
                $ost->estado = 'Recoger';
                $ost->save();

                self::mailCliente($id);

                $form = self::timeLineOst($id);
                return response()->json(['form' => $form], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }
        return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function updateDataRecogidaSt(Request $request)
    {
        $extensions = (['png', 'jpg', 'jpeg', 'tiff', 'webp', 'mp4']);

        $id_st = $request->id_st_recogida;
        $fecha = date('Y-m-d');
        $responsable = Auth::user()->nombre;
        $elementos = $request->elementos_recogidos;
        $obs = $request->observaciones_recogida;

        if (empty($elementos)) {
            $ost_info = ModelNuevaSolicitud::find($id_st);
            $elementos = $ost_info->articulo;
        }

        $response = ModelDatosRecogida::create([
            'elementos_recogidos' => $elementos,
            'observaciones_r' => $obs,
            'responsable' => $responsable,
            'fecha_responsable' => $fecha,
            'id_st' => $id_st
        ]);

        if ($response) {
            if ($request->hasFile('evidencias_recogidas')) {
                $evidencias = $request->evidencias_recogidas;
                foreach ($evidencias as $file) {
                    $tipo = $file->getClientOriginalExtension();

                    if (in_array($tipo, $extensions)) {
                        $name_ = str_replace("." . $tipo, "", $file->getClientOriginalName());
                        $nombre = uniqid() . "_" . $file->getClientOriginalName();
                        $tama = filesize($file);

                        $response_file = $file->storeAs('public/evidencias', $nombre);
                        $url_doc = Storage::url("public/evidencias/" . $nombre);

                        if ($response_file) {

                            ModelEvidenciasRecogidas::create([
                                'nombre_img' => $name_,
                                'tipo' => $tipo,
                                'tama' => $tama,
                                'url' => $url_doc,
                                'tabla' => 'recogida',
                                'id_comentario' => $response->id_recogida,
                                'id_st' => $id_st
                            ]);
                        }
                    }
                }
            }

            $seg_ = new ControllerSeguimiento();
            $seg_->updateSeguimiento($id_st, 4);
            $seg_->agregarSeguimiento($id_st, 5);

            $ost = ModelNuevaSolicitud::find($id_st);
            $ost->proceso = 'Taller';
            $ost->estado = 'Por ingresar';
            $ost->save();
            $form = self::timeLineOst($id_st);

            return response()->json(['form' => $form], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
        return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function agregarSeguimientoTaller(Request $request)
    {
        $id_st = $request->id_st_reparacion;
        $observaciones = $request->obs_seguimiento_t;
        $responsable = Auth::user()->nombre;

        if (!empty($observaciones) && !empty($responsable)) {
            $db = ModelSeguimientoTaller::create([
                'seguimiento' => $observaciones,
                'responsable' => $responsable,
                'id_st' => $id_st
            ]);

            if ($db) {
                if ($request->hasFile('evidencias_seguimiento_t')) {

                    $extensions = (['png', 'jpg', 'jpeg', 'tiff', 'webp', 'mp4']);

                    $evidencias = $request->file('evidencias_seguimiento_t');

                    foreach ($evidencias as $file) {
                        $tipo = $file->getClientOriginalExtension();

                        if (in_array($tipo, $extensions)) {
                            $name_ = str_replace("." . $tipo, "", $file->getClientOriginalName());
                            $nombre = uniqid() . "_" . $file->getClientOriginalName();
                            $tama = filesize($file);

                            $response_file = $file->storeAs('public/evidencias', $nombre);
                            $url_doc = Storage::url("public/evidencias/" . $nombre);

                            if ($response_file) {

                                ModelEvidenciasSeguimiento::create([
                                    'nombre_img' => $name_,
                                    'tipo' => $tipo,
                                    'tama' => $tama,
                                    'url' => $url_doc,
                                    'id_seguimiento' => $db->id_seguimiento
                                ]);
                            }
                        }
                    }
                }
                $form = self::timeLineOst($id_st);
                return response()->json(['form' => $form], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
            return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
        return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function EmitirCartaRespuestaServicio(Request $request)
    {
        $id_st = $request->id_ost_carta;
        $diagnostico = $request->diagnostico_carta;
        $solucion = $request->solucion_carta;
        $responsable = Auth::user()->nombre;

        $id_sesion = Auth::user()->id;

        if (!empty($diagnostico) && !empty($solucion) && !empty($responsable)) {

            $concepto_ = $request->concepto_carta;
            $ost = ModelNuevaSolicitud::find($id_st);

            ModelRespuestaFab::where('id_st', $id_st)->update(['estado' => '0']);

            if ($id_sesion != '1087991335') {

                $response =  ModelRespuestaFab::create([
                    'concepto' => !empty($concepto_) ? $concepto_ : $ost->respuesta_st,
                    'diagnostico' => $diagnostico,
                    'solucion' => $solucion,
                    'estado' => '2',
                    'responsable' => $responsable,
                    'aprobacion' => '',
                    'id_st' => $id_st
                ]);

                $form = self::timeLineOst($id_st);
                return response()->json(['form' => $form], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            } else {

                if (!empty($concepto_)) {
                    $ost->respuesta_st = $concepto_;
                    $ost->save();
                }

                $response =  ModelRespuestaFab::create([
                    'concepto' => $ost->respuesta_st,
                    'diagnostico' => $diagnostico,
                    'solucion' => $solucion,
                    'estado' => '1',
                    'responsable' => $responsable,
                    'aprobacion' => $responsable,
                    'id_st' => $id_st
                ]);

                if ($response) {
                    $ost->proceso = 'Servicio tecnico';
                    $ost->estado = 'En devolucion';
                    $ost->save();

                    self::mailCartaFab($id_st);
                    Mail::to($ost->email)->later(now()->addSeconds(5), new NotificacionDevolucionCliente($ost->nombre, $ost->articulo, $id_st));

                    $form = self::timeLineOst($id_st);
                    return response()->json(['form' => $form], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                }

                return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }

        return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function aprobarRespuestaEmitida(Request $request)
    {
        $id_ost = $request->id_st;
        $id_rsta = $request->id_rsp;

        $resp = ModelRespuestaFab::find($id_rsta);

        if ($resp !== null) {
            $concepto = $resp->concepto;

            $ost = ModelNuevaSolicitud::find($id_ost);

            $resp->aprobacion = Auth::user()->nombre;
            $resp->estado = '1';
            $resp->save();

            if ($concepto != $ost->respuesta_st) {
                $ost->respuesta_st = $concepto;
                $ost->save();
            }

            if ($concepto != 'No garantia por tiempo' && $concepto != 'No garantia') {
                $ost->proceso = 'Servicio tecnico';
                $ost->estado = 'En devolucion';
                $ost->save();

                self::mailCartaFab($id_ost);
                Mail::to($ost->email)->later(now()->addSeconds(5), new NotificacionDevolucionCliente($ost->nombre, $ost->articulo, $id_ost));
            }else{
                $ost->estado = 'Por definir';
                $ost->save();
            }

            $form = self::timeLineOst($id_ost);
            return response()->json(['form' => $form], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
