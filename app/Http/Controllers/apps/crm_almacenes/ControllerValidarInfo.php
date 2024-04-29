<?php

namespace App\Http\Controllers\apps\crm_almacenes;

use App\Http\Controllers\Controller;
use App\Models\apps\crm_almacenes\ModelClientesCRM;
use App\Models\apps\crm_almacenes\ModelInfoCiudades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerValidarInfo extends Controller
{
    public function index(Request $request)
    {
        $asesor_ = Auth::user()->id;
        $date_d = date('d');
        $date_m = date('m');

        $data = array();
        $noti = '';
        if (isset($request->validar) && !empty($request->validar)) {

            $llamadas = ModelClientesCRM::join('llamadas_a_realizar as l', 'clientes_crm.id_cliente', 'l.id_cliente')
                ->where('clientes_crm.cedula_asesor', $asesor_)
                ->where('l.estado', 'PENDIENTE')
                ->where('l.fecha_a_llamar', '<=', date('Y-m-d'))
                ->get();


            $cumple =  ModelClientesCRM::whereDay('fecha_cumple', $date_d)
                ->whereMonth('fecha_cumple', $date_m)
                ->where('cedula_asesor', $asesor_)
                ->get();


            if (count($llamadas) > 0) {
                foreach ($llamadas as $key => $value) {
                    array_push($data, array('nombre' => $value->nombre_1 . " " . $value->nombre_2 . " " . $value->apellido_1 . " " . $value->apellido_2));
                }
            }
            if (count($cumple) > 0) {
                foreach ($cumple as $key => $val) {
                    $icon = ($val->genero == 'MUJER') ? 'women.png' : 'man.png';
                    $noti .= '<div class="dropdown-item">
                    <div class="media">
                        <img src="' . asset('img/' . $icon) . '" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                ' . $val->nombre_1 . " " . $val->nombre_2 . " " . $val->apellido_1 . " " . $val->apellido_2 . '
                            </h3>
                            <p class="text-sm">Cumpleaños</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> Hoy</p>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>';
                }
            }

            return response()->json(['status' => true, 'cantidad' => count($llamadas), 'data' => $data, 'cant_cumple' => count($cumple), 'cumple' => $noti], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function ObtenerCiudades(Request $request)
    {
        $id_depto = $request->id;
        $info_ = ModelInfoCiudades::where('id_depto', $id_depto)->get();

        $val = '<option value="">Seleccionar...</option>';
        foreach ($info_ as $key => $value) {
            $val .= '<option value="' . $value->ciudad . '" data-id_city="' . $value->id_city . '" data-id_depto="' . $value->id_depto . '" data-id_pais="' . $value->id_pais . '">' . $value->ciudad . '</option>';
        }
        return response()->json(['status' => true, 'ciudad' => $val], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
