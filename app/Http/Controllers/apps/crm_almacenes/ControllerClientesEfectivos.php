<?php

namespace App\Http\Controllers\apps\crm_almacenes;

use App\Http\Controllers\Controller;
use App\Models\apps\crm_almacenes\ModelClientesCRM;
use App\Models\apps\crm_almacenes\ModelVentasEfectivasCrm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerClientesEfectivos extends Controller
{
    public function index()
    {
        $data_ = ModelClientesCRM::join('ventas_efectivas', 'clientes_crm.id_cliente', '=', 'ventas_efectivas.id_cliente')
            ->where('cedula_asesor', Auth::user()->id)
            ->whereBetween('ventas_efectivas.fecha_compra', [date('Y-m') . "-01", date('Y-m-d')])->get();


        return view('apps.crm_almacenes.gcp.asesor.efectivos', ['clientes' => $data_]);
    }

    public function actualizarInformacion(Request $request)
    {
        $id_cliente = $request->id;

        switch ($request->campo) {
            case 'categoria':
                $info_c = ModelClientesCRM::find($id_cliente);
                $info_c->categoria = $request->valor;
                $info_c->save();
                break;

            case 'estado':
                ModelVentasEfectivasCrm::where('id_cliente', $id_cliente)->update(['estado' => $request->valor]);
                break;
        }

        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
