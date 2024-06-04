<?php

namespace App\Http\Controllers\api\control_madera;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\api\ModelAuthUser;
use Illuminate\Http\Request;

class ControllerAuthUser extends Controller
{
    public function authUser(Request $request)
    {
        $usuario = $request->usuario;
        $clave = $request->clave;

        if (!empty($usuario) && !empty($clave)) {
            $dataInfo = ModelAuthUser::where('usuario', $usuario)->where('estado', '1')->get();
            if ($dataInfo->count() > 0) {
                $data_ = $dataInfo->first();
                if ((strcmp($usuario, $data_->usuario) === 0)  && password_verify($clave, $data_->password)) {
                    return response()->json(['status' => true], 200);
                }
                return response()->json('', 401);
            }
            return response()->json('', 401);
        }
        return response()->json('', 401);
    }
}
