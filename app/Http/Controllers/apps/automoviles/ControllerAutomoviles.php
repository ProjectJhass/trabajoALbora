<?php

namespace App\Http\Controllers\apps\automoviles;

use App\Http\Controllers\Controller;
use App\Models\apps\automoviles\ModelAutomoviles;
use App\Models\apps\automoviles\ModelKmRecorridos;
use App\Models\soap\autos_ModelConsultas;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class ControllerAutomoviles extends Controller
{
    public function index()
    {
        session()->forget(['fecha_info_i', 'fecha_info_f']);

        $autos = ModelAutomoviles::where('estado', '<>', '0')->get();
        return view('apps.automoviles.automoviles.autos', ['autos' => $autos]);
    }

    public function ConsultarFechas(Request $request)
    {
        $fecha_i = $request->fecha_i . "-01";
        $data_fecha_f = date('Y-m-d', strtotime($request->fecha_f . " + 1 month"));
        $fecha_f = date('Y-m-d', strtotime($data_fecha_f . " - 1 day"));

        session(['fecha_info_i' => $fecha_i, 'fecha_info_f' => $fecha_f]);

        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function InformacionAuto(Request $request)
    {

        $id_auto = $request->id_auto;
        $placa = $request->placa;
        $row_id = $request->row_id;

        $prom_valor_galon = '10500';
        $meses = (['1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre']);

        $fecha_i = (!empty(session('fecha_info_i')) && session('fecha_info_i') != '') ? date('Y-m-d', strtotime(session('fecha_info_i'))) : date('Y-m') . "-01";
        $fecha_f = (!empty(session('fecha_info_f')) && session('fecha_info_f') != '') ? date('Y-m-d', strtotime(session('fecha_info_f'))) : date('Y-m-d');

        $fecha_i_c = new DateTime($fecha_i . " 00:00:00");
        $fecha_f_c = new DateTime($fecha_f . " 23:59:59");

        $intervalo = $fecha_f_c->diff($fecha_i_c);
        $intervalo_meses = $intervalo->format("%m");
        $intervalo_years = $intervalo->format('%y') * 12;

        $meses_transcurridos = (($intervalo_meses + $intervalo_years) == 0) ? 1 : ($intervalo_meses + $intervalo_years);
        $fecha_for = $fecha_i;
        $info_auto = ModelAutomoviles::find($id_auto);

        $km_recorridos_ = 0;
        $info_km = ModelKmRecorridos::where('placa', $info_auto->placa)->whereBetween('fecha', [$fecha_i, $fecha_f])->get();
        foreach ($info_km as $key => $value) {
            $km_recorridos_ += str_replace(",", ".", $value->km_recorridos);
        }
        $km_recorridos = $km_recorridos_;

        $gasolina = autos_ModelConsultas::ObtenerGastoGasolinaRangoAuto($row_id, $fecha_i, $fecha_f);
        $mantenimiento = autos_ModelConsultas::ObtenerGastosMttoRangoAuto($row_id, $fecha_i, $fecha_f);
        $gastos_mantenimiento = autos_ModelConsultas::ObtenerInformacionMantenimientoAutos($row_id, $fecha_i, $fecha_f);

        $data_meses = [];

        for ($i = 0; $i <= $meses_transcurridos; $i++) {
            $fecha_inicial = $fecha_for;

            $mes_b = str_replace(['-0', '-'], '', date("-m", strtotime($fecha_inicial)));
            $year_b = date("Y", strtotime($fecha_inicial));

            $km_mes = 0;
            $info_km_ = ModelKmRecorridos::where('placa', $info_auto->placa)->whereYear('fecha', $year_b)->whereMonth('fecha', $mes_b)->get();
            foreach ($info_km_ as $key => $value) {
                $km_mes += str_replace(",", ".", $value->km_recorridos);
            }

            $gasto_gasolina = autos_ModelConsultas::ObtenerGastosGasolinaMeses($row_id, $year_b, $mes_b);
            $gastos_Mtto = autos_ModelConsultas::ObtenerGastosMttoMeses($row_id, $year_b, $mes_b);

            array_push($data_meses, (['year' => $year_b, 'month' => $meses[$mes_b], 'galones' => ($gasto_gasolina / $prom_valor_galon), 'km_recorridos' => $km_mes, 'inversion' => $gasto_gasolina, 'gasto_mtto' => $gastos_Mtto]));
            $fecha_for = date("Y-m", strtotime($fecha_inicial . "+ 1 month"));
        }

        return view('apps.automoviles.automoviles.informacion', ['fecha_i' => $fecha_i, 'fecha_f' => $fecha_f, 'info_auto' => $info_auto, 'km_recorridos' => $km_recorridos, 'gasto_combustible' => $gasolina, 'gasto_mtto' => $mantenimiento, 'data' => $gastos_mantenimiento, 'data_tabla' => $data_meses]);
    }

    public function ActualizarImagenAutomovil(Request $request)
    {
        $tipos = array('jpg', 'jpeg', 'png', 'jfif');
        if ($request->hasFile('pic_auto')) {

            $idAuto = $request->dataId;

            $documento = $request->file('pic_auto');
            $nombre = $documento->getClientOriginalName();
            $tipo = $documento->getClientOriginalExtension();

            if (in_array(strtolower($tipo), $tipos)) {
                $nombre_cargue = uniqid() . "_" . $nombre;

                $response_file = $documento->storeAs('public/autos/', $nombre_cargue);

                $url = '<a href="' . asset('storage/autos/' . $nombre_cargue) . '" target="_BLANK"><img src="' . asset('storage/autos/' . $nombre_cargue) . '" width="80%" alt="Imagen Autos Albura"></a>';

                if ($response_file) {
                    $data = ([
                        'imagen' => $nombre_cargue,
                        'updated_at' => Carbon::now()
                    ]);

                    $response = ModelAutomoviles::ActualizarAuto($idAuto, $data);
                    if ($response) {
                        return response()->json(['status' => true, 'img' => $url], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                    }
                    return response()->json([], 302, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                }
            }
            return response()->json([$tipo], 419, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
        return response()->json([], 502, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
