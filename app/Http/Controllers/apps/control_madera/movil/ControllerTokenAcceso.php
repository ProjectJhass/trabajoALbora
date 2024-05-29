<?php

namespace App\Http\Controllers\apps\control_madera\movil;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\api\auth\ModelClaveApi;
use App\Models\apps\control_madera\api\ModelInfoUrl;
use Illuminate\Http\Request;

class ControllerTokenAcceso extends Controller
{
    public function index()
    {
        $url = ModelInfoUrl::find(1);
        $info_ = ModelClaveApi::all();
        $table = view('apps.control_madera.movil.table', ['moviles' => $info_])->render();
        return view('apps.control_madera.movil.index', ['url' => $url, 'table' => $table]);
    }

    public function urlConnection(Request $request)
    {
        $url = $request->urlConnection;
        $url_ = ModelInfoUrl::find(1);
        if ($url_) {
            $url_->url = $url;
            $url_->save();
        } else {
            ModelInfoUrl::create([
                'url' => $url
            ]);
        }

        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function RegistrarDispositivo(Request $request)
    {
        $token = $request->token;
        $movil = $request->nombre_movil;
        ModelClaveApi::create([
            'clave' => $token,
            'celular' => $movil
        ]);

        $info_ = ModelClaveApi::all();
        $table = view('apps.control_madera.movil.table', ['moviles' => $info_])->render();

        return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function EditarDispositivo(Request $request)
    {
        $id_movil = $request->id_movil;
        $token = $request->token;
        $movil = $request->nombre_movil;
        $data_ = ModelClaveApi::find($id_movil);
        $data_->clave = $token;
        $data_->celular = $movil;
        $data_->save();

        $info_ = ModelClaveApi::all();
        $table = view('apps.control_madera.movil.table', ['moviles' => $info_])->render();

        return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function EliminarDipositivo(Request $request)
    {
        $id_movil = $request->id_movil;
        $data_ = ModelClaveApi::find($id_movil);
        $data_->delete();

        $info_ = ModelClaveApi::all();
        $table = view('apps.control_madera.movil.table', ['moviles' => $info_])->render();

        return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
