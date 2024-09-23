<?php

namespace App\Models\apps\intranet_fabrica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelEncuestaSatisfaccion extends Model
{
    use HasFactory;

    public static function VerificarExistenciaUsuario($cedula)
    {
        return DB::connection('db_fabrica')->table('usuarios_encuesta')
            ->select([DB::raw('COUNT(id_usuario_e) as valor')])
            ->where('cedula_usuario', '=', $cedula)
            ->get();
    }

    public static function ObtenerProcesosFabrica()
    {
        return DB::connection('db_fabrica')->table('procesos_fabrica')->get();
    }

    public static function ObtenerSeccionesFabrica($id_proceso)
    {
        return DB::connection('db_fabrica')->table('secciones_fabrica')->where('id_proceso', '=', $id_proceso)->get();
    }

    public static function ObtenerNombreUsuarioEnc($cedula)
    {
        return DB::connection('db_fabrica')->table('usuarios_encuesta')->where('cedula_usuario', '=', $cedula)->get();
    }

    public static function ObtenerNombreProceso($id_proceso)
    {
        return DB::connection('db_fabrica')->table('procesos_fabrica')->where('id_proceso', '=', $id_proceso)->get();
    }
    public static function ObtenerNombreSeccion($id_seccion)
    {
        return DB::connection('db_fabrica')->table('secciones_fabrica')->where('id_seccion_fab', '=', $id_seccion)->get();
    }

    public static function ObtenerPreguntasEncuesta()
    {
        return DB::connection('db_fabrica')->table('preguntas_encuesta')->get();
    }


    public static function InsertarInformacionUsuarioEncuesta($informacion)
    {
        return DB::connection('db_fabrica')->table('respuestas_por_usuario')->insertGetId($informacion);
    }
    public static function InsertarRespuestasPreguntas($pregunta, $respuesta, $fecha, $id_respuesta)
    {
        DB::connection('db_fabrica')->table('respuestas_preguntas_users')->insert(['pregunta' => $pregunta, 'respuesta' => $respuesta, 'fecha_registro' => $fecha, 'id_respuesta_usuario' => $id_respuesta]);
    }

    public static function ObtenerInformacionUsuarioAlm($id_insert)
    {
        return DB::connection('db_fabrica')->table('respuestas_por_usuario')->where('id_respuesta_u', '=', $id_insert)->get();
    }

    public static function ObtenerRepuestasUsuarioEncuestaSatisfaccion($id_insert)
    {
        return DB::connection('db_fabrica')->table('respuestas_preguntas_users as r')
            ->join('preguntas_encuesta as p', 'p.id_pregunta', '=', 'r.pregunta')
            ->select(['p.id_pregunta', 'p.pregunta', 'r.respuesta'])
            ->where('r.id_respuesta_usuario', '=', $id_insert)->get();
    }

    public static function ObtenerEncuestasRealizadasPorFecha($desde, $hasta, $proceso) {
        return DB::connection('db_fabrica')->table('respuestas_por_usuario')
        ->whereBetween('fecha_realizacion', [$desde, $hasta])
        ->where('proceso', $proceso)
        ->get();
    }

    public static function ObtenerIdProceso($name_proccess) {
        return DB::connection('db_fabrica')->table('procesos_fabrica')
        ->where('nombre_proceso', $name_proccess)
        ->first();
    }

    public static function ObtenerSeccionesFabricaNombre($id_proceso)
    {
        return DB::connection('db_fabrica')->table('secciones_fabrica')->where('id_proceso', '=', $id_proceso)->get();
    }

    public static function ObtenerRespuestasProcesoSeccionOrdenamiento($proceso, $seccion, $desde, $hasta, $id_orden) {
        return DB::connection('db_fabrica')->table('respuestas_preguntas_users as rpu')
        ->join('preguntas_encuesta as pe', 'rpu.pregunta', '=', 'pe.id_pregunta')
        ->join('respuestas_por_usuario as rporu', 'rpu.id_respuesta_usuario', '=', 'rporu.id_respuesta_u')
        ->where('rporu.proceso', $proceso)
        ->where('rporu.seccion', $seccion)
        ->whereBetween('rporu.fecha_realizacion', [$desde, $hasta])
        ->where('pe.orden', $id_orden)
        ->get(['rpu.respuesta as respuestas_ordenamiento']);
    }
}
