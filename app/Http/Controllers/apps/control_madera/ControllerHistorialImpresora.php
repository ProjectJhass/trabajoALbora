<?php

namespace App\Http\Controllers\apps\control_madera;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\ModelConsecutivosMadera;
use App\Models\apps\control_madera\ModelInspeccionMateriaPrima;
use App\Models\apps\control_madera\ModelLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerHistorialImpresora extends Controller
{
    public function index()
    {
        $hoy = date("Y-m-d");
        $historial = self::infoHistory($hoy, $hoy);
        return view('apps.control_madera.app.printer.history.search_info', ['history' => $historial]);
    }

    public function renderPrinter(Request $request)
    {
        $id = $request->id;
        $query_ = ModelInspeccionMateriaPrima::find($id);
        $madera = ModelConsecutivosMadera::where("id_info_madera", $id)->orderBy("id")->get();
        return view('apps.control_madera.app.printer.history.formato', ['control' => $query_, 'madera' => $madera]);
    }

    public function infoHistory($fecha_i, $fecha_f)
    {
        $fecha_f = date("Y-m-d", strtotime($fecha_f . "+1 day"));
        $data_ = ModelInspeccionMateriaPrima::whereBetween("created_at", [$fecha_i, $fecha_f])->orderByDesc("created_at")->get();
        return view('apps.control_madera.app.printer.history.history', ['data' => $data_])->render();
    }

    public function searchInfoHistory(Request $request)
    {
        $fecha_i = $request->fecha_i;
        $fecha_f =  $request->fecha_f;
        $historial = self::infoHistory($fecha_i, $fecha_f);
        return response()->json(['status' => true, 'history' => $historial], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function editInfoHistory(Request $request)
    {
        $id = $request->id;
        $query_ = ModelInspeccionMateriaPrima::find($id);
        $madera = ModelConsecutivosMadera::where("id_info_madera", $id)->where("estado", "<>", "Pendiente")->orderBy("id")->get();
        $view = view('apps.control_madera.app.printer.history.editInformation', ['control' => $query_, 'madera' => $madera])->render();
        return response()->json(['status' => true, 'view' => $view], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function editHistoryPrinted(Request $request)
    {
        $id_ = $request->id;
        $accion_ = $request->accion;
        $subproceso_ = $request->subproceso;
        $placa_ =  $request->placa;
        $conducto_ =  $request->conducto;
        $ancho_ =  $request->ancho;
        $grueso_ =  $request->grueso;
        $largo_ =  $request->largo;

        switch ($accion_) {
            case '1':
                $data_ = ModelInspeccionMateriaPrima::find($id_);
                $data_->placa  = $placa_;
                $data_->conducto  = $conducto_;
                $data_->subproceso   = $subproceso_;
                $data_->save();

                ModelLogs::create([
                    'accion' => 'El usuario ' . Auth::user()->nombre . ' actualizó la info de impresiones placa: ' . $placa_ . ' salvo conducto: ' . $conducto_ . ' subproceso: ' . $subproceso_,
                    'usuario' => Auth::user()->nombre
                ]);

                break;
            case '2':
                $pulgadas_ = round((($ancho_ * $grueso_) * ($largo_ / 3)));
                $data_madera = ModelConsecutivosMadera::find($id_);

                $id_madera_ = $data_madera->id_info_madera;
                $tipo_m = $data_madera->tipo_madera;

                $data_madera->ancho = $ancho_;
                $data_madera->grueso = $grueso_;
                $data_madera->largo = $largo_;
                $data_madera->pulgadas = $pulgadas_;
                $data_madera->save();

                ModelLogs::create([
                    'accion' => 'El usuario ' . Auth::user()->nombre . ' modificó las medidas del bloque #' . $id_ . ' ancho: ' . $ancho_ . 'grueso: ' . $grueso_ . ' largo: ' . $largo_,
                    'usuario' => Auth::user()->nombre
                ]);

                $metros_ = $tipo_m == "V" ? 3 : 2;

                $cantidad_m = ModelConsecutivosMadera::where("id_info_madera", $id_madera_)->count();
                $suma_pulgadas = ModelConsecutivosMadera::where("id_info_madera", $id_madera_)->sum("pulgadas");
                $cant_bajo = ModelConsecutivosMadera::where("largo", "<", $metros_)->where("id_info_madera", $id_madera_)->count();
                $procentaje =  round((($cant_bajo * 100) / $cantidad_m), 1);

                $data_inspec = ModelInspeccionMateriaPrima::find($id_madera_);

                $data_inspec->total_pulgadas = $suma_pulgadas;
                $data_inspec->menor_tres_m = $procentaje;
                $data_inspec->save();

                break;
        }
    }
}
