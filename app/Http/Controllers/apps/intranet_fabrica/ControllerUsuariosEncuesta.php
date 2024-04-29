<?php

namespace App\Http\Controllers\apps\intranet_fabrica;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet_fabrica\ModelUsuariosEncuesta;
use Illuminate\Http\Request;

class ControllerUsuariosEncuesta extends Controller
{
    public function index()
    {
        $usuarios = ModelUsuariosEncuesta::ObtenerTodosLosUsuariosEncuesta();
        return view('apps.intranet_fabrica.fabrica.usuarios.encuesta.usuarios_registrados', ['usuarios' => $usuarios]);
    }

    public function FormRegistro()
    {
        return view('apps.intranet_fabrica.fabrica.usuarios.encuesta.crear_nuevo');
    }

    public function InformacionRegistroUser(Request $request)
    {
        $data = (['cedula_usuario' => $request->cedula_nuevo_registro, 'nombre_usuario' => $request->nombre_nuevo_registro]);
        $response = ModelUsuariosEncuesta::AgregarNuevoRegistroEncuesta($data);
        if ($response) {
            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function EliminarInformacionUsuario(Request $request)
    {
        $response = ModelUsuariosEncuesta::EliminarRegistroUserEncuesta($request->id_usuario);
        if ($response) {
            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
