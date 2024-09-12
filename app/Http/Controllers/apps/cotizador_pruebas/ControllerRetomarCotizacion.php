<?php

namespace App\Http\Controllers\apps\cotizador_pruebas;

use App\Http\Controllers\Controller;
use App\Models\apps\cotizador_pruebas\ModelCotizacionesRealizadas;
use App\Models\apps\cotizador_pruebas\ModelInfoClientesCRM;
use App\Models\apps\intranet\ModelUsersIntranet;
use App\Models\User;
use Illuminate\Http\Request;

class ControllerRetomarCotizacion extends Controller
{
    public function getCotizacionesCliente(Request $request)
    {
        $historial = '';

        $fecha_actual = date_create(date('Y-m-d'));
        $cedula = $request->cedula;

        if (!empty($cedula)) {
            $cotizaciones = ModelInfoClientesCRM::where('cedula_cliente', $cedula)->orderByDesc('fecha_registro')->limit(3)->get();

            if (count($cotizaciones) > 0) {
                foreach ($cotizaciones as $key => $value) {

                    $id_asesor_ = $value->cedula_asesor;
                    $info_u = User::find($id_asesor_);

                    $fecha_cotizacion = date_create($value->fecha_registro);
                    $diferencia = $fecha_cotizacion->diff($fecha_actual);
                    $dias = $diferencia->format("%a");

                    $historial .= '<div>
                    <i class="fas fa-user bg-green"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fas fa-clock"></i>   ' . $value->fecha_registro . '</span>
                        <h3 class="timeline-header"><span style="color: blue">' . $value->nombre_1 . ' ' . $value->apellido_1 . '</span></h3>
                        <div class="timeline-body">
                            <p>
                            <strong><small>Asesor:</strong> ' . (isset($info_u->nombre) ? $info_u->nombre : '') . '</small><br>
                            <strong><small>Almacen:</strong> ' . (isset($info_u->sucursal) ? $info_u->sucursal : '') . '</small>
                            </p>
                            ';
                    if ($dias <= 15) {

                        $historial .= '<a href="' . route('retomar.cotizacion.crexit', ['id_retomar' => $value->id_cliente]) . '" class="btn btn-info btn-sm">Retomar</a>';
                    }
                    $historial .= '
                        </div>
                    </div>
                </div>';
                }

                return response()->json(['status' => true, 'historial' => $historial], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            } else {
                return response()->json(['status' => false, 'mensaje' => 'No hay cotizaciones para este número de cédula'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }
    }

    public function RetomarCotizacionCliente($id_retomar)
    {
        $value = ModelInfoClientesCRM::find($id_retomar);
        session(['IdSession' => $value->id_cotizacion]);
        return redirect(route('liquidar.cotizacion.crexit'));
    }
}
