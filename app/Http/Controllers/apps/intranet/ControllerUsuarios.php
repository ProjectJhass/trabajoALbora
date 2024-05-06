<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelUsersIntranet;
use App\Models\apps\intranet\ModelUsuariosIntranet;
use App\Models\apps\intranet\orm\databases\ModelCotizador;
use App\Models\apps\intranet\orm\databases\ModelCotPruebas;
use App\Models\apps\intranet\orm\databases\ModelEcommerce;
use App\Models\apps\intranet\orm\databases\ModelIntranet;
use App\Models\apps\intranet\orm\databases\ModelMesaAyuda;
use App\Models\soap\intranet\ModelConsultasWs;
use App\Models\soap\ModelSoap;
use Illuminate\Http\Request;

class ControllerUsuarios extends Controller
{
    public function index()
    {
        $data = array();
        $cedulas_ = array();

        $dptos = ModelUsuariosIntranet::ObtenerDepartamentos();
        $usuarios = ModelConsultasWs::informacion();

        if (count($usuarios) > 0) {
            array_push($usuarios, (['empresa' => 2, 'cedula' => '6401505', 'nombre' => 'SISTEMAS MUEBLES ALBURA SAS']));
            foreach ($usuarios as $key => $value) {
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

            //ModelUsersIntranet::whereNotIn('id', $cedulas_)->update(['estado' => 0]);
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
        return view('apps.intranet.usuarios.crearInfo', ['cedula' => $cedula, 'nombre' => $nombre, 'data' => $data, 'dptos' => $dptos]);
    }
}
