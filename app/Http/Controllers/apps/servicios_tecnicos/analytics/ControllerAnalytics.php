<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\analytics;

use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $months = ModelNuevaSolicitud::select(DB::raw('month(created_at) as mes'), DB::raw('count(id_st) as cantidad'))
            ->where('respuesta_st', '<>', 'Cobrable')
            ->whereYear('created_at', $year)->groupBy(DB::raw('month(created_at)'))->get();

        return view('apps.servicios_tecnicos.servicios_tecnicos.home', ['cantidad' => $count_st, 'items' => $data_, 'js' => $data_->toArray(), 'periodico' => $months->toArray()]);
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

        return response()->json(['data' => $data_->toArray(), 'items' => $items, 'cantidad' => $count_st], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
