<?php

namespace App\Http\Controllers\apps\automoviles;

use App\Http\Controllers\Controller;
use App\Models\apps\automoviles\ModelAutomoviles;
use App\Models\apps\automoviles\ModelPolizas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ControllerPolizas extends Controller
{
    public function index()
    {
        $autos = ModelAutomoviles::where('estado', '<>', '0')->get();
        return view('apps.automoviles.automoviles.polizas', ['autos' => $autos]);
    }

    public function actualizar(Request $request)
    {
        if ($request->isMethod('post')) {

            $id_auto = $request->id;
            $columna = $request->campo;
            $valor = $request->fecha;
            $data_auto = ModelAutomoviles::where('id_auto', $id_auto)->update([$columna => $valor]);

            if ($data_auto) {
                return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }
    }

    public function cargarDocumentacion(Request $request)
    {
        if ($request->hasFile('doc_poliza') && !empty($request->renovar_placa) && !empty($request->renovar_poliza) && !empty($request->fecha_vencimiento)) {

            $id_placa = $request->renovar_placa;
            $placa = $request->dataPlaca;
            $poliza = $request->renovar_poliza;
            $fecha_vto = $request->fecha_vencimiento;

            $documento = $request->file('doc_poliza');
            $nombre = $documento->getClientOriginalName();
            $tipo = $documento->getClientOriginalExtension();

            $nombre_doc = str_replace('.' . $tipo, '', $nombre);
            $nombre_cargue = uniqid() . "_" . $nombre;

            $response_file = $documento->storeAs('public/polizas-de-seguro', $nombre_cargue);
            if ($response_file) {
                $data_f = ([$poliza => $fecha_vto, 'updated_at' => Carbon::now()]);

                ModelPolizas::create([
                    'id_placa' => $id_placa,
                    'placa' => $placa,
                    'poliza' => $poliza,
                    'nombre_pdf' => $nombre_doc,
                    'pdf' => $nombre_cargue,
                    'tipo' => $tipo,
                    'url' => $response_file,
                    'fecha' => date('Y-m-d')
                ]);
                ModelAutomoviles::where('id_auto', $id_placa)->update([$poliza => $fecha_vto]);
                return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }
    }

    public function historial(Request $request)
    {
        $placa = $request->placa;
        $info = [];
        $history = '';
        $data = ModelPolizas::where('placa', $placa)->orderByDesc('created_at')->get();
        foreach ($data as $key => $value) {
            $nom_poliza = $value->poliza == 'riesgo' ? 'TODO ' . strtoupper($value->poliza) : strtoupper($value->poliza);
            $url = str_replace('public/', '', $value->url);
            $history .= '<a href="' . asset('storage/' . $url) . '" target="_BLANK" class="list-group-item list-group-item-action">' . $nom_poliza . ' ' . $value->fecha . '</a>';
        }
        return response()->json(['status' => true, 'data' => $history], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
