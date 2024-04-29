<?php

namespace App\Http\Controllers\apps\crm_almacenes;

use App\Http\Controllers\Controller;
use App\Models\apps\cotizador\ModelGenerarHash;
use App\Models\apps\crm_almacenes\ModelClientesCRM;
use App\Models\apps\crm_almacenes\ModelHistorialCambios;
use App\Models\apps\crm_almacenes\ModelInfoLlamadasPendientes;
use App\Models\apps\crm_almacenes\ModelItemsCotizadosCrm;
use App\Models\apps\crm_almacenes\ModelVentasEfectivasCrm;
use App\Models\soap\crm\ModelConsultasCRM;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerVentasEfectivas extends Controller
{
    public function index(Request $request)
    {
        $co = $request->co;
        $fve = $request->fve;
        $info = '';

        $cos = array(
            '002' => '002 - ARMENIA',
            '003' => '003 - CARTAGO',
            '004' => '004 - IBAGUE',
            '006' => '006 - PEREIRA',
            '007' => '007 - CARTAGO',
            '008' => '008 - DOSQUEBRADAS',
            '010' => '010 - PEREIRA',
            '011' => '011 - GIRARDOT',
            '012' => '012 - NEIVA',
            '014' => '014 - PEREIRA',
            '017' => '017 - MANIZALES',
            '025' => '025 - IBAGUE',
            '027' => '027 - GIRARDOT',
            '028' => '028 - PEREIRA',
            '036' => '036 - CALI'
        );

        $data_cliente = ModelConsultasCRM::ventasEfectivasInfoCliente($fve, $co);
        if (count($data_cliente) > 0) {
            $data_prod = ModelConsultasCRM::ventasEfectivasProductos($data_cliente[0]['rowid']);
            foreach ($data_prod as $key => $value) {
                $info .= '
                <tr>
                <td>' . $value['sku'] . '</td>
                <td>' . $value['producto'] . '</td>
                <td>' . number_format($value['cantidad']) . '</td>
                <td>$' . number_format($value['valor']) . '</td>
                </tr>';
            }
        }

        $status = count($data_cliente) > 0 ? true : false;
        return response()->json(['status' => $status, 'co' => isset($cos[$co]) ? $cos[$co] : '020 - PPAL', 'cliente' => $data_cliente, 'productos' => $info], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function efectivos(Request $request)
    {
        $id_user = $request->id_user_crm;
        $info_cliente = ModelClientesCRM::find($id_user);

        $info_array = $info_cliente->toArray();
        $json_ = json_encode($info_array);

        ModelHistorialCambios::create([
            'log_evento' => 'Data: ' . $json_,
            'log_id_registro' => $id_user,
            'log_accion' => 'DELETE',
            'log_id_usuario' => Auth::user()->id,
            'log_nombre_usuario' => Auth::user()->nombre,
            'log_sucursal' => Auth::user()->sucursal
        ]);

        $fve = $request->fve_efect;
        $co = $request->co_efect;
        $co = strlen($co) == 3 ? $co : "0" . $co;
        $co2 = $request->co;
        $forma_pago = $request->forma_pago_c;
        $cierre = $request->cierre_venta;

        $id_session = ModelGenerarHash::make();
        $data_cliente = ModelConsultasCRM::ventasEfectivasInfoCliente($fve, $co);
        $data_prod = ModelConsultasCRM::ventasEfectivasProductos($data_cliente[0]['rowid']);

        $data_productos = [];

        $ciudad_compra = isset($data_cliente[0]['ciudad']) ? $data_cliente[0]['ciudad'] : '';
        $ciudad_compra = !empty($ciudad_compra) ? strtoupper($ciudad_compra) : '';


        $data_user = ([
            'cedula_cliente' => trim($data_cliente[0]['cedula']),
            'nombre_1' => isset($data_cliente[0]['nombre']) ? $data_cliente[0]['nombre'] : '',
            'nombre_2' => '',
            'apellido_1' => isset($data_cliente[0]['ap1']) ? $data_cliente[0]['ap1'] : '',
            'apellido_2' => isset($data_cliente[0]['ap2']) ? $data_cliente[0]['ap2'] : '',
            'direccion' => isset($data_cliente[0]['direccion']) ? strtoupper($data_cliente[0]['direccion']) : '',
            'ciudad' => $ciudad_compra,
            'barrio' => isset($data_cliente[0]['barrio']) ? strtoupper($data_cliente[0]['barrio']) : '',
            'celular_1' => !empty($data_cliente[0]['celular']) ? $data_cliente[0]['celular'] : '1',
            'celular_2' => isset($data_cliente[0]['celular2']) ? $data_cliente[0]['celular2'] : NULL,
            'email' => isset($data_cliente[0]['email']) ? $data_cliente[0]['email'] : '',
            'tipo_cliente' => '3',
            'id_cotizacion' => $id_session,
            'updated_at' => Carbon::now()
        ]);

        $info_cliente->cedula_cliente = trim($data_cliente[0]['cedula']);
        $info_cliente->nombre_1 = isset($data_cliente[0]['nombre']) ? $data_cliente[0]['nombre'] : '';
        $info_cliente->nombre_2 = '';
        $info_cliente->apellido_1 = isset($data_cliente[0]['ap1']) ? $data_cliente[0]['ap1'] : '';
        $info_cliente->apellido_2 = isset($data_cliente[0]['ap2']) ? $data_cliente[0]['ap2'] : '';
        $info_cliente->direccion = isset($data_cliente[0]['direccion']) ? strtoupper($data_cliente[0]['direccion']) : '';
        $info_cliente->ciudad = $ciudad_compra;
        $info_cliente->barrio = isset($data_cliente[0]['barrio']) ? strtoupper($data_cliente[0]['barrio']) : '';
        $info_cliente->celular_1 = !empty($data_cliente[0]['celular']) ? $data_cliente[0]['celular'] : '1';
        $info_cliente->celular_2 = isset($data_cliente[0]['celular2']) ? $data_cliente[0]['celular2'] : NULL;
        $info_cliente->email = isset($data_cliente[0]['email']) ? $data_cliente[0]['email'] : '';
        $info_cliente->tipo_cliente = '3';
        $info_cliente->id_cotizacion = $id_session;
        $info_cliente->save();


        foreach ($data_prod as $key => $value) {
            $valor = $value['valor'] / $value['cantidad'];

            ModelItemsCotizadosCrm::create([
                'idsession' => $id_session,
                'sku' => $value['sku'],
                'producto' => $value['producto'],
                'vlr_contado' => $valor,
                'cantidad' => $value['cantidad'],
                'vlr_credito' => $valor,
                'dsto_adicional' => '0',
                'plan' => 'CO',
                'descuento' => '0',
                'cuotas' => '1',
                'asesor' => Auth::user()->usuario,
                'fecha' => date('Y-m-d', strtotime($data_cliente[0]['fecha'])),
                'sucursal' => $co2
            ]);
        }

        ModelVentasEfectivasCrm::create([
            'numero_factura' => $fve,
            'medio_de_pago' => $cierre,
            'almacen_pago' => $co2,
            'forma_pago' => $forma_pago,
            'valor_flete' => '0',
            'fecha_compra' => date('Y-m-d', strtotime($data_cliente[0]['fecha'])),
            'estado' => 'FACTURADO',
            'id_cliente' => $id_user,
        ]);

        ModelInfoLlamadasPendientes::where('estado', 'PENDIENTE')->where('id_cliente', $id_user)->delete();

        return response()->json(['status' => true, 'cliente' => $data_user, 'productos' => $data_productos], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public static function EstructuraProductosCotizados($productos, $estado)
    {
        $total_pagar = 0;
        $productos_ = '<table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>Producto</th>
                <th>Cant</th>
                <th>Valor c/u</th>
                <th>Descuento</th>
                <th>Valor total</th>';

        if ($estado != 3) {
            $productos_ .= '<th>Accion</th>';
        }
        $productos_ .= '
            </tr>
        </thead>
        <tbody class="text-center">';
        foreach ($productos as $key => $val) {
            $vlr_producto = (($val->cantidad) * ($val->vlr_credito)) - (((($val->cantidad) * ($val->vlr_credito))) * ($val->descuento / 100));
            $total_pagar += $vlr_producto;
            $productos_ .= '
            <tr>
            <td class="text-left">' . $val->producto . '</td>
            <td>' . $val->cantidad . '</td>
            <td>' . number_format($val->vlr_credito) . '</td>
            <td>' . $val->descuento . '</td>
            <td>' . number_format($vlr_producto) . '</td>';
            if ($estado != 3) {
                $productos_ .= '<td><button class="btn btn-sm btn-danger" onclick=' . "EliminarProductoCotizadoCrm('" . $val->id_cotizacion . "')" . '><i class="fas fa-trash"></i></button></td>';
            }
            $productos_ .= '</tr>';
        }
        $productos_ .= '</tbody>
        </table>';

        return array($productos_, $total_pagar);
    }

    public function ObtenerInformacionVentaEfectiva(Request $request)
    {
        $info_c = ModelClientesCRM::with([
            'ventasEfectivas',
            'itemsCotizados'
        ])->find($request->id_cliente);

        $data = self::EstructuraProductosCotizados($info_c->itemsCotizados, $info_c->tipo_cliente);
        return response()->json(['status' => true, 'coti' => $info_c->id_cotizacion, 'cedula' => $info_c->cedula_cliente, 'origen' => $info_c->origen, 'tipo' => $info_c->tipo_cliente, 'data' => $data[0], 'a_pagar' => $data[1]], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
