<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelCentroOperaciones;
use App\Models\apps\intranet\ModelUsersIntranet;
use App\Models\apps\intranet\ModelUsuariosIntranet;
use App\Models\apps\intranet\orm\databases\ModelCotizador;
use App\Models\apps\intranet\orm\databases\ModelCotPruebas;
use App\Models\apps\intranet\orm\databases\ModelEcommerce;
use App\Models\apps\intranet\orm\databases\ModelIntranet;
use App\Models\apps\intranet\orm\databases\ModelMesaAyuda;
use App\Models\apps\servicios_tecnicos\servicios\infoAlmacenes;
use App\Models\soap\intranet\ModelConsultasWs;
use App\Models\soap\ModelSoap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ControllerUsuarios extends Controller
{
    public function index()
    {
        $data = array();
        $cedulas_ = array();

        $dptos = ModelUsuariosIntranet::ObtenerDepartamentos();
        $usuarios = ModelConsultasWs::informacion();

        if (count($usuarios) > 0) {
            foreach ($usuarios as $key => $value) {
                // $info_ = ModelUsersIntranet::where('id', 'LIKE' "$value['cedula']%");
                $info_ = ModelUsersIntranet::find($value['cedula']);

                if ($info_) {
                    array_push($cedulas_, $value['cedula']);

                    array_push($data, ([
                        'cedula' => $value['cedula'],
                        'nombre' => $value['nombre'],
                        'empresa' => ($value['empresa'] == 2) ? 'ALBURA SAS' : (($value['empresa'] == 5) ? 'INVERSIONES' : ''),
                        'sucursal' => $info_->sucursal,
                        'usuario' => $info_->usuario,
                        'estado' => ($info_->estado == '1') ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>'
                    ]));
                } else {
                    array_push($data, ([
                        'cedula' => $value['cedula'],
                        'nombre' => $value['nombre'],
                        'empresa' => ($value['empresa'] == 2) ? 'ALBURA SAS' : (($value['empresa'] == 5) ? 'INVERSIONES' : ''),
                        'sucursal' => '',
                        'usuario' => '',
                        'estado' => '<span class="badge badge-danger">Inactivo</span>'
                    ]));
                }
            }

            ModelUsersIntranet::whereNotIn('id', $cedulas_)->where("inhabilitar", "1")->update(['estado' => 0]);
            $info_db = ModelUsersIntranet::whereNotIn('id', $cedulas_)->get();
            foreach ($info_db as $key => $val) {
                array_push($data, ([
                    'cedula' => $val->id,
                    'nombre' => $val->nombre,
                    'empresa' => $val->empresa,
                    'sucursal' => $val->sucursal,
                    'usuario' => $val->usuario,
                    'estado' => ($val->estado == '1') ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>'
                ]));
            }
        }

        return view('apps.intranet.usuarios.home', ['dptos' => $dptos, 'usuarios' => $data]);
    }

    public function getInfoUsuarioIntranet(Request $request)
    {
        $id_usuario = $request->cedula;
        $info_user = ModelUsersIntranet::find($id_usuario);

        $existe_pruebas = false;
        if ($info_user) {
            $existe_intranet =  true;
            $existe_gcp =  true;
        }

        return response()->json(['status' => true, 'intranet' => $existe_intranet, 'real' => $existe_gcp, 'pruebas' => $existe_pruebas, 'data' => $info_user], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function createUserIntranet(Request $request)
    {
        $cedula = $request->cedula;
        $nombre = $request->nombre;
        $data = ModelUsersIntranet::find($cedula);
        $dptos = ModelUsuariosIntranet::ObtenerDepartamentos();
        $almacen = infoAlmacenes::all();
        return view(
            'apps.intranet.usuarios.crearInfo',
            ['cedula' => $cedula, 'nombre' => $nombre, 'data' => $data, 'dptos' => $dptos, 'almacen' => $almacen]
        );
    }

    public function updateInfoUsuarioIntranet(Request $request)
    {
        $permisos = $request->permisoGeneral;
        $cedula = $request->cedula;
        $nombre = $request->nombre;
        $email = $request->email;
        $depto = $request->dpto;
        $permiso_dpto = $request->permiso_dpto;
        $sucursal = $request->sucursal;
        $codVendedor = $request->codVendedor;
        $zona = $request->zona;
        $cargo = $request->cargo;
        $ingreso = $request->reloj;
        $calendario = $request->calendario;
        $usuario = $request->usuario;
        $pwd = $request->pwd;
        $bitacora = $request->bitacora;
        $empresa = $request->empresa;
        $almacen_st = $request->almacen_st;
        $rol_st = $request->rol_st;
        $fotografia = $request->file("fotografia");
        $rol_fab = $request->rol_fab;
        $permiso_madera = $request->control_madera;
        $inhabilitar = $request->inhabilitar;
        $estado = $request->estado;

        $info_user = ModelUsersIntranet::find($cedula);
        if ($info_user) {
            $info_user->codigo = $codVendedor;
            $info_user->nombre = $nombre;
            $info_user->email = $email;
            $info_user->permisos = $permisos;
            $info_user->dpto_user = $depto;
            $info_user->permiso_dpto = $permiso_dpto;
            $info_user->bitacora = $bitacora;
            $info_user->sucursal = $sucursal;
            $info_user->cargo = $cargo;
            $info_user->usuario = $usuario;
            if (!empty($pwd)) {
                $info_user->password = Hash::make($pwd);
            }
            $info_user->zona = $zona;
            $info_user->ingreso_personal = $ingreso;
            $info_user->calendario = $calendario;
            $info_user->estado = $estado;
            $info_user->almacen = $almacen_st;
            $info_user->empresa = $empresa;
            $info_user->rol = $rol_st;
            if ($fotografia != null) {
                $nombre_doc = $fotografia->getClientOriginalName();
                $nombre_ = uniqid() . "_" . $nombre_doc;
                $fotografia->storeAs('public/perfil/', $nombre_);
                $url_doc = Storage::url("perfil/" . $nombre_);
                $info_user->ruta_foto = $url_doc;
            }
            $info_user->rol_user = $rol_fab;
            $info_user->permiso_madera = $permiso_madera;
            $info_user->inhabilitar = $inhabilitar;
            $info_user->save();

            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        } else {
            return response()->json(['status' => false, 'mensaje' => '¡ERROR! No hay información para este usuario'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function createInfoGeneralUser(Request $request)
    {
        $permisos = $request->permisoGeneral;
        $cedula = $request->cedula;
        $nombre = $request->nombre;
        $email = $request->email;
        $depto = $request->dpto;
        $permiso_dpto = $request->permiso_dpto;
        $sucursal = $request->sucursal;
        $codVendedor = $request->codVendedor;
        $zona = $request->zona;
        $cargo = $request->cargo;
        $ingreso = $request->reloj;
        $calendario = $request->calendario;
        $usuario = $request->usuario;
        $pwd = $request->pwd;
        $bitacora = $request->bitacora;
        $empresa = $request->empresa;
        $almacen_st = $request->almacen_st;
        $rol_st = $request->rol_st;
        $fotografia = $request->file("fotografia");
        $rol_fab = $request->rol_fab;
        $inhabilitar = $request->inhabilitar;
        $estado = $request->estado;

        $info_user = ModelUsersIntranet::create([
            'id' => $cedula,
            'codigo' => $codVendedor,
            'nombre' => $nombre,
            'email' => $email,
            'permisos' => $permisos,
            'dpto_user' => $depto,
            'permiso_dpto' => $permiso_dpto,
            'bitacora' => $bitacora,
            'sucursal' => $sucursal,
            'cargo' => $cargo,
            'usuario' => $usuario,
            'password' => Hash::make($pwd),
            'zona' => $zona,
            'ingreso_personal' => $ingreso,
            'calendario' => $calendario,
            'estado' => $estado,
            'almacen' => $almacen_st,
            'empresa' => $empresa,
            'rol' => $rol_st,
            'rol_user' => $rol_fab,
            'inhabilitar' => $inhabilitar,
        ]);

        if ($info_user) {
            $info_ = ModelUsersIntranet::find($cedula);

            if ($fotografia != null) {
                $nombre_doc = $fotografia->getClientOriginalName();
                $nombre_ = uniqid() . "_" . $nombre_doc;
                $fotografia->storeAs('public/perfil/', $nombre_);
                $url_doc = Storage::url("perfil/" . $nombre_);
                $info_->ruta_foto = $url_doc;
                $info_->save();
            }

            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        } else {
            return response()->json(['status' => false, 'mensaje' => '¡ERROR! No hay información para este usuario'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function findUserName(Request $request)
    {
        $userName = $request->userName;
        $cantidad = ModelUsersIntranet::where('usuario', $userName)->count();
        if ($cantidad > 0) {
            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        } else {
            return response()->json(['status' => false], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function updateFoto(Request $request){
        $fotografia = $request->file("fotografia");
        $info_ = ModelUsersIntranet::find(Auth::user()->id);

        if ($fotografia != null) {
            $nombre_doc = $fotografia->getClientOriginalName();
            $nombre_ = uniqid() . "_" . $nombre_doc;
            $fotografia->storeAs('public/perfil/', $nombre_);
            $url_doc = Storage::url("perfil/" . $nombre_);
            $info_->ruta_foto = $url_doc;
            $info_->save();
        }

        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
