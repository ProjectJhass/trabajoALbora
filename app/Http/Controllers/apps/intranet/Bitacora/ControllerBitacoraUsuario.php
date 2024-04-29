<?php

namespace App\Http\Controllers\apps\intranet\Bitacora;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\Bitacora\ModelAdmin;
use App\Models\apps\intranet\Bitacora\ModelBitacoraSolicitudes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerBitacoraUsuario extends Controller
{
    public function index(Request $request)
    {
        $id_usuario = Auth::user()->id;

        $solicitudes = ModelBitacoraSolicitudes::ObtenerSolicitudesProgreso($id_usuario, $request->estado);
        $ttal_proy = ModelBitacoraSolicitudes::CantidadProyectos($id_usuario);
        $pendientes = ModelBitacoraSolicitudes::CantidadPendientes($id_usuario);
        $completados = ModelBitacoraSolicitudes::CantidadCompletados($id_usuario);
        $atrasados = ModelBitacoraSolicitudes::CantidadAtrasados($id_usuario);
        return view('apps.intranet.bitacora.usuario.crear', ['solicitudes' => $solicitudes, 'total' => $ttal_proy, 'pendientes' => $pendientes, 'completados' => $completados, 'atrasados' => $atrasados]);
    }

    public function detalles(Request $request)
    {
        $puntos_ = [];
        $seguimiento_ = [];

        $id_solicitud = $request->idSolicitud;

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

        return view('apps.intranet.bitacora.usuario.proyectos', ['proyecto' => $proyecto, 'documentos' => $documentos, 'puntos' => $puntos_, 'seguimiento' => $seguimiento_]);
    }

    public function crear()
    {
        return view('apps.intranet.bitacora.usuario.crear_proyecto');
    }
}
