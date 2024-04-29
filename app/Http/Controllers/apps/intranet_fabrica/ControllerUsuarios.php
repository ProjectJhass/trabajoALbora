<?php

namespace App\Http\Controllers\apps\intranet_fabrica;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet_fabrica\DocumentacionTecnica;
use App\Models\apps\intranet_fabrica\ModelUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ControllerUsuarios extends Controller
{
    public function index()
    {
        $usuarios = ModelUsuarios::ObtenerTodosLosUsuarios();
        return view('apps.intranet_fabrica.fabrica.usuarios.usuarios', ['usuarios' => $usuarios]);
    }

    public function RegistrarNuevoUsuario()
    {
        return view('apps.intranet_fabrica.fabrica.usuarios.registrar');
    }

    public function AgregarReferenciaDocumentacion()
    {
        return view('apps.intranet_fabrica.fabrica.usuarios.referencias.referencias');
    }

    public function CrearReferenciaFabrica(Request $request)
    {
        if (!empty($request->nombre_nueva_referencia)) {
            $data = (['nombre_referencia' => $request->nombre_nueva_referencia]);
            $response = DocumentacionTecnica::AgregarNuevaReferenciaFab($data);
            if ($response) {
                return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }
    }

    public function AgregarNuevoUsuarioDB(Request $request)
    {
        $validar = Validator::make([
            'nombre' => $request->name,
            'email' => $request->email,
            'usuario' => $request->usuario,
            'password' => $request->password,
            'tipo_de_usuario_fab' => $request->tipo_de_usuario_fab
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',],
            'usuario' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'tipo_de_usuario_fab' => ['required'],
        ]);
        if ($validar) {
            $data = ([
                'nombre' => $request->name,
                'email' => $request->email,
                'usuario' => $request->usuario,
                'password' => Hash::make($request->password),
                'rol_user' => $request->tipo_de_usuario_fab
            ]);
            $resp = ModelUsuarios::GuardarInformacionNuevoUsuario($data);
            if ($resp) {
                return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }
    }

    public function EliminarUsuarioRegistrado(Request $request)
    {
        $response = ModelUsuarios::EliminarUsuarioRegistradoFab($request->id_usuario);
        if ($response) {
            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
