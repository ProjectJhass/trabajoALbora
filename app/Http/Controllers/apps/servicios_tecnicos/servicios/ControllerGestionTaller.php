<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios;

use App\Http\Controllers\apps\servicios_tecnicos\servicios\seguimiento\ControllerSeguimiento;
use App\Http\Controllers\apps\servicios_tecnicos\servicios\taller\PlanoOrdenProduccion;
use App\Http\Controllers\Controller;
use App\Mail\NotificacionIngresoTaller;
use App\Mail\NotificacionProdReparado;
use App\Mail\NotificacionSalidaTaller;
use App\Models\apps\servicios_tecnicos\servicios\emailsAlmacenes;
use App\Models\apps\servicios_tecnicos\servicios\ModelDatosIngresoTaller;
use App\Models\apps\servicios_tecnicos\servicios\ModelEvidenciasIngresoTaller;
use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use App\Models\soap\st_CrearOP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ControllerGestionTaller extends Controller
{
    protected function sendNotification($id_st)
    {
        $info = ModelNuevaSolicitud::find($id_st);
        $item = $info->articulo;
        $emails = emailsAlmacenes::where('almacen', 'FABRICA')->pluck('email')->toArray();
        //$emails = emailsAlmacenes::where('almacen', 'PRUEBAS')->pluck('email')->toArray();
        Mail::to($emails)->later(now()->addSeconds(5), new NotificacionProdReparado($item, $id_st));
    }

    protected function createInfoSiesa($st, $notas)
    {
        $datos = new PlanoOrdenProduccion();
        $linea2 = $datos->linea2($st, $notas);
        $linea3 = $datos->linea3($st);

        return st_CrearOP::ejecutarConsultaWs($linea2, $linea3);
    }

    public function getInfoReparacion()
    {
        $reparar = ModelNuevaSolicitud::where('proceso', 'Taller')->where('estado', 'En reparacion')->count();
        $data_info = ModelNuevaSolicitud::where('proceso', 'Taller')->where('estado', 'En reparacion')->get();
        $table = view('apps.servicios_tecnicos.servicios_tecnicos.taller.table', ['st' => $data_info])->render();
        return view('apps.servicios_tecnicos.servicios_tecnicos.taller.seguimiento', ['table' => $table, 'reparar' => $reparar]);
    }

    public function saveEvidenciasTaller($evidencias, $id_comment, $id_st, $tabla)
    {
        $extensions = (['png', 'jpg', 'jpeg', 'tiff', 'webp', 'mp4']);

        foreach ($evidencias as $file) {
            $tipo = $file->getClientOriginalExtension();

            if (in_array($tipo, $extensions)) {
                $name_ = str_replace("." . $tipo, "", $file->getClientOriginalName());
                $nombre = uniqid() . "_" . $file->getClientOriginalName();
                $tama = filesize($file);

                $response_file = $file->storeAs('public/evidencias', $nombre);
                $url_doc = Storage::url("public/evidencias/" . $nombre);

                if ($response_file) {
                    ModelEvidenciasIngresoTaller::create([
                        'nombre_img' => $name_,
                        'tipo' => $tipo,
                        'tama' => $tama,
                        'url' => $url_doc,
                        'tabla' => $tabla,
                        'id_comentario' => $id_comment,
                        'id_st' => $id_st
                    ]);
                }
            }
        }
    }

    public function actualizarIngresoTaller(Request $request)
    {
        $accion = $request->accion_taller;

        $explode = explode("-", $accion);
        $ot = $explode[0];
        $accion = $explode[1];

        $id_st = $request->id_st_taller;
        $fecha_ingreso = date('Y-m-d');
        $responsable = Auth::user()->nombre;
        $estado_articulo = $request->estado_articulo;

        $ost = ModelNuevaSolicitud::find($id_st);

        switch ($accion) {
            case 'ingreso':

                if (isset($request->send_terceros) && !empty($request->send_terceros) && $request->send_terceros == 'tercero') {

                    if (!empty($responsable) && !empty($estado_articulo)) {

                        $response = ModelDatosIngresoTaller::create([
                            'observaciones_ingreso' => $estado_articulo,
                            'responsable_ingreso' => $responsable,
                            'fecha_ingreso' => $fecha_ingreso,
                            'orden_taller' => 'Terceros',
                            'estado' => 'Reparado',
                            'id_st' => $id_st
                        ]);
                        $id_coment = $response->id_ingreso;
                        $tabla_ = 'taller_ingreso';
                        $proceso_ = 'Servicio tecnico';
                        $estado_ = 'En devolucion';

                        $seg_ = new ControllerSeguimiento();
                        $seg_->updateSeguimiento($id_st, 5);
                        $seg_->agregarSeguimiento($id_st, 6);
                        $seg_->updateSeguimiento($id_st, 6);
                        $seg_->agregarSeguimiento($id_st, 7);
                    }
                } else {

                    $articulo_ = $ost->articulo;

                    if (
                        strpos(strtolower($articulo_), "colchon") !== false ||
                        strpos(strtolower($articulo_), "protec") !== false ||
                        strpos(strtolower($articulo_), "almoha") !== false
                    ) {

                        if (!empty($responsable) && !empty($estado_articulo)) {
                            $id_taller = str_replace("-", " ", $request->id_orden_taller);

                            $response = ModelDatosIngresoTaller::create([
                                'observaciones_ingreso' => $estado_articulo,
                                'responsable_ingreso' => $responsable,
                                'fecha_ingreso' => $fecha_ingreso,
                                'orden_taller' => $id_taller,
                                'estado' => 'En reparacion',
                                'id_st' => $id_st
                            ]);
                            $id_coment = $response->id_ingreso;
                            $tabla_ = 'taller_ingreso';
                            $proceso_ = 'Taller';
                            $estado_ = 'En reparacion';
                        }
                    } else {
                        if (!empty($responsable) && !empty($estado_articulo)) {
                            $ws = self::createInfoSiesa($id_st, $estado_articulo);
                            if (is_bool($ws) === true && $ws === true) {

                                if (!empty($request->concepto_valoracion_hs)) {
                                    $ost->respuesta_st = $request->concepto_valoracion_hs;
                                    $ost->save();
                                }

                                $response = ModelDatosIngresoTaller::create([
                                    'observaciones_ingreso' => $estado_articulo,
                                    'responsable_ingreso' => $responsable,
                                    'fecha_ingreso' => $fecha_ingreso,
                                    'orden_taller' => "STE " . $id_st,
                                    'estado' => 'En reparacion',
                                    'id_st' => $id_st
                                ]);
                                $id_coment = $response->id_ingreso;
                                $tabla_ = 'taller_ingreso';
                                $proceso_ = 'Taller';
                                $estado_ = 'En reparacion';
                            } else {
                                return response()->json(['status' => false, 'error' => $ws[0]['f_detalle']], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                            }
                        } else {
                            return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                        }
                    }

                    $seg_ = new ControllerSeguimiento();
                    $seg_->updateSeguimiento($id_st, 5);
                    $seg_->agregarSeguimiento($id_st, 6);
                }

                break;
            case 'salida':
                if (!empty($responsable) && !empty($estado_articulo)) {

                    $info = ModelDatosIngresoTaller::where('orden_taller', $ot)->where('id_st', $id_st)->get();
                    $datos = $info->first();
                    $id_coment = $datos->id_ingreso;

                    $datos->observaciones_salida = $estado_articulo;
                    $datos->responsable_salida = $responsable;
                    $datos->fecha_salida = $fecha_ingreso;
                    $datos->estado = 'Reparado';
                    $response = $datos->save();

                    $tabla_ = 'taller_reparado';

                    if ($ost->respuesta_st == 'Cobrable' && $ost->almacen != "HAPPYSLEEP") {
                        $proceso_ = 'Servicio tecnico';
                        $estado_ = 'En devolucion';
                    } else {
                        $proceso_ = 'Fabrica';
                        $estado_ = 'Carta en elaboracion';

                        self::sendNotification($id_st);
                    }

                    $seg_ = new ControllerSeguimiento();
                    $seg_->updateSeguimiento($id_st, 6);
                    $seg_->agregarSeguimiento($id_st, 7);
                } else {
                    return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                }
                break;
        }

        if ($response) {
            if ($request->hasFile('evidencias_ingreso_taller')) {
                self::saveEvidenciasTaller($request->file('evidencias_ingreso_taller'), $id_coment, $id_st, $tabla_);
            }

            $ost->proceso = $proceso_;
            $ost->estado = $estado_;
            $ost->save();

            if ($estado_ == "En reparacion") {
                Mail::to($ost->email)->later(now()->addSeconds(10), new NotificacionIngresoTaller($ost->nombre, $ost->id_st, $ost->articulo));
            } else {
                Mail::to($ost->email)->later(now()->addSeconds(10), new NotificacionSalidaTaller($ost->nombre, $ost->id_st, $ost->articulo));
            }

            $seg_ost = new ControllerSeguimientoSt();
            $form = $seg_ost->timeLineOst($id_st);
            return response()->json(['status' => true, 'form' => $form], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
        return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
