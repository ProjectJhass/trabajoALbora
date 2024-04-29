<?php

namespace App\Http\Controllers\apps\intranet;

use App\Exports\InfoViewsFlayer;
use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelFlayer;
use App\Models\apps\intranet\ModelInfoFlayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ControllerRegisterFlayer extends Controller
{
    public function registerF()
    {
        ModelInfoFlayer::create([
            'cedula' => Auth::user()->id,
            'nombre' => Auth::user()->nombre,
            'fecha' => date('Y-m-d')
        ]);
    }

    public function validateImgFlayer(Request $request)
    {
        $img = "";

        if(Auth::user()->id == '' || empty(Auth::user()->id)){
            return response()->json([], 302, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        if ($request->has('val')) {
            $cedula = Auth::user()->id;

            $date = date('Y-m-d');
            $init = date("Y-m") . "-01";
            $fin = date("Y-m") . "-15";

            $periodo = $date >= $init && $date < $fin ? 1 : 2;
            $operador = $periodo == 1 ? "<" : ">=";
            $fecha_evaluar = $periodo == 1 ? $init : $fin;

            $valor = ModelInfoFlayer::where('fecha', $operador, $fecha_evaluar)->where('id_estado', '<>', '0')->where('cedula', $cedula)->count();

            $bool = $valor == 0 ? true : false;

            if ($bool) {
                $img = ModelFlayer::all();
                foreach ($img as $key => $value) {
                    $url = $value->url;
                }
                $img = '<img src="' . asset($url) . '" width="90%" alt="">';
            }

            return response()->json(['status' => $bool, 'img' => $img], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        return response()->json([], 302, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function saveInfoViewFlayer(Request $request)
    {
        $id_estado = $request->id_estado;
        $estado = $request->estado;
        $cedula = Auth::user()->id;
        $nombre = Auth::user()->nombre;
        $fecha = date('Y-m-d');

        ModelInfoFlayer::create([
            'cedula' => $cedula,
            'nombre' => $nombre,
            'fecha' => $fecha,
            'id_estado' => $id_estado,
            'estado' => $estado
        ]);
    }

    public function ExportInfoFlayer(Request $request)
    {
        $month = $request->month;
        return Excel::download(new InfoViewsFlayer($month), 'Visualizacion Flayer.xlsx');
    }
}
