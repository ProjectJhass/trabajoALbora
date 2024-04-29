<?php

namespace App\Http\Controllers\apps\crm_almacenes;

use App\Http\Controllers\Controller;
use App\Models\apps\crm_almacenes\ModelClientesCRM;
use App\Models\soap\crm\crm_crearInfoSiesa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ControllerCrearTerceroSiesa extends Controller
{
    public function obtenerInfoCliente($id)
    {
        $data = ([
            'cedula' => '',
            'nombre' => '',
            'apellido1' => '',
            'apellido2' => '',
            'direccion' => '',
            'telefono' => '',
            'email' => '',
            'full_name' => '',
            'id_pais' => '',
            'id_depto' => '',
            'id_ciudad' => ''
        ]);

        $value = ModelClientesCRM::find($id);

        $data['cedula'] = $value->cedula_cliente;
        $data['nombre'] = $value->nombre_1 . " " . $value->nombre_2;
        $data['apellido1'] = $value->apellido_1;
        $data['apellido2'] = $value->apellido_2;
        $data['direccion'] = $value->direccion;
        $data['telefono'] = $value->celular_1;
        $data['email'] = $value->email;
        $data['id_pais'] = $value->id_pais;
        $data['id_depto'] = $value->id_depto;
        $data['id_ciudad'] = $value->id_ciudad;

        $data['full_name'] = $data['nombre'] . " " . $data['apellido1'] . " " . $data['apellido2'];

        return $data;
    }

    public function index($data)
    {
        $cedula = $data['cedula'];
        $nombre = $data['nombre'];
        $apellido1 = $data['apellido1'];
        $apellido2 = $data['apellido2'];
        $direccion_i = trim($data['direccion']);
        $direccion = substr($direccion_i, 0, 40);
        $direccion2 = strlen($direccion_i) > 40 ? str_replace($direccion, '', $direccion_i) : '';

        $telefono = $data['telefono'];
        $email = $data['email'];
        $id_pais = $data['id_pais'];
        $id_depto = $data['id_depto'];
        $id_ciudad = $data['id_ciudad'];
        $full_name = $data['full_name'];

        $F_NUMERO_REG = '0000002';
        $F_TIPO_REG = '0200';
        $F_SUBTIPO_REG = '00';
        $F_VERSION_REG = '08';
        $F_CIA = '002';
        $F_ACTUALIZA_REG = '1';
        $F200_ID = strlen($cedula) == '15' ? $cedula : ($cedula . str_repeat(" ", (15 - strlen($cedula)))); //15 caracteres //Campos variables ID Cliente
        $F200_NIT = strlen($cedula) == '25' ? $cedula : ($cedula . str_repeat(" ", (25 - strlen($cedula)))); //Campos variables ID Cliente
        $F200_DV_NIT = '   ';
        $F200_ID_TIPO_IDENT = 'C';
        $F200_IND_TIPO_TERCERO = '1';
        $F200_RAZON_SOCIAL = strlen($full_name) == '100' ? $full_name : ($full_name . str_repeat(" ", (100 - strlen($full_name)))); //Campos variables Nombre Concatenar
        $F200_APELLIDO1 = strlen($apellido1) == '29' ? $apellido1 : ($apellido1 . str_repeat(" ", (29 - strlen($apellido1)))); //Campos variables Nombre
        $F200_APELLIDO2 = strlen($apellido2) == '29' ? $apellido2 : ($apellido2 . str_repeat(" ", (29 - strlen($apellido2)))); //Campos variables Nombre
        $F200_NOMBRES = strlen($nombre) == '40' ? $nombre : ($nombre . str_repeat(" ", (40 - strlen($nombre)))); //Campos variables Nombre
        $F200_NOMBRE_EST = str_repeat(" ", 50); //Campos variables Nombre Concatenar
        $F200_IND_CLIENTE = '1';
        $F200_IND_PROVEEDOR = '0';
        $F200_IND_EMPLEADO = '0';
        $F200_IND_ACCIONISTA = '0';
        $F200_IND_OTROS = '0';
        $F200_IND_INTERNO = '0';
        $F015_CONTACTO = strlen($full_name) == '50' ? substr($full_name, 0, 50) : (substr($full_name, 0, 50) . str_repeat(" ", (50 - strlen($full_name))));
        $F015_DIRECCION1 = strlen($direccion) == '40' ? $direccion : (substr($direccion, 0, 40) . str_repeat(" ", (40 - strlen($direccion)))); //Variable Direccion
        $F015_DIRECCION2 = strlen($direccion2) == '40' ? $direccion2 : (substr($direccion2, 0, 40) . str_repeat(" ", (40 - strlen($direccion2)))); //Variable Direccion
        $F015_DIRECCION3 = str_repeat(" ", 40);
        $F015_ID_PAIS  = $id_pais;
        $F015_ID_DEPTO = $id_depto;
        $F015_ID_CIUDAD = $id_ciudad;
        $F015_ID_BARRIO = str_repeat(" ", 40);
        $F015_TELEFONO = strlen($telefono) == '20' ? $telefono : ($telefono . str_repeat(" ", (20 - strlen($telefono)))); //Variable Telefono
        $F015_FAX = str_repeat(" ", 20);
        $F015_COD_POSTAL = str_repeat(" ", 10);
        $F015_EMAIL = strlen($email) == '255' ? $email : ($email . str_repeat(" ", (255 - strlen($email)))); //Variable
        $F200_FECHA_NACIMIENTO = date('Ymd');
        $F200_ID_CIIU = "0010";
        $F200_IND_NO_DOMICILIADO = '0';
        $F200_IND_ESTADO = '1';
        $F015_CELULAR = str_repeat(" ", 50);

        $estructura_plano = $F_NUMERO_REG
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

        return $estructura_plano;
    }

    public function estructuraPlano2($data, $lista_precio, $tipo_cliente)
    {
        $condiones = ([
            '101' => 'CO', '102' => 2,
            '103' => 3, '104' => 4,
            '105' => 5, '106' => 6,
            '107' => 7, '108' => 8,
            '109' => 9, '110' => 10,
            '111' => 11, '112' => 12,
            '113' => 13, '114' => 14,
            '115' => 15, '116' => 16,
            '117' => 17, '118' => 18,
            '119' => 19, '120' => 20,
            '121' => 21, '122' => 22,
            '123' => 23, '124' => 24
        ]);

        $condicion_pago = $condiones[$lista_precio];

        $cedula = trim($data['cedula']);
        $nombre = trim($data['nombre']);
        $apellido1 = trim($data['apellido1']);
        $apellido2 = trim($data['apellido2']);
        $direccion_i = trim($data['direccion']);
        $direccion = substr($direccion_i, 0, 40);
        $direccion2 = strlen($direccion_i) > 40 ? str_replace($direccion, '', $direccion_i) : '';
        $telefono = trim($data['telefono']);
        $email = trim($data['email']);
        $id_pais = trim($data['id_pais']);
        $id_depto = trim($data['id_depto']);
        $id_ciudad = trim($data['id_ciudad']);
        $full_name = trim($data['full_name']);

        $name_sucursal = trim($apellido1 . " " . $apellido2 . " " . $nombre);


        $F_NUMERO_REG = '0000003'; //cantidad 7
        $F_TIPO_REG = '0201';
        $F_SUBTIPO_REG = '00';
        $F_VERSION_REG = '15';
        $F_CIA = '002';
        $F_ACTUALIZA_REG = '1';
        $F201_ID_TERCERO = strlen($cedula) == '15' ? $cedula : ($cedula . str_repeat(" ", (15 - strlen($cedula))));
        $F201_ID_SUCURSAL = '001';
        $F201_IND_ESTADO_ACTIVO = '1';
        $F201_DESCRIPCION_SUCURSAL = strlen($name_sucursal) == '40' ? substr($name_sucursal, 0, 40) : (substr($name_sucursal, 0, 40) . str_repeat(" ", (40 - strlen($name_sucursal))));
        $F201_ID_MONEDA = 'COP';
        $F201_ID_VENDEDOR = Auth::user()->codigo; //Id del vendedor
        $F201_IND_CALIFICACION = 'A';
        $F201_ID_COND_PAGO = strlen($condicion_pago) == '3' ? $condicion_pago : ($condicion_pago . str_repeat(" ", (3 - strlen($condicion_pago))));
        $F201_DIAS_GRACIA = '008';
        $F201_CUPO_CREDITO = '+000000000000000.0000';
        $F201_ID_CLIENTE_CORP = str_repeat(" ", 15);
        $F201_ID_SUCURSAL_CORP = str_repeat(" ", 3);
        $F201_ID_TIPO_CLI = $tipo_cliente;
        $F201_ID_GRUPO_DSCTO = str_repeat(" ", 4);;
        $F201_ID_LISTA_PRECIO = $lista_precio;
        $F201_IND_PEDIDO_BACKORDER = '0';
        $F201_PORC_EXCESO_VENTA = str_repeat("0", 7);
        $F201_PORC_MIN_MARGEN = str_repeat("0", 7);
        $F201_PORC_MAX_MARGEN = str_repeat("0", 7);
        $F201_IND_BLOQUEADO = '1';
        $F201_IND_BLOQUEO_CUPO = '0';
        $F201_IND_BLOQUEO_MORA = '1';
        $F201_IND_FACTURA_UNIFICADA = '0';
        $F201_ID_CO_FACTURA = str_repeat(" ", 3);
        $F201_NOTAS = str_repeat(" ", 255);
        $F015_CONTACTO = strlen($full_name) == '50' ? substr($full_name, 0, 50) : (substr($full_name, 0, 50) . str_repeat(" ", (50 - strlen($full_name))));
        $F015_DIRECCION1 = strlen($direccion) == '40' ? $direccion : (substr($direccion, 0, 40) . str_repeat(" ", (40 - strlen($direccion)))); //Variable Direccion;
        $F015_DIRECCION2 = strlen($direccion2) == '40' ? $direccion2 : (substr($direccion2, 0, 40) . str_repeat(" ", (40 - strlen($direccion2)))); //Variable Direccion
        $F015_DIRECCION3 = str_repeat(" ", 40);
        $F015_ID_PAIS  = $id_pais;
        $F015_ID_DEPTO = $id_depto;
        $F015_ID_CIUDAD = $id_ciudad;
        $F015_ID_BARRIO = str_repeat(" ", 40);
        $F015_TELEFONO = strlen($telefono) == '20' ? $telefono : ($telefono . str_repeat(" ", (20 - strlen($telefono)))); //Variable Telefono
        $F015_FAX = str_repeat(" ", 20);
        $F015_COD_POSTAL = str_repeat(" ", 10);
        $F015_EMAIL = strlen($email) == '255' ? $email : ($email . str_repeat(" ", (255 - strlen($email)))); //Variable
        $F201_FECHA_INGRESO = date('Ymd');
        $F201_ID_CO_MOVTO_FACTURA = str_repeat(" ", 3);
        $F201_ID_UN_MOVTO_FACTURA = str_repeat(" ", 20);
        $F201_ID_PARAMETRO_EDI = str_repeat(" ", 4);
        $F201_CODIGO_EAN = str_repeat(" ", 35);
        $f201_fecha_cupo = str_repeat(" ", 8);
        $f201_porc_tolerancia = str_repeat("0", 7);
        $f201_dia_maximo_factura = '00';
        $f201_id_motivo_bloqueo = str_repeat(" ", 3);
        $f201_id_cobrador = str_repeat(" ", 4);
        $f201_ind_compromiso_um_emp = '0';
        $f201_ind_anticipo_terc_corp = '0';
        $f015_celular = str_repeat(" ", 50);
        $f201_valida_cupo_despacho = '0';
        $f201_id_portafolio_edi = str_repeat(" ", 10);
        $f201_frecuencia_entrega = str_repeat("0", 7);
        $f201_id_cia_cliente_corp = '000';
        $f201_ind_valida_cartera_des = '0';
        $f201_ind_exceso_venta_adic = '0';

        $plano_2 = $F_NUMERO_REG
            . $F_TIPO_REG
            . $F_SUBTIPO_REG
            . $F_VERSION_REG
            . $F_CIA
            . $F_ACTUALIZA_REG
            . $F201_ID_TERCERO
            . $F201_ID_SUCURSAL
            . $F201_IND_ESTADO_ACTIVO
            . $F201_DESCRIPCION_SUCURSAL
            . $F201_ID_MONEDA
            . $F201_ID_VENDEDOR
            . $F201_IND_CALIFICACION
            . $F201_ID_COND_PAGO
            . $F201_DIAS_GRACIA
            . $F201_CUPO_CREDITO
            . $F201_ID_CLIENTE_CORP
            . $F201_ID_SUCURSAL_CORP
            . $F201_ID_TIPO_CLI
            . $F201_ID_GRUPO_DSCTO
            . $F201_ID_LISTA_PRECIO
            . $F201_IND_PEDIDO_BACKORDER
            . $F201_PORC_EXCESO_VENTA
            . $F201_PORC_MIN_MARGEN
            . $F201_PORC_MAX_MARGEN
            . $F201_IND_BLOQUEADO
            . $F201_IND_BLOQUEO_CUPO
            . $F201_IND_BLOQUEO_MORA
            . $F201_IND_FACTURA_UNIFICADA
            . $F201_ID_CO_FACTURA
            . $F201_NOTAS
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
            . $F201_FECHA_INGRESO
            . $F201_ID_CO_MOVTO_FACTURA
            . $F201_ID_UN_MOVTO_FACTURA
            . $F201_ID_PARAMETRO_EDI
            . $F201_CODIGO_EAN
            . $f201_fecha_cupo
            . $f201_porc_tolerancia
            . $f201_dia_maximo_factura
            . $f201_id_motivo_bloqueo
            . $f201_id_cobrador
            . $f201_ind_compromiso_um_emp
            . $f201_ind_anticipo_terc_corp
            . $f015_celular
            . $f201_valida_cupo_despacho
            . $f201_id_portafolio_edi
            . $f201_frecuencia_entrega
            . $f201_id_cia_cliente_corp
            . $f201_ind_valida_cartera_des
            . $f201_ind_exceso_venta_adic;

        return $plano_2;
    }

    public function estructuraPlano3($data)
    {
        $cedula = trim($data['cedula']);

        $F_NUMERO_REG = "0000004";
        $F_TIPO_REG = "0046";
        $F_SUBTIPO_REG = "00";
        $F_VERSION_REG = "01";
        $F_CIA = "002";
        $F_ACTUALIZA_REG = "1";
        $F_ID_TERCERO = strlen($cedula) == '15' ? $cedula : ($cedula . str_repeat(" ", (15 - strlen($cedula))));;
        $F_ID_SUCURSAL = "001";
        $F_ID_CLASE = "001";
        $F_ID_VALOR_TERCERO = "01";
        $F_ID_LLAVE = str_repeat(" ", 4);

        $plano3 = $F_NUMERO_REG
            . $F_TIPO_REG
            . $F_SUBTIPO_REG
            . $F_VERSION_REG
            . $F_CIA
            . $F_ACTUALIZA_REG
            . $F_ID_TERCERO
            . $F_ID_SUCURSAL
            . $F_ID_CLASE
            . $F_ID_VALOR_TERCERO
            . $F_ID_LLAVE;

        return $plano3;
    }

    public function validarInfo($id)
    {
        $cedula = '';
        $nombre = '';
        $apellido1 = '';
        $apellido2 = '';
        $id_ciudad = '';
        $id_depto = '';
        $id_pais = '';
        $direccion = '';
        $telefono = '';
        $email = '';

        $ced = array("6", "7", "8", "10");

        $value = ModelClientesCRM::find($id);

        $cedula = $value->cedula_cliente;
        $nombre = $value->nombre_1 . " " . $value->nombre_2;
        $apellido1 = $value->apellido_1;
        $apellido2 = $value->apellido_2;
        $id_ciudad = $value->id_ciudad;
        $id_depto = $value->id_depto;
        $id_pais = $value->id_pais;
        $direccion = $value->direccion;
        $telefono = $value->celular_1;
        $email = $value->email;

        $cant_ced = strlen($cedula);

        if (
            empty($cedula) ||
            empty($nombre) ||
            empty($apellido1) ||
            empty($telefono) ||
            empty($email) ||
            empty($direccion) ||
            empty($id_ciudad) ||
            empty($id_depto) ||
            empty($id_pais)
        ) {
            return false;
        }

        if (in_array($cant_ced, $ced)) {
            return true;
        }
        return false;
    }

    public function crearArchivoTxt($plano1, $plano2, $plano3)
    {
        $contenido = $plano1 . "\n";
        $contenido .= $plano2 . "\n";
        $contenido .= $plano3;
        $nombreArchivo = 'archivo.txt';
        $rutaArchivo = 'archivos/' . $nombreArchivo;
        Storage::put($rutaArchivo, $contenido);
        $urlDescarga = Storage::url($rutaArchivo);
    }


    public function CrearInformacion(Request $request)
    {
        try {
            if (self::validarInfo($request->id)) {
                $data_user = self::obtenerInfoCliente($request->id);

                $plano = self::index($data_user);
                $plano_2 = self::estructuraPlano2($data_user, $request->lista, $request->tipo);
                $plano_3 = self::estructuraPlano3($data_user);

                $parametros_siesa = crm_crearInfoSiesa::paramentros_ws_siesa($plano, $plano_2, $plano_3);
                $conexion_siesa = crm_crearInfoSiesa::conexion_ws_siesa($parametros_siesa);
                $resultado = $conexion_siesa->ImportarXML($parametros_siesa);

                self::crearArchivoTxt($plano, $plano_2, $plano_3);

                $errorXML = trim($resultado->printTipoError);

                $response = $errorXML == 0 ? true : false;

                return response()->json(['status' => $response], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }
}
