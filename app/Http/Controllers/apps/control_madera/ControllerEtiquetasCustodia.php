<?php

namespace App\Http\Controllers\apps\control_madera;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\ModelConsecutivosMadera;
use App\Models\apps\control_madera\ModelEtiquetasEnCustodia;
use App\Models\apps\control_madera\ModelInfoMadera;
use App\Models\apps\control_madera\ModelInspeccionMateriaPrima;
use App\Models\apps\control_madera\ModelLogs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerEtiquetasCustodia extends Controller
{
    public function index()
    {
        $usuarios = User::where("estado", "1")->get();
        $data = ModelEtiquetasEnCustodia::where("estado", "Sin procesar")->get();
        $table = view("apps.control_madera.app.printer.custodia.table.info", ['data' => $data])->render();
        return view("apps.control_madera.app.printer.custodia.etiquetas", ['table' => $table, 'usuarios' => $usuarios]);
    }

    public function agregarConsecutivos(Request $request)
    {
        $inicial = $request->consecutivo_inicio;
        $final = $request->consecutivo_final;
        $usuario = $request->usuario_responsable;
        $id_impresion = 0;
        $t_madera = '';

        if (!empty($inicial) && !empty($final) && !empty($usuario)) {

            $id_consec = [];

            for ($i = $inicial; $i <= $final; $i++) {
                $info_ = ModelConsecutivosMadera::find($i);
                $id_consecutivo = $info_->id;
                $id_impresion = $info_->id_info_madera;
                $t_madera = $info_->tipo_madera;
                $estado_ = $info_->estado;

                if ($estado_ == "Pendiente") {

                    if (!in_array($id_impresion, $id_consec)) {
                        array_push($id_consec, $id_impresion);
                    }

                    ModelEtiquetasEnCustodia::create([
                        'id_consecutivo' => $id_consecutivo,
                        'id_impresion' => $id_impresion,
                        'usuario_registro' => Auth::user()->nombre,
                        'usuario_a_cargo' => $usuario,
                        'estado' => 'Sin procesar'
                    ]);

                    $info_->id_info_madera = null;
                    $info_->tipo_madera = null;
                    $info_->estado = "Custodia";
                    $info_->save();

                    ModelLogs::create([
                        'accion' => 'El usuario ' . Auth::user()->nombre . ' Agregó el consecutivo #' . $id_consecutivo . ' a etiquetas en custodia el usuario a cargo de las etiquetas es: ' . $usuario,
                        'usuario' => Auth::user()->nombre
                    ]);
                }
            }

            foreach ($id_consec as $key => $value) {
                $cantidad_bloques = ModelConsecutivosMadera::where("id_info_madera", $value)->count();
                if ($cantidad_bloques == 0 || empty($cantidad_bloques)) {
                    $info_printer = ModelInspeccionMateriaPrima::find($value);
                    $info_printer->delete();
                } else {
                    $pulgadas_t = ModelConsecutivosMadera::where("id_info_madera", $value)->sum("pulgadas");
                    if ($t_madera == 'V') {
                        $cant_ = ModelConsecutivosMadera::where("id_info_madera", $value)->where("largo", "<", "3")->count();
                        $porcentaje_ = round((($cant_ * 100) / $cantidad_bloques));
                    } else {
                        $cant_ = ModelConsecutivosMadera::where("id_info_madera", $value)->where("largo", "<", "2")->count();
                        $porcentaje_ = round((($cant_ * 100) / $cantidad_bloques));
                    }

                    $info_printer = ModelInspeccionMateriaPrima::find($value);
                    $info_printer->total_bloques = $cantidad_bloques;
                    $info_printer->total_pulgadas = $pulgadas_t;
                    $info_printer->menor_tres_m = $porcentaje_;
                    $info_printer->save();
                }
            }

            $data = ModelEtiquetasEnCustodia::where("estado", "Sin procesar")->get();
            $table = view("apps.control_madera.app.printer.custodia.table.info", ['data' => $data])->render();

            return response()->json(['status' => true, 'mensaje' => '¡EXCELENTE! Consecutivos custodiados correctamente', 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function utilizarConsecutivosCustodia(Request $request)
    {
        $id_madera = $request->txt_tipo_madera;
        $subproceso = $request->subproceso;
        $tipo_vehiculo = $request->tipo_vehiculo;

        if (!empty($id_madera) && !empty($subproceso) && !empty($tipo_vehiculo)) {

            $madera_ = ModelInfoMadera::find($id_madera);
            $nombre_madera = $madera_->nombre_madera;
            $incial_madera = substr($nombre_madera, 0, 1);

            $cantidad_bloques = ModelEtiquetasEnCustodia::where("estado", "Sin procesar")->count();

            $response = ModelInspeccionMateriaPrima::create([
                'id_madera' => $id_madera,
                'madera' => $nombre_madera,
                'tipo_vehiculo' => $tipo_vehiculo,
                'subproceso' => $subproceso,
                'total_bloques' => $cantidad_bloques,
                'usuario_creacion' => Auth::user()->nombre
            ]);
            if ($response) {
                $id_insert = $response->id;

                $info_ = ModelEtiquetasEnCustodia::where("estado", "Sin procesar")->get();
                foreach ($info_ as $key => $value) {
                    $id_consecutivo = $value->id_consecutivo;
                    $info_consec = ModelConsecutivosMadera::find($id_consecutivo);
                    $info_consec->id_info_madera = $id_insert;
                    $info_consec->tipo_madera = $incial_madera;
                    $info_consec->usuario_creacion = Auth::user()->nombre;
                    $info_consec->estado = "Pendiente";
                    $info_consec->save();
                    ModelEtiquetasEnCustodia::where("estado", "Sin procesar")->where("id", $value->id)->update(['id_nueva_imp' => $id_insert, 'estado' => 'Procesado']);

                    ModelLogs::create([
                        'accion' => 'El usuario ' . Auth::user()->nombre . ' utilizó el consecutivo #' . $id_consecutivo . ' de las etiquetas en custodia el nuevo id de impresion es: ' . $id_insert,
                        'usuario' => Auth::user()->nombre
                    ]);
                }

                $print_qr = new ControllerPrinterQr();
                $table = $print_qr->getInfoImpresiones();

                return response()->json(['status' => true, 'mensaje' => '¡EXCELENTE! Consecutivos utilizados correctamente', 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }
    }
}
