<?php

namespace App\Http\Controllers\apps\intranet_fabrica;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet_fabrica\ModelCerrarSolicitudMtto;
use App\Models\apps\intranet_fabrica\ModelSolicitudesMtto;
use Illuminate\Http\Request;

class ControllerCerrarSolicitudMtto extends Controller
{
    public function CerrarSolicitudesMtto()
    {
        $secciones = ModelSolicitudesMtto::ObtenerSeccionesFabrica();
        return view('apps.intranet_fabrica.fabrica.solicitud_mantenimiento.cerrar_solicitud.cerrar_solicitud', ['secciones' => $secciones]);
    }

    public function DefinirSolicitudMtto(Request $request)
    {
        $data = (['responsable_recibe' => $request->responsable, 'fecha_recibe' => $request->fecha_fin, 'estado_solicitud' => 'CERRADA']);
        $response = ModelCerrarSolicitudMtto::ActualizarCerrarSolicitudMtto($request->id_solicitud, $data);
        if ($response) {
            return response()->json(['status' => true, 'id_solicitud' => $request->id_solicitud], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function ObtenerInformacionPorSeccion(Request $request)
    {
        $data = ModelCerrarSolicitudMtto::ObtenerSolicitudesAbiertas($request->seccion);
        $table = '';
        $url = route('historial.mtto');
        foreach ($data as $key => $value) {
            $table .= '<tr>
            <td>' . $value->id_solicitud . '</td>
            <td>' . $value->maquina . '</td>
            <td>' . $value->solicitud . '</td>
            <td class="text-center">' . $value->fecha_solicitud . '</td>
            <td class="text-center"><button type="button" id="btn-cerrar-mmto' . $value->id_solicitud . '" onclick=' . "ModalCerrarSolicitudMtto('$value->id_solicitud','$url')" . ' class="btn btn-warning"><i class="fas fa-eye"></i></button></td>
        </tr>';
        }
        return response()->json(['status' => true, 'data' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function ObtenerHistorialSolicitudMtto(Request $request)
    {
        $informacion = ModelCerrarSolicitudMtto::ObtenerHistorialSolicitudMtto($request->id_solicitud);
        foreach ($informacion as $key => $value) {
            $data = '<div class="col-md-12">
        <div class="card card-outline card-danger ">
            <div class="card-header">
                Solicitud
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                            <label for="">Id solicitud</label>
                            <input type="text" class="form-control" value="' . $value->id_solicitud . '" name="id_cerrar_solicit_mtto" id="id_cerrar_solicit_mtto" disabled>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="">Máquina</label>
                            <textarea name="" id="" class="form-control" cols="30" rows="1" disabled>' . $value->maquina . '</textarea>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="">Daño reportado</label>
                            <textarea name="" id="" class="form-control" cols="30" rows="1" disabled>' . $value->solicitud . '</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card card-outline card-danger ">
            <div class="card-header">
                Solución
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="">Solución</label>
                        <textarea name="" id="" class="form-control" cols="30" rows="1" disabled>' . $value->respuesta_solicitud . '</textarea>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Fecha</label>
                        <input type="date" class="form-control" value="' . $value->fecha_respuesta . '" name="" id="" disabled>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Responsable</label>
                        <input type="text" class="form-control" value="' . $value->responsable_respuesta . '" name="" id="" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>';
        }
        return response()->json(['status' => true, 'data' => $data], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
