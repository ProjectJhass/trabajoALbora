<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelRegistrarIngresos;
use App\Models\soap\ModelSoap;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ControllerRegistrarIngresos extends Controller
{
    protected static function ValidarExistenciaSiesa($cedula)
    {
        $data_usuario = ModelSoap::ObtenerInformacionUsuario($cedula);
        if (count($data_usuario) > 0) {
            return true;
        }
        return false;
    }

    protected static function ValidarExistenciaDB($cedula)
    {
        $existencia = ModelRegistrarIngresos::ValidarExistenciaEmpleado($cedula);
        if ($existencia == 0) {
            $nombre = '';
            $data_usuario = ModelSoap::ObtenerInformacionUsuario($cedula);
            foreach ($data_usuario as $key => $value) {
                $nombre = $value['nombre'];
            }
            $data = ([
                'id' => trim($cedula),
                'nombre' => trim($nombre),
                'email' => '',
                'permisos' => '1',
                'dpto_user' => '0',
                'permiso_dpto' => '0',
                'sucursal' => '020',
                'cargo' => 'guest',
                'usuario' => 'NOEXISTE',
                'password' => '$2$aa1',
                'zona' => '0',
                'ingreso_personal' => '1',
                'calendario' => '1',
                'estado' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            ModelRegistrarIngresos::RegistrarInformacion($data);
        }
    }

    public function RegistrarIngreso(Request $request)
    {
        $usuario = $request['cedula-usuario-i'];
        $hora = $request['hora-usuario-i'];
        $fecha = date('Y-m-d');
        $novedad_general = empty($request['novedad-general']) ? 'OTRO' : $request['novedad-general'];
        $novedad_u = $request['novedad-salida-user'];
        $evento = $request['validarAccionIngreso'];

        if (self::ValidarExistenciaSiesa($usuario)) {

            self::ValidarExistenciaDB($usuario);

            switch ($evento) {
                case 'ingresar':
                    if (ModelRegistrarIngresos::ValidarIngreso($usuario, $fecha) == 0) {
                        if (ModelRegistrarIngresos::RegistrarIngreso($usuario, $fecha, $hora)) {
                            return response()->json(['status' => true, 'mensaje' => 'Ingreso registrado'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                        }
                    } else {
                        return response()->json(['status' => false, 'mensaje' => 'El usuario ya está registrado'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                    }
                    break;
                case 'salir':
                    $id_tabla = ModelRegistrarIngresos::ObtenerIdIngreso($usuario, $fecha);

                    if (empty($id_tabla)) {
                        return response()->json(['status' => false, 'mensaje' => 'No ha registrado ingreso el día de hoy'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                    }

                    if (ModelRegistrarIngresos::ValidarSalida($usuario, $fecha) == 0) {
                        $data = (['hora_salida' => $hora]);
                        if (ModelRegistrarIngresos::ActualizarRegistroIngreso($data, $id_tabla)) {
                            if (!empty($novedad_u)) {
                                ModelRegistrarIngresos::RegistrarNovedad($usuario, $fecha, $novedad_u, $novedad_general, $id_tabla);
                            }
                            return response()->json(['status' => true, 'mensaje' => 'Salida registrada'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                        }
                    } else {
                        if (ModelRegistrarIngresos::ValidarHoraReIngreso($id_tabla)) {
                            $data = (['hora_salida_reingreso' => $hora]);
                            if (ModelRegistrarIngresos::ActualizarRegistroIngreso($data, $id_tabla)) {
                                if (!empty($novedad_u)) {
                                    ModelRegistrarIngresos::RegistrarNovedad($usuario, $fecha, $novedad_u, $novedad_general, $id_tabla);
                                }
                                return response()->json(['status' => true, 'mensaje' => 'Salida registrada'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                            }
                        } else {
                            return response()->json(['status' => false, 'mensaje' => 'El usuario ya registró salida'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                        }
                    }
                    break;
                case 'reingresar':

                    $id_tabla = ModelRegistrarIngresos::ObtenerIdIngreso($usuario, $fecha);

                    if (ModelRegistrarIngresos::ValidarReIngreso($usuario, $fecha) == 0) {
                        $data = (['hora_reingreso' => $hora]);
                        if (ModelRegistrarIngresos::ActualizarRegistroIngreso($data, $id_tabla)) {
                            return response()->json(['status' => true, 'mensaje' => 'Ingreso registrado'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                        }
                    } else {
                        return response()->json(['status' => false, 'mensaje' => 'El usuario ya está registrado'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                    }
                    break;
            }
        } else {
            return response()->json(['status' => false, 'mensaje' => 'El usuario no se encuentra en la empresa'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
