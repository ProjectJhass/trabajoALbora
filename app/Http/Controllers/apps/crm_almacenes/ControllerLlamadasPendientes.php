<?php

namespace App\Http\Controllers\apps\crm_almacenes;

use App\Http\Controllers\Controller;
use App\Models\apps\crm_almacenes\ModelClientesCRM;
use App\Models\apps\crm_almacenes\ModelComentariosClientesCrm;
use App\Models\apps\crm_almacenes\ModelInfoLlamadasPendientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerLlamadasPendientes extends Controller
{
    public function index()
    {
        $llamadas = ModelClientesCRM::join('llamadas_a_realizar as l', 'clientes_crm.id_cliente', 'l.id_cliente')
            ->where('clientes_crm.cedula_asesor', Auth::user()->id)
            ->where('l.estado', 'PENDIENTE')
            ->where('l.fecha_a_llamar', '<=', date('Y-m-d'))
            ->get();
        return view('apps.crm_almacenes.gcp.asesor.llamadas', ['llamadas' => $llamadas]);
    }

    public function productos(Request $request)
    {
        $info_c = ModelClientesCRM::with([
            'itemsCotizados'
        ])->find($request->id_cliente);

        $estructura = new ControllerVentasEfectivas();
        $table = $estructura->EstructuraProductosCotizados($info_c->itemsCotizados, 3);

        return response()->json(['status' => true, 'productos' => $table[0], 'vlr_pagar' => $table[1]], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function AgregarSeguimiento(Request $request)
    {
        $id_cliente = $request->id_cliente_crm;
        $id_llamada = $request->id_llamada_crm;
        if (!empty($request->comentario_seguimiento)) {

            $query = ModelComentariosClientesCrm::create([
                'comentario' => $request->comentario_seguimiento,
                'fecha' => date('Y-m-d'),
                'asesor' => Auth::user()->nombre,
                'id_llamada' => $id_llamada,
                'id_cliente' => $id_cliente,
            ]);

            if ($query) {
                $llamada_ = ModelInfoLlamadasPendientes::find($id_llamada);
                $llamada_->estado = "REALIZADA";
                $llamada_->save();

                if (!empty($request->fecha_proxima_llamada)) {
                    ModelInfoLlamadasPendientes::where('id_cliente', $id_cliente)->where('estado', 'PENDIENTE')->delete();
                    ModelInfoLlamadasPendientes::create([
                        'fecha_a_llamar' => $request->fecha_proxima_llamada,
                        'estado' => 'PENDIENTE',
                        'id_cliente' => $id_cliente
                    ]);
                }
                return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }
    }
}
