<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelUsuariosIntranet;
use App\Models\apps\intranet\orm\databases\ModelCotizador;
use App\Models\apps\intranet\orm\databases\ModelCotPruebas;
use App\Models\apps\intranet\orm\databases\ModelEcommerce;
use App\Models\apps\intranet\orm\databases\ModelIntranet;
use App\Models\apps\intranet\orm\databases\ModelMesaAyuda;
use App\Models\soap\ModelSoap;
use Illuminate\Http\Request;

class ControllerUsuarios extends Controller
{
    public function index()
    {
        $data = array();
        $cedulas_ = array();

        $dptos = ModelUsuariosIntranet::ObtenerDepartamentos();
        $usuarios = ModelSoap::ObtenerTodosUsuarios();
        array_push($usuarios, (['empresa' => 2, 'cedula' => 6401505, 'nombre' => 'SISTEMAS MUEBLES ALBURA SAS']));
        foreach ($usuarios as $key => $value) {
            $info = ModelUsuariosIntranet::ObtenerInfoUsuario($value['cedula']);
            foreach ($info as $key => $val) {
                if (!empty($val['usuario'])) {
                    array_push($cedulas_, $value['cedula']);
                }
                array_push($data, ([
                    'cedula' => $value['cedula'],
                    'nombre' => $value['nombre'],
                    'empresa' => ($value['empresa'] == 2) ? 'ALBURA SAS' : (($value['empresa'] == 5) ? 'INVERSIONES' : ''),
                    'sucursal' => $val['sucursal'],
                    'usuario' => $val['usuario'],
                    'estado' => ($val['estado'] == '1') ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>'
                ]));
            }
        }

       /* ModelIntranet::whereNotIn('id', $cedulas_)->update(['estado' => 0]);
        ModelCotizador::whereNotIn('id', $cedulas_)->update(['cargo' => 'guest', 'estado' => 0]);
        ModelCotPruebas::whereNotIn('id', $cedulas_)->update(['cargo' => 'guest', 'estado' => 0]);
        ModelEcommerce::whereNotIn('cedula_ase', $cedulas_)->update(['estado_ase' => 'Inactivo']);
        ModelMesaAyuda::whereNotIn('cedula', $cedulas_)->update(['estado_usuario' => 0]);*/

        return view('apps.intranet.usuarios.home', ['dptos' => $dptos, 'usuarios' => $data]);
    }
}
