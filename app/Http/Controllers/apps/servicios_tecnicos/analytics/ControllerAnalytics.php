<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\analytics;

use App\Exports\ExportInfoTiemposRespuestaSt;
use App\Exports\ExportInfoCausalidades;
use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelFechasExcluidas;
use App\Models\apps\servicios_tecnicos\servicios\ModelHistorialFechasNotificacion;
use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use App\Models\apps\servicios_tecnicos\servicios\ModelHistorialSeguimiento;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class ControllerAnalytics extends Controller
{
    public function home()
    {
        // self::notificarRetrasos();
        self::programarNotificacionesRetrasos();

        $year = date('Y');

        $data_ = ModelNuevaSolicitud::select('articulo', DB::raw('count(articulo) as cantidad'))
            ->where('respuesta_st', '<>', 'Cobrable')
            ->whereYear('created_at', $year)
            ->groupBy('articulo')
            ->orderBy('cantidad', 'desc')
            ->get();

        $count_st = ModelNuevaSolicitud::where('respuesta_st', '<>', 'Cobrable')->whereYear('created_at', $year)->count();
        $odts = self::getODTS();
        $tiempos_table = self::getTiemposRespuestaTable($odts->first()->id_st);
        $tiempos_graph = self::getTiemposRespuestaGraph('');
        $causalidades_graph = self::getCausalidadesGraph();
        $months = ModelNuevaSolicitud::select(DB::raw('month(created_at) as mes'), DB::raw('count(id_st) as cantidad'))
            ->where('respuesta_st', '<>', 'Cobrable')
            ->whereYear('created_at', $year)->groupBy(DB::raw('month(created_at)'))->get();

        return view('apps.servicios_tecnicos.servicios_tecnicos.home', ['cantidad' => $count_st, 'items' => $data_, 'js' => $data_->toArray(), 'periodico' => $months->toArray(), 'tiempos_table' => $tiempos_table, 'odts' => $odts, 'tiempos_graph' => $tiempos_graph, 'causalidades_graph' => $causalidades_graph]);
    }
    public function searchinfo(Request $request)
    {
        $grafica = $request->grafica;
        $year = $request->year;

        $count_st = ModelNuevaSolicitud::whereYear('created_at', $year)->count();
        $items = '';

        $ban = 0;

        switch ($grafica) {
            case '1':
                $data_ = ModelNuevaSolicitud::select('articulo', DB::raw('count(articulo) as cantidad'))->whereYear('created_at', $year)->groupBy('articulo')->orderBy('cantidad', 'desc')->get();
                foreach ($data_ as $key => $value) {
                    if ($ban < 4) {
                        $items .= '<li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-cart-alt"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">' . $value->articulo . '</h6>
                            </div>
                            <div class="user-progress">
                                <small class="fw-medium">' . $value->cantidad . '</small>
                            </div>
                        </div>
                    </li>';
                    }
                    $ban++;
                }
                break;
            case '2':
                $data_ = ModelNuevaSolicitud::select(DB::raw('month(created_at) as mes'), DB::raw('count(id_st) as cantidad'))->whereYear('created_at', $year)->groupBy(DB::raw('month(created_at)'))->get();
                break;
        }
        $odts = self::getODTS();
        $tiempos_table = self::getTiemposRespuestaTable($odts->first()->id_st);
        return response()->json(['data' => $data_->toArray(), 'items' => $items, 'cantidad' => $count_st, 'tiempos_table' => $tiempos_table, 'odts' => $odts], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
    public function getInfoHistorialSeguimiento($orden_servicio, $fecha_i = null, $fecha_f = null, $estado = null, $limit = null)
    {
        $fechaActual = date('Y-m-01');
        $fechaFinMesActual = date('Y-m-t');
        // if(isset($fecha_f)){
        //     $fecha_f.=
        // }
        $query = ModelHistorialSeguimiento::select(
            'historial_seguimiento.id_st',
            'etapas_servicos.id',
            'etapas_servicos.etapa',
            DB::raw('CAST(etapas_servicos.dias AS UNSIGNED) as dias'),
            'historial_seguimiento.created_at',
            DB::raw('CASE WHEN DATEDIFF( CASE WHEN historial_seguimiento.fecha_final IS NULL THEN CURDATE() ELSE historial_seguimiento.fecha_final END , historial_seguimiento.fecha_inicial ) = 0 THEN 1 ELSE DATEDIFF( CASE WHEN historial_seguimiento.fecha_final IS NULL THEN CURDATE() ELSE historial_seguimiento.fecha_final END , historial_seguimiento.fecha_inicial ) - ( SELECT COUNT(*) FROM db_plataformas.fechasexcluidas fe WHERE fe.fecha BETWEEN historial_seguimiento.fecha_inicial AND CASE WHEN historial_seguimiento.fecha_final IS NULL THEN CURDATE() ELSE historial_seguimiento.fecha_final END ) END as diferencia'),
        )
            ->join('etapas_servicos', 'historial_seguimiento.id_proceso', '=', 'etapas_servicos.id')
            ->join('servicios_tecnicos', 'servicios_tecnicos.id_st', '=', 'historial_seguimiento.id_st')
            ->leftJoin('crear_ost_web', 'servicios_tecnicos.id_st', '=', 'crear_ost_web.num_ost')

            // ->where('servicios_tecnicos.respuesta_st', '<>', 'Cobrable')
            ->where('servicios_tecnicos.tipo_servicio', '=', 'CLIENTE')
            ->orderByDesc('historial_seguimiento.id_st');

        // Filtra por fechas
        if (!empty($fecha_i) && !empty($fecha_f)) {
            // Ambas fechas están presentes
            $query->whereBetween('servicios_tecnicos.created_at', [$fecha_i, $fecha_f]);
        } elseif (!empty($fecha_i)) {
            // Solo fecha de inicio
            $query->where('servicios_tecnicos.created_at', '>=', $fecha_i);
        } elseif (!empty($fecha_f)) {
            // Solo fecha final
            $query->where('servicios_tecnicos.created_at', '<=', $fecha_f);
        } else {
            // Mostrar registros del mes actual | DEFAULT
            $query->whereBetween('servicios_tecnicos.created_at', [$fechaActual, $fechaFinMesActual]);
        }


        // Aplica filtros adicionales si existe la orden_servicio
        if (!empty($orden_servicio)) {
            $query->where(function ($subQuery) use ($orden_servicio) {
                $subQuery->where('historial_seguimiento.id_st', 'like', "%{$orden_servicio}%")
                    ->orWhere('servicios_tecnicos.cedula', 'like', "%{$orden_servicio}%")
                    ->orWhere('crear_ost_web.n_ticket', 'like', "%{$orden_servicio}%");
            });
        }
        // $data = $query->get()->groupBy('id_st');
        $groupedData = $query->get()->groupBy('id_st');

        switch ($estado) {
            case 'peligro':
                $groupedData = $groupedData->filter(function ($collection) {
                    return $collection->contains(function ($item) {
                        return $item->dias < $item->diferencia;
                    });
                });
                break;
            case 'advertencia':
                $groupedData = $groupedData->filter(function ($collection) {
                    return $collection->contains(function ($item) {
                        return (($item->diferencia != 1 && $item->dias != 1) && ($item->dias = $item->diferencia));
                    });
                });
                break;
            case 'a_tiempo':
                $groupedData = $groupedData->filter(function ($collection) {
                    return $collection->contains(function ($item) {
                        return $item->dias >= $item->diferencia;
                    });
                });
                break;
            default:
                # code...
                break;
        }
        $page = request()->get('page', 1); // Obtener la página actual, por defecto es 1
        $total = $groupedData->count(); // Total de elementos
        $perPage = 50; // Elementos por página
        $items = $groupedData->forPage($page, $perPage)->values(); // Obtener los elementos de la página actual

        $pagedData = new LengthAwarePaginator($items, $total, $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query()
        ]);


        return $groupedData;
    }
    public function getTiemposRespuestaTable($orden_servicio)
    {
        $data_info = self::getInfoHistorialSeguimiento($orden_servicio);
        return view('apps.servicios_tecnicos.servicios_tecnicos.seguimiento.tiempos_respuesta', ['data' => $data_info])->render();
    }
    public function filtrarFechaGraficas(Request $request)
    {
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        if (isset($fecha_i)) {
            $fecha_i .= "-01";
        }
        if (isset($fecha_f)) {
            $fecha_f .= "-01";
        }
        $tiempos = self::getTiemposRespuestaGraph('', $fecha_i, $fecha_f);
        $causales = self::getCausalidadesGraph($fecha_i, $fecha_f);

        return response()->json(['tiempos' => $tiempos, 'causales' => $causales]);
    }
    public function obtenerOrdenesST(Request $request)
    {
        $orden_servicio = $request->co;
        if (isset($orden_servicio)) {
            $tiempos_table = self::getTiemposRespuestaTable($orden_servicio);
        } else {
            $tiempos_table = self::getTiemposRespuestaTable('');
        }
        return response()->json(['status' => true, 'table' => $tiempos_table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
    public function obtenerGraficaODT(Request $request)
    {
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $orden_servicio = $request->co;
        if (isset($orden_servicio)) {
            $tiempos_graph = self::getTiemposRespuestaGraph($orden_servicio, $fecha_i, $fecha_f);
        } else {
            $tiempos_graph = self::getTiemposRespuestaGraph('', $fecha_i, $fecha_f);
        }
        return response()->json(['status' => true, 'graph' => $tiempos_graph], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
    public function getTiemposRespuestaGraph($orden_servicio, $fecha_i = null, $fecha_f = null, $estado = null)
    {
        $data_info = self::getInfoHistorialSeguimiento($orden_servicio, $fecha_i, $fecha_f, $estado);
        if (count($data_info->all())) {
            return view('apps.servicios_tecnicos.servicios_tecnicos.seguimiento.grafica_tiempos', ['data' => $data_info])->render();
        } else {
            return '<div class="w-100 text-center">No se encontró ningún registro para el mes actual<div/>';
        }
    }
    public function getODTS()
    {
        $data = ModelNuevaSolicitud::select('servicios_tecnicos.id_st')
            ->distinct()
            ->join('historial_seguimiento as h', 'h.id_st', '=', 'servicios_tecnicos.id_st')
            ->where('servicios_tecnicos.respuesta_st', '<>', 'Cobrable')
            ->orderByDesc('servicios_tecnicos.id_st')
            ->get();
        return $data;
    }
    public function getODT(Request $request)
    {
        $odt = $request->odt;
        $data = self::getInfoHistorialSeguimiento($odt);
        return $data;
    }
    public function getInfoCausalidades($fecha_i = null, $fecha_f = null)
    {
        $fechaActual = date('Y-m-01');
        $fechaFinMesActual = date('Y-m-t');
        $query = ModelNuevaSolicitud::select(
            'articulo',
            'id_st',
            'causales',
            DB::raw('if(cantidad = 0, 1, cantidad) as cantidad')
        )
            ->whereNotNull('causales')
            ->where('causales', '!=', '');

        if (!empty($fecha_i) && !empty($fecha_f)) {
            $query->whereBetween('created_at', [$fecha_i, $fecha_f]);
        } else if (!empty($fecha_i)) {
            $query->where('created_at', '>=', $fecha_i);
        } else if (!empty($fecha_f)) {
            $query->where('created_at', '<=', $fecha_f);
        } else {
            $query->whereBetween('created_at', [$fechaActual, $fechaFinMesActual]);
        }
        $data = $query->get();
        $causales = [];
        $data_info = [];

        foreach ($data as $value) {
            $st = $value->id_st;
            $causal = $value->causales;
            if (str_contains($causal, ',')) {
                $causalesExploded = explode(',', $causal);
                foreach ($causalesExploded as $causal) {
                    for ($i = 0; $i < $value->cantidad; $i++) {
                        # code...
                        $causales[] = trim($causal);
                    }
                }
            } else {
                for ($i = 0; $i < $value->cantidad; $i++) {
                    $causales[] = trim($causal);
                }
            }
            if (!isset($data_info[$st])) {
                $data_info[$st] = [];
            }
            $data_info[$st][] = [
                'id' => $value->id_st,
                'causales' => $causal,
            ];
        }
        $count = array_count_values($causales);
        return $count;
    }
    public function getArticulosByCausalidad(Request $request)
    {
        $fechaActual = date('Y-m-01');
        $fechaFinMesActual = date('Y-m-t');
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $causalidad = $request->causalidad;
        $query = ModelNuevaSolicitud::select(
            'causales',
            DB::raw("trim(substring_index(articulo, ' X ', 1)) as articulo"),
            DB::raw('if(cantidad = 0, 1, cantidad) as cantidad'),
            'id_item'
        )
            ->where('causales', 'like', '%' . $causalidad . '%');

        if (!empty($fecha_i) && !empty($fecha_f)) {
            $query->whereBetween('created_at', [$fecha_i, $fecha_f]);
        } elseif (!empty($fecha_i)) {
            $query->where('created_at', '>=', $fecha_i);
        } elseif (!empty($fecha_f)) {
            $query->where('created_at', '<=', $fecha_f);
        } else {
            $query->whereBetween('created_at', [$fechaActual, $fechaFinMesActual]);
        }
        $data = $query->get()->groupBy('id_item');

        $summedData = $data->map(function ($group) {
            $total_cantidad = $group->sum('cantidad'); // Suma de cantidades en el grupo
            $articulo = $group->first()->articulo; // Tomamos el nombre del artículo del primer elemento del grupo
            $id_item = $group->first()->id_item;
            return [
                'id_item' => $id_item,
                'articulo' => $articulo,
                'total_cantidad' => $total_cantidad,
            ];
        });
        $articulos = view('apps.servicios_tecnicos.servicios_tecnicos.seguimiento.articulos-causalidad', ['data' => $summedData->all()])->render();
        return response()->json(['data' => "$articulos"]);
    }
    public function getCausalidadesGraph($fechaInicio = null, $fechaFin = null)
    {
        $data = self::getInfoCausalidades($fechaInicio, $fechaFin);
        if (count($data) > 0) {
            return view('apps.servicios_tecnicos.servicios_tecnicos.seguimiento.causalidades', ['data' => $data])->render();
        } else {
            return '<div class="w-100 text-center">No se encontró ningún registro para el mes actual<div/>';
        }
    }
    public function exportTiemposRespuesta(Request $request)
    {
        $fechaInicio = $request->fecha_i;
        $fechaFin = $request->fecha_f;
        $export = new ExportInfoTiemposRespuestaSt($fechaInicio, $fechaFin);
        return Excel::download($export, 'info-tiempos-respuesta-servicios-tecnicos.xlsx');
    }
    public function exportCausales(Request $request)
    {
        $fechaInicio = $request->fecha_i;
        $fechaFin = $request->fecha_f;
        $export = new ExportInfoCausalidades($fechaInicio, $fechaFin);
        return Excel::download($export, 'info-causalidades-servicios-tecnicos.xlsx');
    }
    public function filtrarTiemposPorEstado(Request $request)
    {
        $estado = $request->estado;
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        if (isset($fecha_i)) {
            $fecha_i .= "-01";
        }
        if (isset($fecha_f)) {
            $fecha_f .= "-01";
        }
        $tiempos = self::getTiemposRespuestaGraph('', $fecha_i, $fecha_f, $estado);

        return response()->json(['tiempos' => $tiempos]);
    }
    public function notificarRetrasos()
    {
        $fecha = Carbon::now()->toDateString();
        $data = ModelHistorialFechasNotificacion::select(
            'historial_fechas_notificaciones.id',
            'id_st',
            'id_etapa',
            'es.etapa',
            'es.dias',
            'fecha_inicial',
            'transcurrido',
            'retraso',
            'fecha_envio',
            'historial_fechas_notificaciones.estado'
        )->join('st_servicios_tecnicos.etapas_servicos as es', 'id_etapa', '=', 'es.id')
            ->where('fecha_envio', $fecha)
            ->where('historial_fechas_notificaciones.estado', 'POR ENVIAR')
            ->get()->all();

        $odt = null;
        $to = [
            "serviciostecnicos@mueblesalbura.com.co",
        ];
        $fabrica = [
            "diana.mora@mueblesalbura.com.co",
            "viviana.romero@mueblesalbura.com.co",
        ];
        $AsistenteLogistica = [
            "logistica@mueblesalbura.com.co",
            "asistente.logistica@mueblesalbura.com.co"
        ];
        if (count($data) > 0) {
            foreach ($data as $orden) {
                // dd($orden);
                switch ($orden->etapa) {
                    case 'Visita/Evidencias':
                        # logistica - AsistenteLogistica - servicios tecnicos
                        $to = [
                            "logistica@mueblesalbura.com.co",
                            "asistente.logistica@mueblesalbura.com.co",
                        ];
                        $odt = $orden;
                        break;
                    case 'Valoracion':
                        # ST - fabrica
                        $to = [
                            "diana.mora@mueblesalbura.com.co",
                            "viviana.romero@mueblesalbura.com.co",
                        ];
                        $odt = $orden;
                        break;
                    case 'Recogida':
                        # ST - bodega - logistica -AsistenteLogistica
                        $to = [
                            "logistica@mueblesalbura.com.co",
                            "asistente.logistica@mueblesalbura.com.co",
                            "bodega.ppal@mueblesalbura.com.co",
                        ];
                        $odt = $orden;
                        break;
                    case 'Ingreso taller':
                        # ST - fabrica
                        $to = [
                            "diana.mora@mueblesalbura.com.co",
                            "viviana.romero@mueblesalbura.com.co",
                        ];
                        $odt = $orden;
                        break;
                    case 'Salida taller':
                        # ST - fabrica
                        $to = [
                            "diana.mora@mueblesalbura.com.co",
                            "viviana.romero@mueblesalbura.com.co",
                        ];
                        $odt = $orden;
                        break;
                    case 'Entrega mercancía':
                        # ST - bodega - logistica
                        $to = [
                            "bodega.ppal@mueblesalbura.com.co",
                            "logistica@mueblesalbura.com.co",
                            "asistente.logistica@mueblesalbura.com.co",
                        ];
                        $odt = $orden;
                        break;
                    default:
                        # code...
                        break;
                }

                if ($odt && $to) {
                    self::enviarEmail($to, $odt);
                    $enviado = ModelHistorialFechasNotificacion::find($odt->id)->update(['estado' => 'ENVIADO']);
                }
            }
            // echo view('apps.servicios_tecnicos.servicios_tecnicos.seguimiento.reporte-tiempos-retrasos', ['data' => $odt])->render();
        }
    }
    public function programarNotificacionesRetrasos()
    {
        $fecha_i = date('Y-m-01');
        $fecha_f = Carbon::create('Y', 'm')->endOfMonth()->toDateString();
        $retrasos = self::getEtapasRetraso($fecha_i, $fecha_f);
        $fecha_envio = self::obtenerPrimerDiaHabilFromFecha($fecha_f);
        foreach ($retrasos as $retraso) {
            foreach ($retraso as $etapa) {
                $exist = ModelHistorialFechasNotificacion::where('id_st', '=', $etapa->id_st)
                    ->where('id_etapa', $etapa->id)->first();
                if ($exist) {
                    $exist->transcurrido = $etapa->diferencia;
                    $exist->retraso = $etapa->diferencia - $etapa->dias;
                    $exist->save();
                } else {
                    $data = [
                        'id_st' => $etapa->id_st,
                        'id_etapa' => $etapa->id,
                        'fecha_inicial' => $etapa->fecha_inicial,
                        'transcurrido' => $etapa->diferencia,
                        'retraso' => $etapa->diferencia - $etapa->dias,
                        'fecha_envio' => $fecha_envio,
                        'estado' => 'POR ENVIAR'
                    ];
                    $historialRetrasos = ModelHistorialFechasNotificacion::create($data);
                }
            }
        }
    }
    public function getEtapasRetraso($fecha_i = null, $fecha_f = null)
    {
        $query = ModelHistorialSeguimiento::select(
            'historial_seguimiento.id_st',
            'etapas_servicos.id',
            'etapas_servicos.etapa',
            'historial_seguimiento.fecha_inicial',
            DB::raw('CAST(etapas_servicos.dias AS UNSIGNED) as dias'),
            'historial_seguimiento.created_at',
            DB::raw('CASE WHEN DATEDIFF( CASE WHEN historial_seguimiento.fecha_final IS NULL THEN CURDATE() ELSE historial_seguimiento.fecha_final END , historial_seguimiento.fecha_inicial ) = 0 THEN 1 ELSE DATEDIFF( CASE WHEN historial_seguimiento.fecha_final IS NULL THEN CURDATE() ELSE historial_seguimiento.fecha_final END , historial_seguimiento.fecha_inicial ) - ( SELECT COUNT(*) FROM db_plataformas.fechasexcluidas fe WHERE fe.fecha BETWEEN historial_seguimiento.fecha_inicial AND CASE WHEN historial_seguimiento.fecha_final IS NULL THEN CURDATE() ELSE historial_seguimiento.fecha_final END ) END as diferencia'),
        )
            ->join('etapas_servicos', 'historial_seguimiento.id_proceso', '=', 'etapas_servicos.id')
            ->join('servicios_tecnicos', 'servicios_tecnicos.id_st', '=', 'historial_seguimiento.id_st')
            ->leftJoin('crear_ost_web', 'servicios_tecnicos.id_st', '=', 'crear_ost_web.num_ost')

            // ->where('servicios_tecnicos.respuesta_st', '<>', 'Cobrable')
            ->where('servicios_tecnicos.tipo_servicio', '=', 'CLIENTE')
            ->orderByDesc('historial_seguimiento.id_st');
        // Filtra por fechas
        if (!empty($fecha_i) && !empty($fecha_f)) {
            // Ambas fechas están presentes
            $query->whereBetween('historial_seguimiento.fecha_inicial', [$fecha_i, $fecha_f]);
        } elseif (!empty($fecha_i)) {
            // Solo fecha de inicio
            $query->where('historial_seguimiento.fecha_inicial', '>=', $fecha_i);
        } elseif (!empty($fecha_f)) {
            // Solo fecha final
            $query->where('historial_seguimiento.fecha_inicial', '<=', $fecha_f);
        } else {
            // Mostrar registros del mes actual | DEFAULT
            // $query->whereBetween('servicios_tecnicos.created_at', [$fechaActual, $fechaFinMesActual]);
        }

        $groupedData = $query->get()->groupBy('id_st');

        $groupedData = $groupedData->filter(function ($collection) {
            return $collection->contains(function ($item) {
                return $item->dias < $item->diferencia;
            });
        });

        $filteredData = $groupedData->map(function ($collection) {
            return $collection->filter(function ($item) {
                return $item->dias < $item->diferencia;
            });
        });
        return $filteredData;
    }
    public function enviarEmail($to, $data)
    {
        try {
            Mail::send('apps.servicios_tecnicos.servicios_tecnicos.seguimiento.reporte-tiempos-retrasos', ['data' => $data], function ($mail) use ($to) {
                $mail->to($to);
                $mail->subject('Tiempo de respuesta Orden de Servicio Excedido');
            });
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function obtenerPrimerDiaHabilFromFecha($fecha)
    {
        if (!self::esFestivo($fecha)) {
            return $fecha;
        } else {
            $newFecha = Carbon::createFromFormat('Y-m-d', $fecha)->addRealDay()->toDateString();
            return self::obtenerPrimerDiaHabilFromFecha($newFecha);
        }
    }
    public function esFestivo($fecha): bool
    {
        return ModelFechasExcluidas::where('fecha', '=', $fecha)->exists();
    }
}
