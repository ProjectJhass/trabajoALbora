<?php

namespace App\Http\Controllers\apps\crm_almacenes;

use App\Http\Controllers\Controller;
use App\Models\apps\cotizador\ModelGenerarHash;
use App\Models\apps\crm_almacenes\ModelClientesCRM;
use App\Models\apps\crm_almacenes\ModelComentariosClientesCrm;
use App\Models\apps\crm_almacenes\ModelInfoDepartamentos;
use App\Models\apps\crm_almacenes\ModelInfoOrigenClientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerNuevoRegistroCliente extends Controller
{
    public function index()
    {
        $dptos = ModelInfoDepartamentos::all();
        $origen = ModelInfoOrigenClientes::all();
        return view('apps.crm_almacenes.gcp.asesor.digitar', ['deptos' => $dptos, 'origen' => $origen]);
    }

    public function BuscarInformacion(Request $request)
    {
        $cedula = $request->input("cedula");
        $info_ = ModelClientesCRM::where('cedula_cliente', $cedula)->first();
        if ($info_) {
            $data = $info_->toArray();
        } else {
            $data = [];
        }
        return response()->json(['status' => true, 'info' => $data], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function NuevaInformacion(Request $request)
    {
        if (
            !empty($request->cedula_cliente)
            && !empty($request->primer_nombre) && !empty($request->ciudad)
            && !empty($request->telefono1) && !empty($request->genero)
            && !empty($request->origen) && !empty($request->categoria)
            && !empty($request->observaciones)
        ) {

            $tipo_cliente = $request->tipo_c;
            if($tipo_cliente==6){
                $tipo_c = "1";
                $estado = "6";
            }else{
                $tipo_c = $tipo_cliente;;
                $estado = "1";  
            }

            $info_ = ModelClientesCRM::create([
                'cedula_cliente' => $request->cedula_cliente,
                'nombre_1' => $request->primer_nombre,
                'nombre_2' => $request->segundo_nombre,
                'apellido_1' => $request->primer_apellido,
                'apellido_2' => $request->segundo_apellido,
                'direccion' => $request->direccion,
                'ciudad' => $request->ciudad,
                'barrio' => $request->barrio,
                'celular_1' => $request->telefono1,
                'celular_2' => $request->telefono2,
                'email' => $request->correo,
                'id_ciudad' => $request->id_ciudad,
                'id_depto' => $request->id_depto,
                'id_pais' => $request->id_pais,
                'fecha_cumple' => $request->cumple,
                'genero' => $request->genero,
                'categoria' => $request->categoria,
                'fecha_registro' => date('Y-m-d'),
                'prioridad' => '1',
                'origen' => $request->origen,
                'tipo_cliente' => $tipo_c,
                'cedula_asesor' => Auth::user()->id,
                'id_cotizacion' => ModelGenerarHash::make(),
                'estado' => $estado,
            ]);

            if ($info_) {
                ModelComentariosClientesCrm::create([
                    'comentario' => $request->observaciones,
                    'fecha' => date('Y-m-d'),
                    'asesor' => Auth::user()->nombre,
                    'id_cliente' => $info_->id_cliente,
                ]);

                return response()->json(['status' => true, 'mensaje' => 'Información almacenada correctamente'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
            return response()->json(['status' => false, 'mensaje' => 'Hubo un problema al procesar la solicitud'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
        return response()->json(['status' => false, 'mensaje' => 'Completa los campos en rojo'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
