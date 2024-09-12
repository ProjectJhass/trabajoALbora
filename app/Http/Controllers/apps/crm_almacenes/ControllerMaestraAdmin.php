<?php

namespace App\Http\Controllers\apps\crm_almacenes;

use App\Http\Controllers\Controller;
use App\Models\apps\crm_almacenes\ModelClientesCRM;
use App\Models\apps\crm_almacenes\ModelInfoAsesores;
use App\Models\apps\crm_almacenes\ModelInfoDepartamentos;
use App\Models\apps\crm_almacenes\ModelInfoLlamadasPendientes;
use App\Models\apps\crm_almacenes\ModelInfoOrigenClientes;
use App\Models\apps\crm_almacenes\ModelInfoSucursales;
use App\Models\apps\crm_almacenes\ModelVentasEfectivasCrm;
use App\Models\User;
use Illuminate\Http\Request;

class ControllerMaestraAdmin extends Controller
{
    public function informacionAsesor(Request $request)
    {
        $id_asesor = $request->id_asesor;
        $tipo_cliente = $request->tipo_cliente;

        if ($tipo_cliente == 0) {

            $info_clientes = ModelClientesCRM::with([
                'llamadasPendientes',
                'itemsCotizados',
                'cumpleanosEnviados'
            ])->where('cedula_asesor', $id_asesor)
                ->orderByDesc('created_at')
                ->get();

        }else{

            $columna = ($tipo_cliente == 5 || $tipo_cliente == 6) ? "estado" : "tipo_cliente";
            $valor = $tipo_cliente == 5 ? "2" : ($tipo_cliente == 6 ? "6" : $tipo_cliente);

            $info_clientes = ModelClientesCRM::with([
                'llamadasPendientes',
                'itemsCotizados',
                'cumpleanosEnviados'
            ])->where('cedula_asesor', $id_asesor)
                ->where($columna, $valor)
                ->orderByDesc('created_at')
                ->get();
        }

        $table = view('apps.crm_almacenes.gcp.administrador.tables.tableMaestraAdmin', ['clientes' => $info_clientes])->render();

        return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function index()
    {
        session()->forget(['fecha_i_c', 'fecha_f_c']);
        $almacenes = ModelInfoSucursales::all();
        $dptos = ModelInfoDepartamentos::all();
        $origen = ModelInfoOrigenClientes::all();
        return view('apps.crm_almacenes.gcp.administrador.maestra', ['sucursales' => $almacenes, 'deptos' => $dptos, 'origen' => $origen]);
    }

    public function ObtenerAsesoresC(Request $request)
    {
        $info = User::where('sucursal', $request->co)->where('estado', '1')->get();
        $data = '<option value="">Seleccionar...</option>';
        foreach ($info as $key => $value) {
            $data .= '<option value="' . $value->id . '" data-nombre="' . $value->nombre . '">' . $value->nombre . '</option>';
        }
        return response()->json(['status' => true, 'asesores' => $data], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function EliminarRegistroDB(Request $request)
    {
        if ($request->has('id_cliente')) {
            $data_c = ModelClientesCRM::find($request->id_cliente);
            $data_c->delete();
            ModelVentasEfectivasCrm::where('id_cliente', $request->id_cliente)->delete();
        } else {
            foreach ($request->declinarCliente as $key => $value) {
                $data_c = ModelClientesCRM::find($value);
                $data_c->delete();
                ModelVentasEfectivasCrm::where('id_cliente', $value)->delete();
            }
        }

        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
