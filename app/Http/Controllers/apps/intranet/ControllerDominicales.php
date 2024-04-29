<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelDominicales;
use Illuminate\Http\Request;
use App\Http\Controllers\apps\intranet\ControllerIngresosSalidas as vista;

class ControllerDominicales extends Controller
{
   
    public function sesionZonas(Request $request)
    {
        session(['zona_calendario' => $request->buscar_zona]);
        $view = new vista;
        return $view->dominicales();
    }

    public function bloquearEventos(Request $request)
    {
        if ($request->evento == 1) {
            if (ModelDominicales::BloquearEventos()) {
                return response()->json(['status' => true, 'mensaje' => 'Las fechas fueron bloqueadas'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            } else {
                return response()->json(['status' => false, 'mensaje' => 'No hay datos por actualizar'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }
    }

    public function agregarNuevoEvento(Request $request)
    {
        $data = ([
            'cedula_evento' => $request->has('cedula_u') ? $request->cedula_u : rand(16536, 24857),
            'nombre_evento' => $request->nombre_e,
            'fecha_i' => $request->fecha_i,
            'fecha_f' => date("Y-m-d", strtotime($request->fecha_i . "+ 1 days")),
            'allDay' => '1',
            'url' => $request->url,
            'color' => $request->color,
            'border_color' => $request->color,
            'tipo_evento' => $request->evento,
            'zona' => $request->zona,
            'bloqueado' => '0'
        ]);
        if (ModelDominicales::AgregarEventos($data)) {
            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function actualizarFechaEvento(Request $request)
    {
        $data = ([
            'fecha_i' => date("Y-m-d", strtotime($request->fecha_i . "+ 1 days")),
            'fecha_f' => date("Y-m-d", strtotime($request->fecha_f . "+ 1 days"))
        ]);
        if (ModelDominicales::ActualizarEvento($request->id_evento, $data)) {
            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function actualizarEvento(Request $request)
    {

        $reemplazo = explode('/', $request->cedula_reemplaza_prog);

        $data = ([
            'nombre_evento' => $request->nombre_prog_cal,
            'fecha_i' => $request->fecha_i_prog_cal,
            'fecha_f' => date("Y-m-d", strtotime($request->fecha_f_prog_cal . "+ 1 days")),
            'allDay' => '1',
            'url' => $request->url_prog_cal,
            'color' => ModelDominicales::ObtenerColorEvento($request->tipo_evento_prog_cal),
            'border_color' => ModelDominicales::ObtenerColorEvento($request->tipo_evento_prog_cal),
            'tipo_evento' => $request->tipo_evento_prog_cal,
            'observaciones' => $request->observacion_evento_cal,
            'cedula_reemplaza' => $reemplazo[0],
            'nombre_reemplaza' => $reemplazo[1]
        ]);
        if (ModelDominicales::ActualizarEvento($request->id_prog_cal, $data)) {
            return response()->json(['status' => true, 'mensaje' => 'Información actualizada'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        } else {
            return response()->json(['status' => false, 'mensaje' => 'No hay datos por actualizar'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function eliminarEvento(Request $request)
    {
        if (!empty($request->id_evento)) {
            if (ModelDominicales::EliminarEvento($request->id_evento)) {
                return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }
    }
}
