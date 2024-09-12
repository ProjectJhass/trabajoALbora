<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios\plantilla;

use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\servicios\infoAlmacenes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerAlmacenes extends Controller
{
    public function ObtenerInfoAlmacenes()
    {
        $user = Auth::user();
        $data = '<option value="">Seleccionar...</option>';
        $info = infoAlmacenes::where('estado', '1')->orderBy('almacen')->get();

        if($user->id == "30314322") {
            foreach ($info as $key => $value) {
                if($value->numero == $user->sucursal) {
                    $data .= '<option value="' . $value->numero . '">' . $value->almacen . '</option>';
                }
            }
        } else {
            foreach ($info as $key => $value) {
                $data .= '<option value="' . $value->numero . '">' . $value->almacen . '</option>';
            }
        }

        return response()->json(['options' => $data, "user" => $user], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
