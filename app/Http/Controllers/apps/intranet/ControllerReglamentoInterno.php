<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelFotografiasIntranet;
use App\Models\soap\ModelSoap;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ControllerReglamentoInterno extends Controller
{
    
    public function index(Request $request)
    {
        $cedula = $request->cedula_empleado;
        $data_usuario = ModelSoap::ObtenerInformacionUsuario($cedula);
        if (count($data_usuario) > 0) {
            return response()->json(['status' => true, 'data' => $data_usuario], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
        return response()->json(['status' => false], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function guardarFoto(Request $request)
    {
        $nom_empresa = ($request->empresa == 2) ? 'ALBURA_SAS' : (($request->empresa == 5) ? 'INVERSIONES' : '');
        $empleado = $request->nombre;
        $cedula = $request->cedula;

        $iframe = '<iframe src="' . asset('storage/RRHH/reglamentos/' . $nom_empresa . '/REGLAMENTO INTERNO DE TRABAJO.pdf') . '#toolbar=0" width="100%" height="680px" frameborder="0"></iframe>';

        $imagen = $request->getContent();
        $datos_imagen = str_replace("data:image/png;base64,", "", urldecode($imagen));
        $datos_deco_imagen = base64_decode($datos_imagen);

        $nombre_imagen = uniqid() . "_" . $empleado . ".png";

        $response = Storage::put('public/RRHH/fotos_reglamento/' . $nombre_imagen, $datos_deco_imagen);
        if ($response) {
            $data = ([
                'cedula' => $cedula,
                'nombre' => $empleado,
                'update_foto' => $nombre_imagen,
                'empresa' => $nom_empresa,
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            ModelFotografiasIntranet::AgregarFotosReglamento($data);

            return response()->json(['status' => true, 'iframe' => $iframe], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
        return response()->json(['status' => false], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
