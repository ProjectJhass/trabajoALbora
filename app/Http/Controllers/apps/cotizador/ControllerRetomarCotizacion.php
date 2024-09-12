<?php

namespace App\Http\Controllers\apps\cotizador;

use App\Http\Controllers\Controller;
use App\Models\apps\cotizador\ModelCotizacionesRealizadas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ControllerRetomarCotizacion extends Controller
{

    public function GuardarInfoClienteCotizacion()
    {
        $verificar = ModelCotizacionesRealizadas::where('idsession', session('IdSession'))->first();
        if (is_null($verificar)) {
            ModelCotizacionesRealizadas::create([
                'cedula' => session('cedula_cliente'),
                'nombre_1' => session('primer_nombre'),
                'nombre_2' => session('segundo_nombre'),
                'apellido_1' => session('primer_apellido'),
                'apellido_2' => session('segundo_apellido'),
                'direccion' => session('direccion'),
                'ciudad' => session('ciudad'),
                'barrio' => session('barrio'),
                'celular_1' => session('telefono1'),
                'celular_2' => session('telefono2'),
                'email' => session('correo'),
                'genero' => session('genero'),
                'fecha' => date('Y-m-d'),
                'idsession' => session('IdSession'),
                'vendedor' => Auth::user()->nombre,
                'almacen' => Auth::user()->sucursal
            ]);
        }
    }

    public function ObtenerInformacionUltimasCotizaciones(Request $request)
    {
        $historial = '';

        $fecha_actual = date_create(date('Y-m-d'));
        $cedula = $request->cedula;

        if (!empty($cedula)) {
            $cotizaciones = ModelCotizacionesRealizadas::where('cedula', $cedula)->orderByDesc('fecha')->limit(3)->get();

            if (count($cotizaciones) > 0) {
                foreach ($cotizaciones as $key => $value) {

                    $fecha_cotizacion = date_create($value->fecha);
                    $diferencia = $fecha_cotizacion->diff($fecha_actual);
                    $dias = $diferencia->format("%a");

                    $historial .= '<div>
                    <i class="fas fa-user bg-green"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fas fa-clock"></i>   ' . $value->fecha . '</span>
                        <h3 class="timeline-header"><span style="color: blue">' . $value->nombre_1 . ' ' . $value->apellido_1 . '</span></h3>
                        <div class="timeline-body">
                            <p>
                            <strong><small>Asesor:</strong> ' . $value->vendedor . '</small><br>
                            <strong><small>Almacen:</strong> ' . $value->almacen . '</small>
                            </p>
                            ';
                    if ($dias <= 15) {

                        $historial .= '<a href="' . route('retomar.cotizacion.prueba', ['id_retomar' => $value->id_retomar]) . '" class="btn btn-info btn-sm">Retomar</a>';
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
        $value = ModelCotizacionesRealizadas::find($id_retomar);

        $data = ([
            'IdSession' => $value->idsession,
            'cedula_cliente' => $value->cedula,
            'primer_nombre' => $value->nombre_1,
            'segundo_nombre' => $value->nombre_2,
            'primer_apellido' => $value->apellido_1,
            'segundo_apellido' => $value->apellido_2,
            'direccion' => $value->direccion,
            'ciudad' => $value->ciudad,
            'barrio' => $value->barrio,
            'telefono1' => $value->celular_1,
            'telefono2' => $value->celular_2,
            'correo' => $value->email,
            'genero' => $value->genero,
            'categoria' => '',
            'observaciones' => ''
        ]);

        session($data);

        return redirect(route('liquidar.cotizacion'));
    }
}
