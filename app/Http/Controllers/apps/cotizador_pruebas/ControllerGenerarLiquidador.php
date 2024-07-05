<?php

namespace App\Http\Controllers\apps\cotizador_pruebas;

use App\Http\Controllers\Controller;
use App\Models\apps\cotizador\cartera\ModelCartera;
use App\Models\apps\cotizador\ModelDepartamentos;
use App\Models\apps\cotizador\ModelInfoSucursales;
use App\Models\apps\cotizador_pruebas\ModelCotizacionesRealizadas;
use App\Models\apps\cotizador_pruebas\ModelInfoClientesCRM;
use App\Models\apps\cotizador_pruebas\ModelInfoLlamadasPendientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use function PHPUnit\Framework\isNull;

class ControllerGenerarLiquidador extends Controller
{
    public function TablaProductos()
    {
        $productos = ModelCotizacionesRealizadas::where('idsession', session('IdSession'))->get();
        return view('apps.cotizador_pruebas.tableProducts')->with('productos', $productos)->render();
    }

    public function realizarCalculosCot()
    {
        $total_venta = 0;
        $valor_descuento = 0;
        $descuento_adicional = 0;

        $productos = ModelCotizacionesRealizadas::where('idsession', session('IdSession'))->get();
        foreach ($productos as $key => $value) {
            $valor_item = ($value->vlr_credito * $value->cantidad);
            $total_venta += $valor_item;
            $descuento_ = round($valor_item * ($value->descuento / 100));
            $valor_descuento += $descuento_;
            $descuento_adicional += round(($valor_item - $descuento_) * (($value->dsto_adicional / 100)));
        }

        $total_a_pagar = $total_venta - $valor_descuento - $descuento_adicional;

        return ([
            'neto' => $total_venta,
            'descuento' => $valor_descuento,
            'descuento_adicional' => $descuento_adicional,
            'total_a_pagar' => $total_a_pagar
        ]);
    }

    public function liquidacion_plan()
    {
        $cotizador = self::realizarCalculosCot();

        return view('apps.cotizador_pruebas.detalleVenta', [
            'neto' => $cotizador['neto'],
            'normal' => $cotizador['descuento'],
            'adicional' => $cotizador['descuento_adicional'],
            'total' => $cotizador['total_a_pagar'],
        ])->render();
    }


    public function index()
    {
        $data_i = ModelInfoClientesCRM::where("id_cotizacion", session('IdSession'))->first();
        $productos = ModelCotizacionesRealizadas::where('idsession', session('IdSession'))->get();

        $dptos = ModelDepartamentos::all();
        $tableView = self::TablaProductos();
        $liquidacion = self::liquidacion_plan();

        return view(
            'apps.cotizador_pruebas.productos_cotizados',
            [
                'tblProducts' => $tableView,
                'productos' => $productos,
                'planesV' => $liquidacion,
                'dptos' => $dptos,
                'cliente' => $data_i
            ]
        );
    }


    public function eliminar(Request $request)
    {
        $id_item_cotizado = $request->id_cotizacion;
        $info_ = ModelCotizacionesRealizadas::find($id_item_cotizado);
        $info_->delete();

        $tableView = self::TablaProductos();
        $planesVentaC = self::liquidacion_plan();

        return response()->json(['status' => true, 'tblProducts' => $tableView, 'viewDetalle' => $planesVentaC], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function actualizar(Request $request)
    {
        $id_item_cotizado = $request->id_cotizacion;
        $cantidad = empty($request->cantidad) ? '1' : $request->cantidad;
        $descuento = empty($request->descuento) ? '0' : $request->descuento;
        $dsto_adicional = empty($request->dsto_ad) ? '0' : $request->dsto_ad;

        $info_cot = ModelCotizacionesRealizadas::find($id_item_cotizado);
        $info_cot->cantidad = $cantidad;
        $info_cot->descuento = $descuento;
        $info_cot->dsto_adicional = $dsto_adicional;
        $info_cot->save();

        $tableView = self::TablaProductos();
        $planesVentaC = self::liquidacion_plan();

        return response()->json(['status' => true, 'tblProducts' => $tableView, 'viewDetalle' => $planesVentaC], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function estructuraClienteCartera($data)
    {
        $info_g = $data->first();

        $body = '';
        $header = '<div class="alert" role="alert">
            <strong>Observaciones:</strong><br><br>
            El cliente <span style="font-size: 14px; text-transform: uppercase;"><strong>' . $info_g->nombre_cliente . '</strong></span>
            identificado con el número de cédula <span style="font-size: 14px;"><strong>' . $info_g->cedula_cliente . '</strong></span>
            no se le puede realizar el proceso de crédito ya que presenta las siguientes novedades: <br><br>
            <table class="table table-sm">
            <thead>
            <tr>
            <th>Cuenta</th>
            <th>Almacén</th>
            <th>Observaciones</th>
            </tr>
            </thead>
            <tbody>
            ';

        foreach ($data as $key => $value) {
            $body .= '<tr>
                            <td>' . $value->cuenta_cliente . '</td>
                            <td>' . $value->almacen_cliente . '</td>
                            <td>' . $value->observaciones . '</td>
                        </tr>';
        }
        $footer = '</tbody>
                        </table>';
        return $header . $body . $footer;
    }

    public function ValidarDatosCotizacion(Request $request)
    {
        $cedula_ = $request->cedula;

        $cuenta_cartera = ModelCartera::where('cedula_cliente', $cedula_)->count();
        if ($cuenta_cartera != 0) {
            $info_c = ModelCartera::where('cedula_cliente', $cedula_)->get();
            $table = self::estructuraClienteCartera($info_c);
            return response()->json(['status' => 'cartera', 'mensaje' => '¡ERROR! No puede realizar el crédito a este cliente', 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function agregarInformacionCotizacionCRM(Request $request)
    {
        $opcion = $request->opcion_final;
        $data_i = ModelInfoClientesCRM::where("id_cotizacion", session('IdSession'))->first();

        $cedula_c = $request->cedula_cliente;
        $nombre_c = $request->primer_nombre;
        $apellido_c = $request->primer_apellido;
        $direccion_c = $request->direccion;
        $barrio_c = $request->barrio;
        $celular_ = $request->telefono1;
        $correo_ = $request->correo;
        $cumple_c = $request->cumple_cl;

        if (!$data_i) {
            $data_ = ModelInfoClientesCRM::create([
                'cedula_cliente' => $cedula_c,
                'nombre_1' => $nombre_c,
                'apellido_1' => $apellido_c,
                'direccion' => $direccion_c,
                'ciudad' => $request->ciudad,
                'id_ciudad' => $request->id_ciudad,
                'id_depto' => $request->depto,
                'id_pais' => '169',
                'barrio' => $barrio_c,
                'celular_1' => $celular_,
                'email' => $correo_,
                'fecha_cumple' => $cumple_c,
                'genero' => $request->genero,
                'fecha_registro' => date('Y-m-d'),
                'prioridad' => '1',
                'origen' => 'Punto de venta',
                'tipo_cliente' => '2',
                'cedula_asesor' => Auth::user()->id,
                'id_cotizacion' => session('IdSession'),
                'estado' => '1'
            ]);

            if ($data_) {
                $id_cliente = $data_->id_cliente;
                ModelInfoLlamadasPendientes::create([
                    'fecha_a_llamar' => date("Y-m-d", strtotime(date('Y-m-d') . "+ 2 days")),
                    'estado' => 'PENDIENTE',
                    'id_cliente' => $id_cliente
                ]);
            }
        } else {
            $id_cliente = $data_i->id_cliente;
            $data_i->cedula_cliente = $cedula_c;
            $data_i->nombre_1 = $nombre_c;
            $data_i->apellido_1 = $apellido_c;
            $data_i->direccion = $direccion_c;
            $data_i->barrio = $barrio_c;
            $data_i->celular_1 = $celular_;
            $data_i->email = $correo_;
            $data_i->fecha_cumple = $cumple_c;
            $data_i->save();
        }

        switch ($opcion) {
            case 'pdf':
                return response()->json(['status' => true, 'url' => route('generar.pdf.cotizacion.pruebas', ['cliente' => $id_cliente])], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                break;
            case 'wp':
                $mensaje = "Hola 👋 buen día le escribe " . Auth::user()->nombre . ", su especialista en productos para el hogar 🏡 de Muebles Albura. Adjunto envio la cotización de los productos pre-seleccionados por usted. Estaré muy pendiente de la confirmación de su compra, y así proceder con la entrega de su pedido lo antes posible.";
                $url = "https://web.whatsapp.com/send/?phone=57$celular_&text=$mensaje&type=phone_number&app_absent=0";
                return response()->json(['status' => true, 'url' => $url], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                break;
            case 'email':

                $info_sucursales = ModelInfoSucursales::where('co', Auth::user()->sucursal)->first();
                $to = $correo_;

                $pdf_ = new ControllerPdfCotizacion();
                $pdf = $pdf_->GenerarPdfCotizacionP($id_cliente);

                if (isNull($info_sucursales)) {
                    $reply = 'sistemas@mueblesalbura.com.co';
                } else {
                    $reply = $info_sucursales->email;
                }

                Mail::send('apps.cotizador_pruebas.email.cotizacion', ['asesor' => Auth::user()->nombre], function ($mail) use ($to, $pdf, $reply) {
                    $mail->to($to);
                    $mail->replyTo($reply);
                    $mail->subject('PDF COTIZACIÓN MUEBLES ALBURA SAS');
                    $mail->attachData($pdf->output('S'), 'COTIZACION_MUEBLES_ALBURA_SAS.pdf');
                });

                return response()->json(['status' => true, 'mensaje' => 'Email enviado'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                break;
        }
    }
}
