<?php

namespace App\Models\apps\intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelEvaluacionDepartamentos extends Model
{
    use HasFactory;

    public static function getObtenerPreguntas($id)
    {
        $preguntas = DB::table('parametros_evaluacion')
            ->join('departamentos_evaluacion', 'parametros_evaluacion.id_departamento', '=', 'departamentos_evaluacion.id')
            ->selectRaw('parametros_evaluacion.id as parametro_id, parametros_calificar, porcentaje_parametro, departamentos_evaluacion.id as departamento_id, departamento, porcentaje')
            ->where('parametros_evaluacion.id_departamento', $id)
            ->get();
        return $preguntas;
    }

    public static function getObtenerCoordinadores()
    {
        $ids = ['24581232', '28554243', '31991990', '42084244', '39584824', '30314322', '30338591', '3726391'];
        $coordinadores = DB::table('users')
            ->select('id', 'nombre')
            ->whereIn('id', $ids)
            ->get();
        return $coordinadores;
    }

    public static function getObtenerCentroOperaciones()
    {
        $centro = DB::table('centro_operaciones')->get();
        return $centro;
    }


    public static function getObtenerCentroOperacionesCoordinadorActivo($cedula)
    {
        $consulta = DB::table('coordinadores_cententros AS cc')
            ->select('co.id', 'co.centro_operacion')
            ->join('centro_operaciones AS co', 'cc.id_centro', '=', 'co.id')
            ->where('cc.id_cedula', $cedula)
            ->where('cc.estado', 'Activo')
            ->get();

        return $consulta;
    }
    public static function getObtenerCentroOperacionesCoordinador($cedula)
    {
        $consulta = DB::table('coordinadores_cententros AS cc')
            ->select('co.id', 'co.centro_operacion', 'cc.fecha_deshabilitado', 'cc.fecha_asignacion')
            ->join('centro_operaciones AS co', 'cc.id_centro', '=', 'co.id')
            ->where('cc.id_cedula', $cedula)
            ->get();

        return $consulta;
    }


    public static function addEvaluuacionResultado($evaluaciones, $porcentajeEvaluacion)
    {
        DB::table('porcentaje_total_evaluacion')->insert($porcentajeEvaluacion);
        DB::table('resultado_evaluacion')->insert($evaluaciones);
    }


    public static function bucarFechasingresadas($fechaInicial, $fechaFinal, $id_departamento, $usuario_evaluado, $centro_operacion)
    {
        $consulta = DB::table('porcentaje_total_evaluacion')
            ->where('id_departamento', $id_departamento)
            ->where('usuario_evaluado', $usuario_evaluado)
            ->where('id_centro_operacione', $centro_operacion)
            ->whereBetween('fecha', [$fechaInicial, $fechaFinal])
            ->count();
        return $consulta;
    }

    public static function buscarPorcentajeTotalEvaluaciones($fecha)
    {
        $resultado = DB::table('porcentaje_total_evaluacion as pt')
            ->select('us.nombre', 'co.centro_operacion', 'pt.usuario_evaluado', 'pt.id_centro_operacione', DB::raw('SUM(pt.porcentaje_total) AS suma_porcentaje'))
            ->join('users as us', 'pt.usuario_evaluado', '=', 'us.id')
            ->join('centro_operaciones as co', 'pt.id_centro_operacione', '=', 'co.id')
            ->where('pt.fecha', 'LIKE', $fecha . '%')
            ->groupBy('us.nombre', 'co.centro_operacion', 'pt.usuario_evaluado', 'pt.id_centro_operacione')
            ->get();
        // dd($resultado);
        return $resultado;
    }

    public static function bucarResultadosEvaluacion($cedula, $fecha, $id_centro)
    {
        $resultado = DB::table('porcentaje_total_evaluacion as pt')
            ->select('de.id', 'pt.id_departamento', 'de.departamento', 'de.porcentaje', 'pt.fecha', 'pt.porcentaje_total')
            ->join('departamentos_evaluacion as de', 'pt.id_departamento', '=', 'de.id')
            ->where('pt.usuario_evaluado', $cedula)
            ->where('pt.fecha', 'LIKE', $fecha . '%')
            ->where('pt.id_centro_operacione', $id_centro)
            ->orderBy('de.id', 'asc')
            ->get();

        return $resultado;
    }

    public static function buscarParametrosEvaluados($cedula, $fecha, $id_centro)
    {
        $resultado = DB::table('resultado_evaluacion as re')
            ->select('pe.id_departamento', 'pe.parametros_calificar', 'pe.porcentaje_parametro', 're.porcentaje_pregunta')
            ->join('parametros_evaluacion as pe', 're.id_pregunta', '=', 'pe.id')
            ->where('re.usuario_evaluado', $cedula)
            ->where('re.fecha', 'LIKE', $fecha . '%')
            ->where('re.id_centro_operacion', $id_centro)
            ->orderBy('pe.id_departamento', 'asc')
            ->get();
        return $resultado;
    }


    public static function buscarHistoriales($dia, $año)
    {
        $resultados = DB::table('porcentaje_total_evaluacion as f')
            ->join(DB::raw('(SELECT usuario_evaluado, SUM(porcentaje_total) as porcentaje FROM porcentaje_total_evaluacion WHERE MONTH(fecha) = ' . $dia . ' AND YEAR(fecha) = ' . $año . ' GROUP BY usuario_evaluado, id_centro_operacione) as t'), function ($join) {
                $join->on('f.usuario_evaluado', '=', 't.usuario_evaluado');
            })
            ->select('f.usuario_evaluado', DB::raw('AVG(t.porcentaje) as promedio_porcentaje'))
            ->groupBy('f.usuario_evaluado')
            ->get();

        return $resultados;
    }


    public static function departamentosEvaluados($cedula, $mes, $año)
    {
        $resultados = DB::table('porcentaje_total_evaluacion as pe')
            ->select(
                'pe.usuario_evaluado',
                'co.id',
                'co.centro_operacion',
                DB::raw('SUM(pe.porcentaje_total) as suma_porcentaje_total')
            )
            ->join('centro_operaciones as co', 'pe.id_centro_operacione', '=', 'co.id')
            ->where('pe.usuario_evaluado', $cedula)
            ->whereMonth('pe.fecha', $mes)
            ->whereYear('pe.fecha', $año)
            ->groupBy('pe.usuario_evaluado', 'co.id', 'co.centro_operacion')
            ->get();
        return $resultados;
    }
    // commits


    public static function obtenerDatoEvaluacion($coordinador, $centro, $fechaFormateada, $idDepartamento)
    {
        return DB::table('porcentaje_total_evaluacion')
            ->where('fecha', 'like', $fechaFormateada . '%')
            ->where('id_departamento', $idDepartamento)
            ->where('usuario_evaluado', $coordinador)
            ->where('id_centro_operacione', $centro)
            ->first();
    }


    // coordinador y usuario evaluador por centro de experiencia
    public static function coordinadoresEvaludoPorUsuario($evaluadorId)
    {
        return DB::table('coordinadores_cententros as cc')
            ->join('users as us', 'cc.id_cedula', '=', 'us.id')
            ->select('us.id', 'us.nombre')
            ->distinct()
            ->where('cc.id_evaluador', $evaluadorId)
            ->get();
    }


    public static function obtenerCentroOperacionEvaluador($idcoordinador, $idEvaluador)
    {
        return DB::table('coordinadores_cententros AS cc')
            ->select('co.*', 'cc.fecha_deshabilitado', 'cc.fecha_asignacion')
            ->join('centro_operaciones AS co', 'cc.id_centro', '=', 'co.id')
            ->where('cc.id_cedula', $idcoordinador)
            ->where('cc.id_evaluador', $idEvaluador)
            ->get();
    }



    // -------historial por año ----------------
    public static function resultadoPorAño($usuarioEvaluado, $año)
    {
        return DB::table('porcentaje_total_evaluacion')
            ->select(DB::raw('SUM(porcentaje_total) as suma_porcentaje'))
            ->whereYear('fecha', $año)
            ->where('usuario_evaluado', $usuarioEvaluado)
            ->first()
            ->suma_porcentaje;
    }


    // --------- centro de operaciones asignados ---------
    public static function centrosOperacionesAsignados($coordinador)
    {
        return DB::table('coordinadores_cententros')
            ->select('coordinadores_cententros.id as idCoAsignado', 'coordinadores_cententros.estado', 'centro_operaciones.centro_operacion', 'coordinadores_cententros.id_cedula as idCoordinador', 'coordinadores_cententros.id_centro as idCentroOperacion')
            ->join('centro_operaciones', 'coordinadores_cententros.id_centro', '=', 'centro_operaciones.id')
            ->where('id_cedula', $coordinador)
            ->get();
    }


    public static function actualizarEstadoCentroAsignado($id, $estado, $fechaActual)
    {
        return DB::table('coordinadores_cententros')
            ->where('id', $id)
            ->update([
                'estado' => $estado,
                'fecha_deshabilitado' => $fechaActual,
            ]);
    }


    public static function asignarCentroOperacion($data)
    {
        return DB::table('coordinadores_cententros')->insert($data);
    }


    public static function cantidadRegistrosEvaluacion($idCoordinador, $idCentroOperacion, $fechaBuscar)
    {
        return DB::table('porcentaje_total_evaluacion')
            ->select(DB::raw('COUNT(*) as total'))
            ->where('fecha', 'like', $fechaBuscar.'%')
            ->where('usuario_evaluado', $idCoordinador)
            ->where('id_centro_operacione', $idCentroOperacion)
            ->first();
    }
}
