<?php

namespace App\Http\Controllers\apps\intranet_fabrica;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet_fabrica\ModelInicio;
use App\Models\apps\intranet_fabrica\ModelMantenimientos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerInicioFabrica extends Controller
{
    public function validacionDate($fecha_min)
    {
        $fecha = $fecha_min;
        $aux = 0;

        do {
            $n_fecha = date("Y-m-d", strtotime($fecha  . "- 1 days"));
            $validar = ModelMantenimientos::getDaysNoJob($n_fecha);
            $fecha = $n_fecha;
            if ($validar ==  0) {

                $aux = $aux + 1;
            }

            if ($aux == 2) {

                $validar = 0;
            } else {
                $validar++;
            }
        } while ($validar != 0);
        return $fecha;
    }

    public function index()
    {
        $self_id = Auth::user()->id;
        $fecha_hoy = date('Y-m-d');
        $fecha_max = date("Y-m-d", strtotime($fecha_hoy  . "+ 5 days"));
        $fecha_min = date("Y-m-d", strtotime($fecha_hoy));
        $fecha_inicial = self::validacionDate($fecha_min);
        $consulta = ModelMantenimientos::getMantenimientos($self_id, $fecha_inicial, $fecha_max);

        $validar = (count($consulta) > 0) ? true : false;
        $imagenes = ModelInicio::ImagenesDB();
        return view('apps.intranet_fabrica.fabrica.home', ['imagenes' => $imagenes, 'alerta' => $validar]);
    }
}
