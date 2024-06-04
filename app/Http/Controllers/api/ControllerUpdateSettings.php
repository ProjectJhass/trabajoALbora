<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\ModelConsecutivosMadera;
use App\Models\apps\control_madera\ModelInspeccionMateriaPrima;
use Illuminate\Http\Request;

class ControllerUpdateSettings extends Controller
{
    public function saveInfoMedidasMadera(Request $request)
    {
        $id = $request->id_madera;
        $ancho = $request->ancho;
        $grueso =  $request->grueso;
        $largo = ($request->largo / 100);

        if (empty($id) || empty($ancho) || empty($grueso) || empty($largo)) {
            return response()->json(['status' => 'error', 'message' => "Completa todos los campos"], 401);
        }

        $info = ModelConsecutivosMadera::find($id);
        if (!$info) return response()->json(['status' => 'error', 'message' => "No se encontró información de la madera"], 401);

        $pulgadas = (($ancho * $grueso) * ($largo / 3));

        $info->ancho =  $ancho;
        $info->grueso =  $grueso;
        $info->largo  =  $largo;
        $info->pulgadas = round($pulgadas);
        $info->estado = "Activo";
        $info->save();

        $id_madera_ = $info->id_info_madera;
        $tipo_m = $info->tipo_madera;

        $metros_ = $tipo_m == "V" ? 3 : 2;

        $cantidad_m = ModelConsecutivosMadera::where("id_info_madera", $id_madera_)->count();
        $cantidad_listos = ModelConsecutivosMadera::where("pulgadas", "<>", "")->count();
        if ($cantidad_m == $cantidad_listos) {
            $suma_pulgadas = ModelConsecutivosMadera::where("id_info_madera", $id_madera_)->sum("pulgadas");

            $cant_bajo = ModelConsecutivosMadera::where("largo", "<", $metros_)->where("id_info_madera", $id_madera_)->count();
            $procentaje =  round((($cant_bajo * 100) / $cantidad_m), 1);

            $data_inspeccion = ModelInspeccionMateriaPrima::find($id_madera_);
            $data_inspeccion->total_pulgadas = $suma_pulgadas;
            $data_inspeccion->menor_tres_m = $procentaje;
            $data_inspeccion->save();
        }

        return response()->json([
            'status' => true,
            'message' => "Se ha guardado la información de las medidas"
        ], 200);
    }
}
