<?php

namespace App\Http\Controllers\apps\control_madera;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\ModelInfoMadera;
use App\Models\apps\control_madera\ModelInfoMueble;
use App\Models\apps\control_madera\ModelInfoPiezasMueble;
use App\Models\apps\control_madera\ModelInfoSerie;
use App\Models\apps\control_madera\ModelLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerCrearNuevasSeries extends Controller
{
    public function getView()
    {
        $series = ModelInfoSerie::all();
        return view('apps.control_madera.app.planner.crear_series.home', ['series' => $series]);
    }

    public function getInfoPiezasMadera(Request $request)
    {
        $id_serie = $request->serie_planner;
        $id_madera = $request->madera_planner;
        $id_mueble = $request->mueble_planner;

        if (!empty($id_serie) && !empty($id_madera) && !empty($id_mueble)) {
            $data_piezas = ModelInfoPiezasMueble::where('id_mueble', $id_mueble)
                ->where('id_serie', $id_serie)
                ->where('id_madera', $id_madera)
                ->get();

            $form_ = view("apps.control_madera.app.planner.crear_series.formPiezas", ['data' => $data_piezas])->render();
            return response()->json(['status' => true, 'planilla' => $form_], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
        return response()->json(['status' => false, 'mensaje' => '¡ERROR! Debe seleccionar información coherente a buscar'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function updateInfoPiezasSelected(Request $request)
    {
        $ciclos = $request->cantidadV;
        for ($i = 1; $i <= $ciclos; $i++) {
            $id_pieza = $request['idPieza' . $i];
            $nombre_ = $request['nombre' . $i];

            $cantidad_ = str_replace(",", ".", $request['cantidad' . $i]);
            $largo_ = str_replace(",", ".", $request['largo' . $i]);
            $ancho_ = str_replace(",", ".", $request['ancho' . $i]);
            $grueso_ = str_replace(",", ".", $request['grueso' . $i]);

            $estado_ = $request['estado' . $i];
            $data_i = ModelInfoPiezasMueble::find($id_pieza);
            if ($estado_ == 3) {
                $data_i->delete();

                ModelLogs::create([
                    'accion' => 'El usuario ' . Auth::user()->nombre . ' eliminó la pieza # ' . $id_pieza . ' Nombre: ' . $nombre_
                ]);
            } else {
                $data_i->pieza = $nombre_;
                $data_i->cantidad_pieza = $cantidad_;
                $data_i->largo = $largo_;
                $data_i->ancho = $ancho_;
                $data_i->grueso = $grueso_;
                $data_i->estado = $estado_;
                $data_i->save();

                ModelLogs::create([
                    'accion' => 'El usuario ' . Auth::user()->nombre . ' actualizó la pieza # ' . $id_pieza . ' Nombre: ' . $nombre_
                ]);
            }
        }

        return response()->json(['status' => true, 'mensaje' => 'Se actualizó la información correctamente'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function agregarInfoNuevaPieza(Request $request)
    {
        $id_serie = $request->serie_planner;
        $id_madera = $request->madera_planner;
        $id_mueble = $request->mueble_planner;

        $nombre = $request['nombreN1'];
        $cantidad = str_replace(",", ".", $request['cantidadN1']);
        $largo = str_replace(",", ".", $request['largoN1']);
        $ancho = str_replace(",", ".", $request['anchoN1']);
        $grueso = str_replace(",", ".", $request['gruesoN1']);

        if (!empty($nombre) && !empty($cantidad) && !empty($largo) && !empty($ancho) && !empty($grueso)) {
            ModelInfoPiezasMueble::create([
                'id_mueble' => $id_mueble,
                'id_serie' => $id_serie,
                'id_madera' => $id_madera,
                'pieza' => $nombre,
                'cantidad_pieza' => $cantidad,
                'largo' => $largo,
                'ancho' => $ancho,
                'grueso' => $grueso,
                'estado' => 1
            ]);

            ModelLogs::create([
                'accion' => 'El usuario ' . Auth::user()->nombre . ' agregó una nueva pieza Nombre: ' . $nombre . ' al mueble: ' . $id_mueble . ' serie: ' . $id_serie . ' madera: ' . $id_madera
            ]);

            return response()->json(['status' => true, 'mensaje' => '¡Excelente! Pieza creada exitosamente'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        } else {
            return response()->json(['status' => false, 'mensaje' => 'Debe completar toda la información antes de crear la nueva pieza'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function crearNuevaSerie()
    {
        $madera = ModelInfoMadera::where("estado", "1")->get();
        return view('apps.control_madera.app.planner.crear_series.crearSerie', ['madera' => $madera]);
    }

    public function crearInfoNuevaSerie(Request $request)
    {
        $serie = trim($request->serie);
        $madera = trim($request->madera);
        $mueble = str_replace(".", ",", trim($request->mueble));
        $ciclos = $request->ciclos;

        if (!empty($serie) && !empty($madera) && !empty($mueble)) {
            for ($i = 1; $i <= count($ciclos); $i++) {
                $nombre = $request['nombre' . $i];
                $cantidad = $request['cantidad' . $i];
                $largo = $request['largo' . $i];
                $ancho = $request['ancho' . $i];
                $grueso = $request['grueso' . $i];
                $estado = $request['estado' . $i];
                if (empty($nombre) || empty($cantidad) || empty($largo) || empty($ancho) || empty($grueso) || empty($estado)) {
                    return response()->json(['status' => false, 'mensaje' => 'Debe completar toda la información antes de crear la nueva serie'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                }
            }

            //Consultar si la serie existe, si es así traer el id
            $serie_ = ModelInfoSerie::where("serie", $serie)->first();
            if (!empty($serie_)) {
                $data_serie = $serie_;
            } else {
                $data_serie = ModelInfoSerie::create([
                    'serie' => $serie,
                    'estado' => 1
                ]);

                ModelLogs::create([
                    'accion' => 'El usuario ' . Auth::user()->nombre . ' creó la serie: ' . $serie
                ]);
            }

            if ($data_serie) {
                $id_serie = $data_serie->id_serie;

                //Consultar si el mueble existe si es así traer el id
                $mueble_ = ModelInfoMueble::where("mueble", $mueble)->where("id_serie", $id_serie)->where("id_madera", $madera)->first();
                if (!empty($mueble_)) {
                    return response()->json(['status' => false, 'mensaje' => '¡ERROR! El mueble ya existe, no puede crear uno igual'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                } else {
                    $data_mueble = ModelInfoMueble::create([
                        'mueble' => $mueble,
                        'id_serie' => $id_serie,
                        'id_madera' => $madera,
                        'estado' => 1
                    ]);

                    ModelLogs::create([
                        'accion' => 'El usuario ' . Auth::user()->nombre . ' creó el mueble: ' . $mueble
                    ]);
                }

                if ($data_mueble) {
                    $id_mueble = $data_mueble->id_mueble;
                    try {
                        for ($i = 1; $i <= count($ciclos); $i++) {
                            $nombre = $request['nombre' . $i];
                            $cantidad = str_replace(",", ".", $request['cantidad' . $i]);
                            $largo = str_replace(",", ".", $request['largo' . $i]);
                            $ancho = str_replace(",", ".", $request['ancho' . $i]);
                            $grueso = str_replace(",", ".", $request['grueso' . $i]);
                            $estado = $request['estado' . $i];

                            $info_p_ = ModelInfoPiezasMueble::create([
                                'id_mueble' => $id_mueble,
                                'id_serie' => $id_serie,
                                'id_madera' => $madera,
                                'pieza' => $nombre,
                                'cantidad_pieza' => $cantidad,
                                'largo' => $largo,
                                'ancho' => $ancho,
                                'grueso' => $grueso,
                                'estado' => $estado
                            ]);

                            ModelLogs::create([
                                'accion' => 'El usuario ' . Auth::user()->nombre . ' creó la pieza #' . $info_p_->id . ' pieza: ' . $nombre
                            ]);
                        }

                        return response()->json(['status' => true, 'mensaje' => '¡Excelente! Se creó la nueva serie exitosamente'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                    } catch (\Throwable $th) {
                        ModelInfoPiezasMueble::where('id_mueble', $id_mueble)
                            ->where('id_serie', $id_serie)
                            ->where('id_madera', $madera)
                            ->delete();
                        $info_m = ModelInfoMueble::find($id_mueble);
                        $info_m->delete();

                        $info_ = ModelInfoSerie::find($id_serie);
                        $info_->delete();

                        return response()->json(['status' => false, 'mensaje' => '¡ERROR! Problemas de conexión intenta nuevamente'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                    }
                } else {
                    $info_ = ModelInfoSerie::find($data_serie->id_serie);
                    $info_->delete();
                }
            }
        } else {
            return response()->json(['status' => false, 'mensaje' => 'Debe completar toda la información antes de crear la nueva serie'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function deleteSerie()
    {
        $id_serie = request('id_serie');
        $data_serie = ModelInfoSerie::find($id_serie);
        $data_serie->delete();
        ModelLogs::create([
            'accion' => 'El usuario ' . Auth::user()->nombre . ' eliminó la serie #' . $id_serie . ' ' . $data_serie->serie
        ]);
        return response()->json(['status' => true, 'mensaje' => '¡Excelente! Serie eliminada'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function deleteMueble()
    {
        $id_mueble = request('id_mueble');
        $data_mueble = ModelInfoMueble::find($id_mueble);
        $data_mueble->delete();
        ModelLogs::create([
            'accion' => 'El usuario ' . Auth::user()->nombre . ' eliminó el mueble #' . $id_mueble . ' ' . $data_mueble->mueble
        ]);
        return response()->json(['status' => true, 'mensaje' => '¡Excelente! Mueble eliminado correctamente'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
