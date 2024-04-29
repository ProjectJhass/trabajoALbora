<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios;

use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\pagina_web\ModelPaginaWeb;
use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use Illuminate\Http\Request;

class ControllerSearchSt extends Controller
{
    protected function cards($id)
    {
        $patron = '/[a-zA-Z]/';
        if (preg_match($patron, $id)) {
            $info_ = ModelPaginaWeb::where('n_ticket', $id)->where('estado', 'procesado')->get();
            $dat_ = $info_->first();
            $id_ = $dat_->num_ost;
            $data = ModelNuevaSolicitud::select(['id_st', 'articulo', 'nombre', 'created_at', 'almacen', 'estado'])->where('id_st', 'like', "%$id_%")->get();
        } else {
            $tama = strlen($id);
            if ($tama >= 7) {
                $data = ModelNuevaSolicitud::select(['id_st', 'articulo', 'nombre', 'created_at', 'almacen', 'estado'])->where('cedula', 'like', "%$id%")->get();
            } else {
                $data = ModelNuevaSolicitud::select(['id_st', 'articulo', 'nombre', 'created_at', 'almacen', 'estado'])->where('id_st', 'like', "%$id%")->get();
            }
        }



        return view('apps.servicios_tecnicos.servicios_tecnicos.creados.card-info', ['data' => $data])->render();
    }
    public function search(Request $request)
    {
        $cards = self::cards($request->codigo);
        return response()->json(['cards' => $cards], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
