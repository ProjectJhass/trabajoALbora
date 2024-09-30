<?php

namespace App\Http\Controllers\apps\cotizador_pruebas;

use App\Http\Controllers\apps\cotizador\session\session;
use App\Http\Controllers\Controller;
use App\Models\apps\cotizador\cartera\ModelCartera;
use App\Models\apps\cotizador_pruebas\ModelClientesCreditoCrexit;
use App\Models\apps\cotizador_pruebas\ModelCotizacionesRealizadas;
use App\Models\apps\cotizador_pruebas\ModelInfoClientesCRM;
use App\Models\apps\cotizador_pruebas\ModelInfoLlamadasPendientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ControllerGenerarCredito extends Controller
{
    public function solicitarCredito(Request $request)
    {
        $id_sesion = session('IdSession');
        $cedula = $request->cedula_credito;
        $primer_nombre = $request->nombre1_credito;
        $segundo_nombre = $request->nombre2_credito;
        $primer_apellido = $request->apellido1_credito;
        $segundo_apellido = $request->apellido2_credito;
        $id_departamento = $request->depto_credito;
        $id_ciudad = $request->id_ciudad_credito;
        $ciudad_credito = $request->ciudad_credito_name;
        $barrio = $request->barrio_credito;
        $direccion = $request->direccion_credito;
        $telefono = $request->telefono1_credito;
        $celular = $request->telefono2_credito;
        $email = $request->correo_credito;
        $fecha_cumple_ = $request->cumple_cl_credito;
        $genero_ = $request->genero_credito;
        $valor_a_financiar = trim(str_replace((['$', ',', '.']), "", $request->txt_financiar_credito));
        $valor_a_financiar_inicial = trim(str_replace((['$', ',', '.']), "", $request->txt_financiar_credito_inicial));

        if (empty($cedula) || empty($primer_nombre) || empty($primer_apellido) || empty($id_departamento) || empty($id_ciudad) || empty($barrio) || empty($direccion) || empty($telefono) || empty($email)) {
            return response()->json(['status' => false, 'mensaje' => '¡ERROR! los campos en rojo no deben estar vacios'], 401);
        }

        $cuenta_cartera = ModelCartera::where('cedula_cliente', $cedula)->count();

        if ($cuenta_cartera != 0) {
            $info_cartera_negativa = ModelCartera::where('cedula_cliente', $cedula)->get();
            // $table = self::estructuraClienteCartera($info_c);
            return response()->json(['status' => 'cartera', 'mensaje' => 'No puede realizar el crédito a este cliente'], 400, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        $productos = ModelCotizacionesRealizadas::where('idsession', session('IdSession'))->get();
        $items = $productos->map(function ($item) use ($id_sesion) {
            return [
                'id_item' => $item->sku,
                'item' => $item->producto,
                'valor_unitario' => $item->vlr_credito,
                'cantidad' => $item->cantidad,
                'descuento' => $item->descuento,
                'id_cotizacion' => $id_sesion
            ];
        })->toArray();

        $datos_credito = ([
            'cedula' => $cedula,
            'primer_nombre' => $primer_nombre,
            'segundo_nombre' => $segundo_nombre,
            'primer_apellido' => $primer_apellido,
            'segundo_apellido' => $segundo_apellido,
            'id_departamento' => $id_departamento,
            'id_ciudad' => $id_ciudad,
            'barrio' => $barrio,
            'direccion' => $direccion,
            'celular' => $telefono,
            'celular_dos' => $celular,
            'email' => $email,
            'valor_a_financiar' => $valor_a_financiar,
            'id_asesor' => Auth::user()->id,
            'nombre_asesor' => Auth::user()->nombre,
            'otra_informacion' => $items
        ]);

        //Url del endpoint para envio de informacion

        // if(Auth::user()->id == "6401505") {
        //     $url_endPoint = 'https://scriptcase-8.dev.cuotasoft.com/scriptcase/app/Albura/blank_api_creacion_prospecto/';
        // } else {
        //     $url_endPoint = 'https://albura.cuotasoft.com/blank_api_creacion_prospecto/';
        // }

        $url_endPoint = 'https://albura.cuotasoft.com/blank_api_creacion_prospecto/';
        //Llave de autenticacion
        $key = '|03ya9C]OTsQcjjm#_mZ:&gf%;*Y#u*V=}F£W!vbO{7g$6%_H9';

        $response = Http::withHeaders(['Key' => $key])->withOptions(['verify' => false])->post($url_endPoint, $datos_credito);

        if ($response->successful()) {

            $data_i = ModelInfoClientesCRM::where("id_cotizacion", session('IdSession'))->first();

            if (!$data_i) {
                $data_ = ModelInfoClientesCRM::create([
                    'cedula_cliente' => $cedula,
                    'nombre_1' => $primer_nombre,
                    'nombre_2' => $segundo_nombre ?? "",
                    'apellido_1' => $primer_apellido,
                    'apellido_2' => $segundo_apellido ?? "",
                    'direccion' => $direccion,
                    'ciudad' => $ciudad_credito,
                    'id_ciudad' => $id_ciudad,
                    'id_depto' => $id_departamento,
                    'id_pais' => '169',
                    'barrio' => $barrio ?? "",
                    'celular_1' => $telefono,
                    'celular_2' => $celular,
                    'email' => $email,
                    'fecha_cumple' => $fecha_cumple_,
                    'genero' => $genero_,
                    'fecha_registro' => date('Y-m-d'),
                    'prioridad' => '1',
                    'origen' => 'Punto de venta',
                    'tipo_cliente' => '2',
                    'cedula_asesor' => Auth::user()->id,
                    'id_cotizacion' => session('IdSession'),
                    'estado' => '1'
                ]);
            } else {
                $id_cliente = $data_i->id_cliente;
                $data_i->cedula_cliente = $cedula;
                $data_i->nombre_1 = $primer_nombre;
                $data_i->nombre_2 = $segundo_nombre;
                $data_i->apellido_1 = $primer_apellido;
                $data_i->apellido_2 = $segundo_apellido;
                $data_i->direccion = $direccion;
                $data_i->barrio = $barrio;
                $data_i->celular_1 = $telefono;
                $data_i->celular_2 = $celular;
                $data_i->email = $email;
                $data_i->save();
            }

            $data_credito = ModelClientesCreditoCrexit::where("id_cotizacion", session('IdSession'))->first();

            if (!$data_credito) {
                ModelClientesCreditoCrexit::create([
                    "id_cotizacion" => session('IdSession'),
                    "cedula_cliente" => $cedula,
                    "valor_a_financiar" => $valor_a_financiar,
                    "valor_inicial" => $valor_a_financiar_inicial ?? 0,
                    "items" => base64_encode(json_encode($items))
                ]);
            } else {
                $data_credito->cedula_cliente = $cedula;
                $data_credito->valor_a_financiar = $valor_a_financiar;
                $data_credito->valor_inicial = $valor_a_financiar_inicial ?? 0;
                $data_credito->items = base64_encode(json_encode($items));
                $data_credito->save();
            }

            return response()->json(['status' => true, 'mensaje' => 'Información creada existosamente'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        } else {
            if ($response->status() == 409) {
                return response()->json(['status' => false, 'mensaje' => 'El usuario ya está registrado'], $response->status());
            } else {
                return response()->json(['status' => false, 'mensaje' => 'Error no conocido.', 'response' => $response], $response->status());
            }
        }
    }
}
