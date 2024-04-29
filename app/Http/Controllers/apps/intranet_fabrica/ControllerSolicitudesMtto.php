<?php

namespace App\Http\Controllers\apps\intranet_fabrica;

use App\Exports\SolicitudesMttoFecha;
use App\Http\Controllers\Controller;
use App\Models\apps\intranet_fabrica\ModelCerrarSolicitudMtto;
use App\Models\apps\intranet_fabrica\ModelSolicitudesMtto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ControllerSolicitudesMtto extends Controller
{
    public function MenuSolicitudes()
    {
        return view('apps.intranet_fabrica.fabrica.solicitud_mantenimiento.menu');
    }

    public function ConsultarSolicitudNumero()
    {
        return view('apps.intranet_fabrica.fabrica.solicitud_mantenimiento.consultar_numero');
    }

    public function ConsultarSolicitudFecha()
    {
        return view('apps.intranet_fabrica.fabrica.solicitud_mantenimiento.consultar_fecha');
    }

    public function GenerarSolicitudMtto()
    {
        $herramientas = ModelSolicitudesMtto::ObtenerHerramientasFabrica();
        $secciones = ModelSolicitudesMtto::ObtenerSeccionesFabrica();
        return view('apps.intranet_fabrica.fabrica.solicitud_mantenimiento.crear_solicitud', ['herramientas' => $herramientas, 'secciones' => $secciones]);
    }

    public function ConsultarInformacionSolicitud(Request $request)
    {
        if (!empty($request->id_solicitud)) {
            $informacion = ModelSolicitudesMtto::ObtenerInformacionSolicitudes($request->id_solicitud);
            $data = '<div class="alert alert-danger" role="alert">No hay información para esta solicitud</div>';
            foreach ($informacion as $key => $value) {
                $data = '<div class="card card-outline card-secondary">
                                    <div class="card-header">
                                        <div class="row text-center">
                                            <div class="col-md-6 mb-3" style="border: 1px solid; border-radius: 12px;">
                                                <img src=' . asset('img/BLANCO.png') . ' width="50%" alt="">
                                            </div>
                                            <div class="col-md-6 mb-3" style="border: 1px solid; border-radius: 12px;">
                                                <h5><strong>SOLICITUD DE SERVICIO DE <br> MANTENIMIENTO</strong></h5>
                                            </div>
                                            <div class="col-md-4" style="border: 1px solid; border-radius: 12px;">
                                                <strong>CÓDIGO: FO-MTO-02</strong>
                                            </div>
                                            <div class="col-md-4" style="border: 1px solid; border-radius: 12px;">
                                                <strong>VERSIÓN: 04</strong>
                                            </div>
                                            <div class="col-md-4" style="border: 1px solid; border-radius: 12px;">
                                                <strong>PÁGINA: 1</strong>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6 mb-2">
                                                <strong>FECHA DE SOLICITUD:      </strong>' . $value->fecha_solicitud . '
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <strong>NÚMERO DE SOLICITUD:      </strong>' . $value->id_solicitud . '
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <strong>MÁQUINA:      </strong>' . $value->maquina . '
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <strong>SECCIÓN:      </strong>' . $value->seccion . '
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <strong>ESTADO:      </strong>' . $value->estado_solicitud . '
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-12 mb-3">
                                                <u><strong>DESCRIPCIÓN DEL REQUERIMIENTO</strong></u>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                            <p style="text-align:justify;">' . $value->solicitud . '</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12 mb-3">
                                                <u><strong>SOLUCIÓN AL REQUERIMIENTO</strong></u>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                            <p style="text-align:justify;">' . $value->respuesta_solicitud . '</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-4 mb-3 text-center" style="border: 1px solid;">
                                                <h5 style="margin-top: 7%; margin-bottom: 7%; color: rgba(82, 82, 82, 0.685)">COPIA CONTROLADA <br> SGC</h5>
                                            </div>
                                            <div class="col-md-4 mb-3 text-center" style="border: 1px solid;">
                                            <h5>' . $value->responsable_s . '</h5>
                                            <p><small><strong>Responsable de solicitud</strong></small></p>
                                            </div>
                                            <div class="col-md-4 mb-3 text-center" style="border: 1px solid;">
                                            <h5>' . $value->responsable_s . '</h5>
                                            <p><small><strong>Responsable de solución</strong></small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
            }

            return response()->json(['status' => true, 'data' => $data], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function GuardarInformacionNuevaSolicitud(Request $request)
    {
        $datos = ([
            'solicitud' => $request->requerimiento_solicitud,
            'seccion' => $request->nombre_seccion_solicitar,
            'maquina' => $request->herramienta_solicitar,
            'responsable_s' => $request->responsable_solicitud,
            'fecha_solicitud' => date('y-m-d'),
            'estado_solicitud' => 'ABIERTA'
        ]);
        $insert_id = ModelSolicitudesMtto::AgregarNuevasSolicitudesMtto($datos);
        if ($insert_id > 0) {
            return response()->json(['status' => true, 'id' => $insert_id], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function ObtenerExportarSolicitudesFecha(Request $request)
    {
        $fecha_i = $request->fecha_inicio;
        $fecha_f = $request->fecha_fin;
        if (!empty($fecha_i) && !empty($fecha_f)) {
            return Excel::download(new SolicitudesMttoFecha($fecha_i, $fecha_f), 'SolicitudesMtto.xlsx');
        } else {
            return view('apps.intranet_fabrica.fabrica.solicitud_mantenimiento.consultar_fecha', ['error' => 1]);
        }
    }

    public function SolicitudesMantenimientoPendientes()
    {
        $solicitudes = ModelSolicitudesMtto::ObtenerSolicitudesMttoPendientes();
        return view('apps.intranet_fabrica.fabrica.solicitud_mantenimiento.solicitud_mtto_pendiente', ['solicitudes' => $solicitudes]);
    }

    public function ObtenerInformacionSolicitudMtto(Request $request)
    {
        $solicitud = ModelCerrarSolicitudMtto::ObtenerHistorialSolicitudMtto($request->id_solicitud);
        $campos = '';
        foreach ($solicitud as $key => $value) {
            $campos .= '<div class="row">
            <div class="col-md-2 mb-2">
                <div class="form-group">
                    <label for="">Id solicitud</label>
                    <textarea name="id_solicitud_mtto_res" id="id_solicitud_mtto_res" class="form-control" cols="30" rows="1" disabled>' . $value->id_solicitud . '</textarea>
                </div>
            </div>
            <div class="col-md-6 mb-2">
                <div class="form-group">
                    <label for="">Máquina</label>
                    <textarea name="" id="" class="form-control" cols="30" rows="1" disabled>' . $value->maquina . '</textarea>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="form-group">
                    <label for="">Sección</label>
                    <textarea name="" id="" class="form-control" cols="30" rows="1" disabled>' . $value->seccion . '</textarea>
                </div>
            </div>
            <div class="col-md-6 mb-2">
                <div class="form-group">
                    <label for="">Solicitud</label>
                    <textarea name="" id="" class="form-control" cols="30" rows="1" disabled>' . $value->solicitud . '</textarea>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="form-group">
                    <label for="">Responsable</label>
                    <textarea name="" id="" class="form-control" cols="30" rows="1" disabled>' . $value->responsable_s . '</textarea>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="form-group">
                    <label for="">Fecha</label>
                    <input type="date" class="form-control" value="' . $value->fecha_solicitud . '" name="" id="" disabled>
                </div>
            </div>
        </div>';
        }

        return response()->json(['status' => true, 'valores' => $campos], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function ActualizarSolicitudMttoSolucion(Request $request)
    {
        if (!empty($request->id_solicitud) && !empty($request->solucion) && !empty($request->responsable)) {
            $data = ([
                'respuesta_solicitud' => $request->solucion,
                'responsable_respuesta' => $request->responsable,
                'fecha_respuesta' => date('Y-m-d'),
                'estado_solicitud' => 'REVISION'
            ]);
            $response = ModelSolicitudesMtto::ActualizarSolucionSolicitudMtto($data, $request->id_solicitud);
            if ($response) {
                return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }
    }
}
