<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios\admin;

use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\servicios\infoAlmacenes;
use App\Models\apps\servicios_tecnicos\servicios\users\ModelUsuarios;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ControllerUsuarios extends Controller
{
    public function index()
    {
        $users = User::all();
        $almacenes = infoAlmacenes::orderBy('almacen')->get();
        $table = view('apps.servicios_tecnicos.servicios_tecnicos.admin.usuarios.table', ['info' => $users])->render();
        return view('apps.servicios_tecnicos.servicios_tecnicos.admin.usuarios.usuarios', ['usuarios' => $table, 'almacenes' => $almacenes]);
    }

    public function searchInfo(Request $request)
    {
        $id = $request->id;
        $info = ModelUsuarios::find($id);
        return response()->json(['status' => true, 'info' => $info], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function createUser(Request $request)
    {
        $dat = infoAlmacenes::where('numero', $request->create_alm)->get();
        $almacen = $dat->first();

        $pwd_ = $request->create_pwd;

        if (strlen($pwd_) < 50) {
            $pwd_ = Hash::make($request->create_pwd);
        }

        $response = User::create([
            'id' => $request->create_cedula,
            'nombre' => $request->create_name,
            'almacen' => $almacen->almacen,
            'empresa' => $request->create_empresa,
            'rol' => $request->create_rol,
            'usuario' => $request->create_user,
            'password' => $pwd_
        ]);
        if ($response) {
            $users = User::all();
            $table = view('apps.servicios_tecnicos.servicios_tecnicos.admin.usuarios.table', ['info' => $users])->render();
            return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
        return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function updateFoto(Request $request)
    {
        if ($request->hasFile('file_foto_user')) {
            $imagen = $request->file('file_foto_user');
            $nombre = uniqid() . "_" . $imagen->getClientOriginalName();

            $imagen->storeAs('public/perfil', $nombre);
            $url_doc = Storage::url("public/perfil/" . $nombre);

            $user = User::find(Auth::user()->id);
            $user->ruta_foto = $url_doc;
            $user->save();

            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        } else {
            return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
