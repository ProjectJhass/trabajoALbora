<?php

namespace App\Http\Controllers\apps\cotizador;

use App\Http\Controllers\Controller;
use App\Models\apps\cotizador\ModelClientesCrmCot;
use App\Models\apps\cotizador\ModelInfoSucursales;
use App\Models\apps\crm_almacenes\ModelInfoLlamadasPendientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

use function PHPUnit\Framework\isNull;

class ControllerFinalizar extends Controller
{
    public function index()
    {
        $datos_cliente = ModelClientesCrmCot::where('cedula_cliente', session('cedula_cliente'))
            ->where('cedula_asesor', Auth::user()->id)
            ->where('id_cotizacion', session('IdSession'))
            ->count();

        if (!isNull($datos_cliente) || $datos_cliente > 0) {
            ModelClientesCrmCot::where('cedula_cliente', session('cedula_cliente'))
                ->where('cedula_asesor', Auth::user()->id)
                ->where('id_cotizacion', session('IdSession'))
                ->update([
                    'nombre_1' => session('primer_nombre'),
                    'nombre_2' => session('segundo_nombre'),
                    'apellido_1' => session('primer_apellido'),
                    'apellido_2' => session('segundo_apellido'),
                    'direccion' => session('direccion'),
                    'ciudad' => session('ciudad'),
                    'id_ciudad' => session('id_ciudad'),
                    'id_depto' => session('id_depto'),
                    'id_pais' => session('id_pais'),
                    'barrio' => session('barrio'),
                    'celular_1' => session('telefono1'),
                    'celular_2' => session('telefono2'),
                    'email' => session('correo'),
                    'fecha_cumple' => session('cumple'),
                    'genero' => session('genero'),
                    'categoria' => session('categoria'),
                    'fecha_registro' => date('Y-m-d'),
                    'prioridad' => '1',
                    'origen' => 'Punto de venta',
                    'tipo_cliente' => '2',
                    'estado' => '1'
                ]);
        } else {
            $data_ = ModelClientesCrmCot::create([
                'cedula_cliente' => session('cedula_cliente'),
                'nombre_1' => session('primer_nombre'),
                'nombre_2' => session('segundo_nombre'),
                'apellido_1' => session('primer_apellido'),
                'apellido_2' => session('segundo_apellido'),
                'direccion' => session('direccion'),
                'ciudad' => session('ciudad'),
                'id_ciudad' => session('id_ciudad'),
                'id_depto' => session('id_depto'),
                'id_pais' => session('id_pais'),
                'barrio' => session('barrio'),
                'celular_1' => session('telefono1'),
                'celular_2' => session('telefono2'),
                'email' => session('correo'),
                'fecha_cumple' => session('cumple'),
                'genero' => session('genero'),
                'categoria' => session('categoria'),
                'fecha_registro' => date('Y-m-d'),
                'prioridad' => '1',
                'origen' => 'Punto de venta',
                'tipo_cliente' => '2',
                'cedula_asesor' => Auth::user()->id,
                'id_cotizacion' => session('IdSession'),
                'estado' => '1'
            ]);
            if($data_){
                $id_cliente = $data_->id_cliente;
                ModelInfoLlamadasPendientes::create([
                    'fecha_a_llamar' => date("Y-m-d", strtotime(date('Y-m-d') . "+ 2 days")),
                    'estado' => 'PENDIENTE',
                    'id_cliente' => $id_cliente
                ]);
            }
        }

        return view('apps.cotizador.finalizar');
    }

    public function WhatsApp()
    {
        $mensaje = "Hola 👋 buen día le escribe " . Auth::user()->nombre . ", su especialista en productos para el hogar 🏡 de Muebles Albura. Adjunto envio la cotización de los productos pre-seleccionados por usted. Estaré muy pendiente de la confirmación de su compra, y así proceder con la entrega de su pedido lo antes posible.";
        $numero = session('telefono1');
        return Redirect::to("https://web.whatsapp.com/send/?phone=57$numero&text=$mensaje&type=phone_number&app_absent=0", 302, []);
    }

    public function Email()
    {
        $pdf_ = new ControllerPdfCotizacion();
        $pdf = $pdf_->GenerarPdfCotizacionP();

        $to = session('correo');

        if (!empty($to)) {
            $info_sucursales = ModelInfoSucursales::where('co', Auth::user()->sucursal)->first();
            if (isNull($info_sucursales)) {
                $reply = 'sistemas@mueblesalbura.com.co';
            } else {
                $reply = $info_sucursales->email;
            }
            Mail::send('apps.cotizador.email.cotizacion', ['asesor' => Auth::user()->nombre], function ($mail) use ($to, $pdf, $reply) {
                $mail->to($to);
                $mail->replyTo($reply);
                $mail->subject('PDF COTIZACIÓN MUEBLES ALBURA SAS');
                $mail->attachData($pdf->output('S'), 'COTIZACION_MUEBLES_ALBURA_SAS.pdf');
            });

            return response()->json(['status' => true, 'mensaje' => 'Email enviado'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        } else {
            return response()->json(['status' => false, 'mensaje' => 'ERROR: Debes agregar un email válido'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
