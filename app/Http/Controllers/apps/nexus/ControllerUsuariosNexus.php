<?php

namespace App\Http\Controllers\apps\nexus;

use App\Http\Controllers\Controller;
use App\Models\apps\nexus\ModelCiudades;
use App\Models\apps\nexus\ModelDepartamentos;
use App\Models\apps\nexus\ModelHistorialUsuarioManual;
use App\Models\apps\nexus\ModelInfoAreas;
use App\Models\apps\nexus\ModelInfoCargos;
use App\Models\apps\nexus\ModelInfoManualFunciones;
use App\Models\apps\nexus\ModelInfoRoles;
use App\Models\apps\nexus\ModelUsuarios;
use App\Models\soap\nexus\ModelCrearTercero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ControllerUsuariosNexus extends Controller
{
    public function usuarios()
    {
        $usuarios = ModelUsuarios::join("cargos as c", "c.id_cargo", "=", "cargo")->get();
        
        return view('apps.nexus.app.InformacionUsuarios.InformacionUsuarios.infoUsuarios', ['usuarios' => $usuarios]);
    }

    public function crearInfo()
    {
        $deptos = ModelDepartamentos::orderBy("depto")->get();
        $roles = ModelInfoRoles::where("estado", "Activo")->get();
        return view('apps.nexus.app.InformacionUsuarios.CrearUsuario.crearUsuario', ['deptos' => $deptos, 'roles' => $roles]);
    }

    public function buscarCiudad(Request $request)
    {
        $options = '<option value="">Seleccionar...</option>';
        $id_depto = $request->id_depto;
        $info = ModelCiudades::where("id_depto", $id_depto)->orderBy("ciudad")->get();
        foreach ($info as $key => $value) {
            $options .= '<option value="' . $value->id_city . '">' . $value->ciudad . '</option>';
        }

        return response()->json(['status' => true, 'info' => $options], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function buscarNombreUsuario(Request $request)
    {
        $usuario = $request->usuario;
        $info = ModelUsuarios::where('usuario', $usuario)->count();
        if ($info > 0) {
            return response()->json(['status' => false], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function buscarAreas(Request $request)
    {
        $id = $request->id;
        $options = '<option value="">Seleccionar...</option>';
        $info = ModelInfoAreas::where("id_empresa", $id)->orderBy("nombre_dpto")->get();
        foreach ($info as $key => $value) {
            $options .= '<option value="' . $value->id_dpto . '">' . $value->nombre_dpto . '</option>';
        }

        return response()->json(['status' => true, 'info' => $options], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function buscarCargosAreas(Request $request)
    {
        $id = $request->area;
        $options = '<option value="">Seleccionar...</option>';
        $info = ModelInfoCargos::where("id_departamento", $id)->orderBy("nombre_cargo")->get();
        foreach ($info as $key => $value) {
            $options .= '<option value="' . $value->id_cargo . '">' . $value->nombre_cargo . '</option>';
        }

        return response()->json(['status' => true, 'info' => $options], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function crearInformacionUsuariosNexus(Request $request)
    {
        $id_empresa = $request->empresa_user;
        $id_area = $request->area_user;
        $zona = $request->zona_user;
        $id_cargo = $request->cargo_user;
        $rol_usuario = $request->rol_user;
        $permisos = $request->permisos_user;
        $tipo_doc = $request->tipo_documento;
        $numero_documento = $request->numero_documento;
        $nombre_usuario = $request->nombre_usuario;
        $apellido_usuario = $request->apellidos_usuario;
        $celular = $request->celular;
        $celular2 = $request->celular2;
        $email = $request->email;
        $fecha_nacimiento = $request->fecha_nacimiento;
        $fecha_ingreso = $request->fecha_ingreso;
        $id_depto = $request->departamento;
        $nombre_depto = $request->nom_depto;
        $id_ciudad = $request->ciudad;
        $nombre_ciudad = $request->nom_ciudad;
        $barrio = $request->barrio;
        $direccion = $request->direccion;
        $usuario = $request->usuario;
        $password = $request->password;

        $siesa = isset($request->crear_siesa) ? true : false; //Si existe crear la información en Siesa
        $cambio_pwd = isset($request->cambiar_clave) ? 1 : 0;

        if (
            $request->hasFile('infoFotografia') &&
            !empty($id_empresa) &&
            !empty($id_area) &&
            !empty($id_cargo) &&
            !empty($rol_usuario) &&
            !empty($permisos) &&
            !empty($tipo_doc) &&
            !empty($numero_documento) &&
            !empty($nombre_usuario) &&
            !empty($apellido_usuario) &&
            !empty($celular) &&
            !empty($email) &&
            !empty($fecha_ingreso) &&
            !empty($id_depto) &&
            !empty($id_ciudad) &&
            !empty($usuario) &&
            !empty($password)
        ) {
            $tipos = array('jpg', 'jpeg', 'png', 'jfif');

            $fotografia = $request->file('infoFotografia');
            $nombre_foto = $fotografia->getClientOriginalName();
            $tipo = $fotografia->getClientOriginalExtension();
            $tama = $fotografia->getSize();

            $nombre_cargue = '';
            $url_img = '';

            if (!in_array(strtolower($tipo), $tipos)) {
                return response()->json(['error' => 'El archivo no es una imagen'], 422, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }

            $nombre_cargue = uniqid() . "_" . $nombre_foto;
            $fotografia->storeAs('public/nexus/fotos/', $nombre_cargue);
            $url_img = Storage::url("nexus/fotos/" . $nombre_cargue);

            $insert_user = ModelUsuarios::create([
                'tipo_doc' => $tipo_doc,
                'documento' => $numero_documento,
                'nombre' => $nombre_usuario,
                'apellidos' => $apellido_usuario,
                'celular' => $celular,
                'celular2' => $celular2,
                'email' => $email,
                'fecha_nacimiento' => $fecha_nacimiento,
                'fecha_ingreso' => $fecha_ingreso,
                'id_dpto' => $id_depto,
                'dpto' => $nombre_depto,
                'id_ciudad' => $id_ciudad,
                'ciudad' => $nombre_ciudad,
                'barrio' => $barrio,
                'direccion' => $direccion,
                'usuario' => $usuario,
                'pwd' => Hash::make($password),
                'pwd_cambio' => $cambio_pwd,
                'nombre_foto' => $nombre_cargue,
                'url' => $url_img,
                'tipo' => $tipo,
                'tama' => $tama,
                'area' => $id_area,
                'cargo' => $id_cargo,
                'rol' => $rol_usuario,
                'zona' => $zona,
                'permisos' => $permisos,
                'estado' => 'Activo'
            ]);

            if ($insert_user) {

                $id_user = $insert_user->id;
                $manual = ModelInfoManualFunciones::where("id_cargo", $id_cargo)->where("id_area", $id_area)->where("estado", "Activo")->first();
                $id_manual = isset($manual->id_manual) ? $manual->id_manual : null;

                if ($siesa) {
                    $plano_1 = self::crearInformacionPlanoSiesaTercero($numero_documento, $nombre_usuario, $apellido_usuario, $direccion, $id_depto, $id_ciudad, $barrio, $celular, $celular2, $email, $fecha_nacimiento);
                    $response_ws = ModelCrearTercero::ejecutarConsultaWs($plano_1);
                    if (is_bool($response_ws) === true && $response_ws === true) {
                        ModelHistorialUsuarioManual::create([
                            'id_area' => $id_area,
                            'id_cargo' => $id_cargo,
                            'id_manual_funciones' => $id_manual,
                            'id_usuario' => $id_user,
                            'estado' => 'Activo'
                        ]);

                        return response()->json(['status' => true, 'mensaje' => '¡EXCELENTE! Información creada con éxito'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                    } else {
                        $delete_user = ModelUsuarios::find($id_user);
                        $delete_user->delete();
                        return response()->json(['status' => false, 'mensaje' => $response_ws[0]['f_detalle']], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                    }
                }

                ModelHistorialUsuarioManual::create([
                    'id_area' => $id_area,
                    'id_cargo' => $id_cargo,
                    'id_manual_funciones' => $id_manual,
                    'id_usuario' => $id_user,
                    'estado' => 'Activo'
                ]);

                return response()->json(['status' => true, 'mensaje' => '¡EXCELENTE! Información creada con éxito'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }

        return response()->json(['status' => false], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }


    public function crearInformacionPlanoSiesaTercero($cedula, $nombre, $apellidos, $direccion, $id_dpto, $id_ciudad, $barrio, $celular, $celular2, $email, $fecha_nacimiento)
    {
        $cedula = trim($cedula);
        $cedula_ = strlen($cedula);
        $id = $cedula . str_repeat(" ", (15 - $cedula_));
        $nit = $cedula . str_repeat(" ", (25 - $cedula_));

        $nombre1 = strlen($nombre);

        $nombre_ = trim($nombre) . " " . trim($apellidos);
        $nombre_c = strlen($nombre_);
        $razon_social = substr($nombre_, 0, 100);
        $nombre_establecimiento = substr($nombre_, 0, 50);

        $apellido = explode(" ", trim($apellidos));
        $apellido1_n = $apellido[0];
        $apellido2_n = isset($apellido[1]) ? $apellido[1] : "";

        $apellido1 = strlen($apellido1_n);
        $apellido2 = strlen($apellido2_n);

        $direccion_ = trim($direccion);
        $direccion_c = strlen($direccion_);

        $celular_ = trim($celular);
        $celular_c = strlen($celular_);

        $celular2_ = trim($celular2);
        $celular2_c = strlen($celular2_);

        $barrio_ = trim($barrio);
        $barrio_c = strlen($barrio_);

        $email_ = trim($email);
        $email_c = strlen($email_);

        $fecha_nac = date("Ymd", strtotime($fecha_nacimiento));

        $F_NUMERO_REG = "0000002";
        $F_TIPO_REG = "0200";
        $F_SUBTIPO_REG = "00";
        $F_VERSION_REG = "08";
        $F_CIA = "002";
        $F_ACTUALIZA_REG = "1";
        $F200_ID = $id;
        $F200_NIT = $nit;
        $F200_DV_NIT = "   ";
        $F200_ID_TIPO_IDENT = "C";
        $F200_IND_TIPO_TERCERO = "1";
        $F200_RAZON_SOCIAL = $nombre_c > 100 ? $razon_social : $razon_social . str_repeat(" ", (100 - $nombre_c));
        $F200_APELLIDO1 = $apellido1 > 29 ? substr($apellido1, 0, 29) : $apellido1_n . str_repeat(" ", (29 - $apellido1));
        $F200_APELLIDO2 = $apellido2 > 29 ? substr($apellido2, 0, 29) : $apellido2_n . str_repeat(" ", (29 - $apellido2));
        $F200_NOMBRES = $nombre1 > 40 ? substr($nombre, 0, 40) : $nombre . str_repeat(" ", (40 - $nombre1));
        $F200_NOMBRE_EST = $nombre_c > 50 ? $nombre_establecimiento : $nombre_ . str_repeat(" ", (50 - $nombre_c));
        $F200_IND_CLIENTE = "0";
        $F200_IND_PROVEEDOR = "0";
        $F200_IND_EMPLEADO = "1";
        $F200_IND_ACCIONISTA = "0";
        $F200_IND_OTROS = "0";
        $F200_IND_INTERNO = "0";
        $F015_CONTACTO = $nombre_c > 50 ? $nombre_establecimiento : $nombre_ . str_repeat(" ", (50 - $nombre_c));
        $F015_DIRECCION1 = $direccion_c > 40 ? substr($direccion_, 0, 40) : $direccion_ . str_repeat(" ", (40 - $direccion_c));
        $F015_DIRECCION2 = str_repeat(" ", 40);
        $F015_DIRECCION3 = str_repeat(" ", 40);
        $F015_ID_PAIS = "169";
        $F015_ID_DEPTO = $id_dpto;
        $F015_ID_CIUDAD = $id_ciudad;
        $F015_ID_BARRIO = str_repeat(" ", 40);
        $F015_TELEFONO = $celular_c > 20 ? substr($celular_, 0, 20) : $celular_ . str_repeat(" ", (20 - $celular_c));
        $F015_FAX = str_repeat(" ", 20);
        $F015_COD_POSTAL = str_repeat(" ", 10);
        $F015_EMAIL = $email_c > 255 ? substr($email_, 0, 255) : $email_ . str_repeat(" ", (255 - $email_c));
        $F200_FECHA_NACIMIENTO = $fecha_nac;
        $F200_ID_CIIU = str_repeat(" ", 4);
        $F200_IND_NO_DOMICILIADO = "0";
        $F200_IND_ESTADO = "1";
        $F015_CELULAR = $celular2_c > 50 ? substr($celular2_, 0, 50) : $celular2_ . str_repeat(" ", (50 - $celular2_c));

        return $F_NUMERO_REG
            . $F_TIPO_REG
            . $F_SUBTIPO_REG
            . $F_VERSION_REG
            . $F_CIA
            . $F_ACTUALIZA_REG
            . $F200_ID
            . $F200_NIT
            . $F200_DV_NIT
            . $F200_ID_TIPO_IDENT
            . $F200_IND_TIPO_TERCERO
            . $F200_RAZON_SOCIAL
            . $F200_APELLIDO1
            . $F200_APELLIDO2
            . $F200_NOMBRES
            . $F200_NOMBRE_EST
            . $F200_IND_CLIENTE
            . $F200_IND_PROVEEDOR
            . $F200_IND_EMPLEADO
            . $F200_IND_ACCIONISTA
            . $F200_IND_OTROS
            . $F200_IND_INTERNO
            . $F015_CONTACTO
            . $F015_DIRECCION1
            . $F015_DIRECCION2
            . $F015_DIRECCION3
            . $F015_ID_PAIS
            . $F015_ID_DEPTO
            . $F015_ID_CIUDAD
            . $F015_ID_BARRIO
            . $F015_TELEFONO
            . $F015_FAX
            . $F015_COD_POSTAL
            . $F015_EMAIL
            . $F200_FECHA_NACIMIENTO
            . $F200_ID_CIIU
            . $F200_IND_NO_DOMICILIADO
            . $F200_IND_ESTADO
            . $F015_CELULAR;
    }
}
