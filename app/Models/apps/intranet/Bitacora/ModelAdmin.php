<?php

namespace App\Models\apps\intranet\Bitacora;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelAdmin extends Model
{
    use HasFactory;

    public static function ObtenerSolicitudesProgreso($estado)
    {
        $signo = ($estado == 'completada') ? '=' : '<>';
        return DB::table('bitacora_solicitudes')
            ->where('estado', $signo, 'completada')
            ->orderBy('created_at')
            ->get();
    }

    public static function ObtenerUsuariosBD()
    {
        return DB::table('users')->get(['id', 'nombre']);
    }

    public static function SolicitudesUsuarios($idSolicitud)
    {
        $data = [];
        $query = DB::table('bitacora_usuarios')->where('id_solicitud', $idSolicitud)->get('id_usuario');
        foreach ($query as $key => $value) {
            array_push($data, ($value->id_usuario));
        }
        return $data;
    }

    public static function CrearNuevoPuntoProyecto($data)
    {
        return DB::table('bitacora_puntos_proyecto')->insert($data);
    }

    public static function AgregarSeguimientoSolicitud($data)
    {
        return DB::table('bitacora_coments_seg')->insertGetId($data);
    }

    public static function AgregarDocumentosSeguimientos($data)
    {
        DB::table('bitacora_docs_seg')->insert($data);
    }

    public static function ObtenerSeguimientoSolicitud($id_solicitud)
    {
        return DB::table('bitacora_coments_seg')
            ->select(['id_seguimiento', 'seguimiento', 'responsable', 'created_at as fecha'])
            ->where('id_solicitud', $id_solicitud)
            ->orderBy('created_at')
            ->get();
    }

    public static function ObtenerDocumentosSegSolicitud($idComment)
    {
        return DB::table('bitacora_docs_seg')
            ->select(['nom_doc_seg', 'url_doc_seg'])
            ->where('id_comentario_seg', $idComment)->get();
    }

    public static function AgregarSeguimientoPuntos($data)
    {
        return DB::table('bitacora_coment_seg_p')->insertGetId($data);
    }

    public static function AgregarDocsSeguimientoPuntos($data)
    {
        DB::table('bitacora_docs_puntos')->insert($data);
    }

    public static function ActualizarSeguimientoPunto($data, $id)
    {
        return DB::table('bitacora_puntos_proyecto')->where('id_punto', $id)->update($data);
    }

    public static function ValidarEstadoActualizar($estado, $id)
    {
        $email = '';
        $query = DB::table('bitacora_solicitudes')->where('id_solicitud', $id)->get(['estado', 'id_solicitante']);
        foreach ($query as $key => $value) {
            $estado_db = $value->estado;
            $email = $value->id_solicitante;
        }
        if ($estado == $estado_db) {
            return $email;
        }

        return $email;
    }

    public static function ActualizarProyectoSolicitado($data, $id)
    {
        return DB::table('bitacora_solicitudes')->where('id_solicitud', $id)->update($data);
    }

    public static function CantidadInvolucrados($idProyecto)
    {
        return DB::table('bitacora_usuarios')->where('id_solicitud', $idProyecto)->count();
    }

    public static function ValidarExistencia($id_soli, $id_user)
    {
        return DB::table('bitacora_usuarios')->where('id_solicitud', $id_soli)->where('id_usuario', $id_user)->count();
    }

    public static function EliminarUsuariosProyecto($consulta)
    {
        return DB::table('bitacora_usuarios')->whereRaw($consulta)->delete();
    }

    public static function EliminarTodosUsuarios($solicitud)
    {
        return DB::table('bitacora_usuarios')->where('id_solicitud', $solicitud)->delete();
    }

    public static function ObtenerSeguimientoPunto($id_punto)
    {
        $valor = 0;
        $id_s = 0;
        $query = DB::table('bitacora_puntos_proyecto')->where('id_punto', $id_punto)->get(['porcentaje_p', 'id_solicitud']);
        foreach ($query as $key => $value) {
            $valor = $value->porcentaje_p;
            $id_s = $value->id_solicitud;
        }
        return (['valor' => $valor, 'id' => $id_s]);
    }

    public static function ObtenerPromedioPorc($id_s)
    {
        return DB::table('bitacora_puntos_proyecto')
            ->where('id_solicitud', $id_s)
            ->avg('porcentaje_p');
    }
}
