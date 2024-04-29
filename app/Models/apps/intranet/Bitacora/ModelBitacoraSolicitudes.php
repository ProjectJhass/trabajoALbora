<?php

namespace App\Models\apps\intranet\Bitacora;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelBitacoraSolicitudes extends Model
{
    use HasFactory;

    public static function ObtenerSolicitudesProgreso($id_user, $estado)
    {
        $signo = ($estado == 'completada') ? '=' : '<>';
        return DB::table('bitacora_solicitudes')
            ->where('id_solicitante', $id_user)
            ->where('estado', $signo, 'completada')
            ->orderBy('created_at')
            ->get();
    }

    public static function CantidadProyectos($id_user)
    {
        return DB::table('bitacora_solicitudes')
            ->where('id_solicitante', $id_user)
            ->count();
    }

    public static function CantidadPendientes($id_user)
    {
        return DB::table('bitacora_solicitudes')
            ->where('id_solicitante', $id_user)
            ->where('estado', '<>', 'completada')
            ->count();
    }

    public static function CantidadCompletados($id_user)
    {
        return DB::table('bitacora_solicitudes')
            ->where('id_solicitante', $id_user)
            ->where('estado', 'completada')
            ->count();
    }

    public static function CantidadAtrasados($id_user)
    {
        return DB::table('bitacora_solicitudes')
            ->where('id_solicitante', $id_user)
            ->where('fecha_posible_entrega', '<', date('Y-m-d'))
            ->where('estado', '<>', 'completada')
            ->count();
    }

    public static function ObtenerSolicitudUser($idSolicitud)
    {
        return DB::table('bitacora_solicitudes')
            ->where('id_solicitud', $idSolicitud)
            ->orderBy('created_at')
            ->get();
    }

    public static function ObtenerPuntosProyecto($idSolicitud)
    {
        return DB::table('bitacora_puntos_proyecto')
            ->where('id_solicitud', $idSolicitud)
            ->orderBy('prioridad_p')
            ->get();
    }

    public static function ObtenerDocumentosSolicitud($idSolicitud)
    {
        return DB::table('bitacora_documentos')
            ->where('id_solicitud', $idSolicitud)
            ->get();
    }

    public static function ObtenerDocsPuntoSeg($id_com_seg)
    {
        return DB::table('bitacora_docs_puntos')
            ->select(['nom_doc_p', 'url_doc_p'])
            ->where('id_comment_seg_p', $id_com_seg)
            ->get();
    }

    public static function ObtenerSegPuntosDocs($id_punto)
    {
        $array = [];

        $query = DB::table('bitacora_coment_seg_p')
            ->select(['id_seg_punto', 'seg_punto', 'responsable', 'created_at'])
            ->where('id_punto_solicitud', $id_punto)
            ->orderBy('created_at')
            ->get();

        foreach ($query as $key => $value) {
            array_push($array, ['seguimiento' => $value->seg_punto, 'responsable' => $value->responsable, 'fecha' => $value->created_at, 'docs' => self::ObtenerDocsPuntoSeg($value->id_seg_punto)]);
        }
        return $array;
    }

    public static function ObtenerEmailUser($id_user)
    {
        $query = DB::table('users')->where('id', $id_user)->get('email');
        foreach ($query as $key => $value) {
            return $value->email;
        }
        return 'web.developer@mueblesalbura.com.co';
    }

    public static function CrearNuevaSolicitud($data)
    {
        return DB::table('bitacora_solicitudes')->insertGetId($data);
    }

    public static function AsignarProyecto($id_proyecto, $asignado)
    {
        return DB::table('bitacora_usuarios')->insert([
            'id_solicitud' => $id_proyecto,
            'id_usuario' => $asignado,
            'procentaje_seguimiento' => '0',
            'estado' => 'creada',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    public static function CargarDocumentosProyecto($data)
    {
        DB::table('bitacora_documentos')->insert($data);
    }
}
