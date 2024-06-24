<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\analytics;

use App\Exports\ExportInfoTiemposRespuestaSt;
use App\Exports\ExportInfoCausalidades;
use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use App\Models\apps\servicios_tecnicos\servicios\ModelHistorialSeguimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ControllerAnalytics extends Controller
{
    public function home()
    {
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
        $causalidades_graph = self::getCausalidadesGraph('');
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

    public function getInfoHistorialSeguimiento($orden_servicio, $limit = null)
    {
        if (empty($orden_servicio)) {
            $data = ModelHistorialSeguimiento::select(
                'historial_seguimiento.id_st',
                'etapas_servicos.id',
                'etapas_servicos.etapa',
                'etapas_servicos.dias',
                'historial_seguimiento.created_at',
                DB::raw('DATEDIFF(historial_seguimiento.updated_at, historial_seguimiento.created_at) as diferencia')
            )
                ->join('etapas_servicos', 'historial_seguimiento.id_proceso', '=', 'etapas_servicos.id')
                ->join('servicios_tecnicos', 'servicios_tecnicos.id_st', '=', 'historial_seguimiento.id_st')
                ->leftJoin('crear_ost_web', 'servicios_tecnicos.id_st', '=', 'crear_ost_web.num_ost')
                ->where('servicios_tecnicos.respuesta_st', '<>', 'Cobrable')
                ->orderByDesc('historial_seguimiento.id_st')
                ->limit($limit)
                ->get();
        } else {
            $data = ModelHistorialSeguimiento::select(
                'historial_seguimiento.id_st',
                'etapas_servicos.id',
                'etapas_servicos.etapa',
                'etapas_servicos.dias',
                'historial_seguimiento.created_at',
                DB::raw('DATEDIFF(historial_seguimiento.updated_at, historial_seguimiento.created_at) as diferencia')
            )
                ->join('etapas_servicos', 'historial_seguimiento.id_proceso', '=', 'etapas_servicos.id')
                ->join('servicios_tecnicos', 'servicios_tecnicos.id_st', '=', 'historial_seguimiento.id_st')
                ->leftJoin('crear_ost_web', 'servicios_tecnicos.id_st', '=', 'crear_ost_web.num_ost')
                ->where('servicios_tecnicos.respuesta_st', '<>', 'Cobrable')
                ->orderByDesc('historial_seguimiento.id_st')
                ->where('historial_seguimiento.id_st', 'like', "%{$orden_servicio}%")
                ->orWhere('servicios_tecnicos.cedula', 'like', "%{$orden_servicio}%")
                ->orWhere('crear_ost_web.n_ticket', 'like', "%{$orden_servicio}%")
                ->limit($limit)
                ->get();
        }

        $data_info = [];

        foreach ($data as $value) {
            $st = $value->id_st;

            if (!isset($data_info[$st])) {
                $data_info[$st] = [];
            }
            $diferencia = $value->diferencia;
            if ($diferencia == 0) {
                $diferencia = 1;
            }
            $data_info[$st][] = [
                'id_st' => $value->id_st,
                'id' => $value->id,
                'etapa' => $value->etapa,
                'dias' => $value->dias,
                'diferencia' => $diferencia,
            ];
        }
        return $data_info;
    }
    public function getTiemposRespuestaTable($orden_servicio)
    {
        $data_info = self::getInfoHistorialSeguimiento($orden_servicio);
        return view('apps.servicios_tecnicos.servicios_tecnicos.seguimiento.tiempos_respuesta', ['data' => $data_info])->render();
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
        $orden_servicio = $request->co;
        if (isset($orden_servicio)) {
            $tiempos_graph = self::getTiemposRespuestaGraph($orden_servicio);
        } else {
            $tiempos_graph = self::getTiemposRespuestaGraph('');
        }
        return response()->json(['status' => true, 'graph' => $tiempos_graph], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
    public function getTiemposRespuestaGraph($orden_servicio)
    {
        $data_info = self::getInfoHistorialSeguimiento($orden_servicio, 60);
        return view('apps.servicios_tecnicos.servicios_tecnicos.seguimiento.grafica_tiempos', ['data' => $data_info])->render();
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

    public function getInfoCausalidades($filtro)
    {
        if (empty($filtro)) {
            $data = ModelNuevaSolicitud::select('id_st', 'causales')
                ->whereNotNull('causales')
                ->where('causales', '!=', '')
                ->get();
        } else {
            $data = ModelNuevaSolicitud::select('id_st', 'causales')
                ->whereNotNull('causales')
                ->where('causales', '!=', '')
                ->orWhere('causales', 'like', $filtro)
                ->orWhere('id_st', 'like', $filtro)
                ->get();
        }
        $causales = [];
        $data_info = [];


        foreach ($data as $value) {
            $st = $value->id_st;

            if (str_contains($value->causales, ',')) {
                $causalesExploded = explode(',', $value->causales);
                foreach ($causalesExploded as $causal) {
                    $causales[] = $causal;
                }
            } else {
                $causales[] = $value->causales;
            }

            if (!isset($data_info[$st])) {
                $data_info[$st] = [];
            }
            $data_info[$st][] = [
                'id' => $value->id_st,
                'causales' => $value->causales
            ];
        }
        $count = array_count_values($causales);

        return $count;
    }
    public function getCausalidadesGraph($filtro)
    {
        $data = self::getInfoCausalidades($filtro);
        return view('apps.servicios_tecnicos.servicios_tecnicos.seguimiento.causalidades', ['data' => $data])->render();
    }

    public function exportTiemposRespuesta(Request $request)
    {
        $orden_servicio = $request->orden_servicio;
        $export = new ExportInfoTiemposRespuestaSt($orden_servicio);
        return Excel::download($export, 'info-tiempos-respuesta-servicios-tecnicos.xlsx');
    }

    public function exportCausales()
    {
        $export = new ExportInfoCausalidades();
        return Excel::download($export, 'info-causalidades-servicios-tecnicos.xlsx');
    }
}
