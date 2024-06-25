<?php

namespace App\Http\Controllers\apps\crm_almacenes;

use App\Http\Controllers\Controller;
use App\Models\apps\crm_almacenes\ModelClientesCRM;
use App\Models\apps\crm_almacenes\ModelComentariosClientesCrm;
use App\Models\apps\crm_almacenes\ModelHistorialCambios;
use App\Models\apps\crm_almacenes\ModelInfoDepartamentos;
use App\Models\apps\crm_almacenes\ModelInfoLlamadasPendientes;
use App\Models\apps\crm_almacenes\ModelInfoOrigenClientes;
use App\Models\apps\crm_almacenes\ModelInfoSucursales;
use App\Models\apps\crm_almacenes\ModelVentasEfectivasCrm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class ControllerMaestraAsesor extends Controller
{
    public function index()
    {
        session()->forget(['fecha_i_c', 'fecha_f_c']);

        $info_clientes = ModelClientesCRM::with([
            'llamadasPendientes',
            'itemsCotizados'
        ])->where('cedula_asesor', Auth::user()->id)
            ->where('tipo_cliente', '<>', '3')
            ->orderByDesc('created_at')
            ->get();

        $dptos = ModelInfoDepartamentos::all();
        $origen = ModelInfoOrigenClientes::all();

        $view = view('apps.crm_almacenes.gcp.asesor.tables.tableMaestra', ['clientes' => $info_clientes])->render();
        return view('apps.crm_almacenes.gcp.asesor.maestra', ['table_crm' => $view, 'origen' => $origen, 'deptos' => $dptos, 'tipo' => 4]);
    }

    public static function tipoCliente(Request $request)
    {
        $tipo_cliente = $request->tipo_cliente;
        $id_asesor = Auth::user()->id;

        if ($tipo_cliente == 0) {
            $info_clientes = ModelClientesCRM::with([
                'llamadasPendientes',
                'itemsCotizados'
            ])->where('cedula_asesor', $id_asesor)
                ->where('tipo_cliente', '<>', '3')
                ->orderByDesc('created_at')
                ->get();
        } else {
            $columna = ($tipo_cliente == 5 || $tipo_cliente == 6) ? "estado" : "tipo_cliente";
            $valor = $tipo_cliente == 5 ? "2" : ($tipo_cliente == 6 ? "6" : $tipo_cliente);

            $info_clientes = ModelClientesCRM::with([
                'llamadasPendientes',
                'itemsCotizados'
            ])->where('cedula_asesor', $id_asesor)
                ->where($columna, $valor)
                ->orderByDesc('created_at')
                ->get();
        }

        $view = view('apps.crm_almacenes.gcp.asesor.tables.tableMaestra', ['clientes' => $info_clientes])->render();
        return response()->json(['status' => true, 'table' => $view], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public static function EstructuraComentariosCliente($id_usuario)
    {
        $comentarios = '';
        $data = ModelComentariosClientesCrm::where('id_cliente', $id_usuario)->OrderByDesc('created_at')->get();
        foreach ($data as $key => $value) {
            if ($value->asesor != Auth::user()->nombre) {
                $comentarios .= '<div class="direct-chat-msg">
                <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-left">' . $value->asesor . '</span>
                    <span class="direct-chat-timestamp float-right">' . $value->fecha . '</span>
                </div>
                <img class="direct-chat-img" src="/ecommerce/img/profile.png" alt="message user image">
                <div class="direct-chat-text bg-info">
                    ' . $value->comentario . '
                </div>
            </div>';
            } else {
                $comentarios .= '<div class="direct-chat-msg right">
                <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-right">' . $value->asesor . '</span>
                    <span class="direct-chat-timestamp float-left">' . $value->fecha . '</span>
                </div>
                <img class="direct-chat-img" src="/ecommerce/img/profile.png" alt="message user image">
                <div class="direct-chat-text bg-success">
                    ' . $value->comentario . '
                </div>
            </div>';
            }
        }
        return $comentarios;
    }

    public function ObtenerComentarios(Request $request)
    {
        $comentarios = self::EstructuraComentariosCliente($request->id_usuario);
        return response()->json(['status' => true, 'comentarios' => $comentarios], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function AgregarComentarios(Request $request)
    {
        if (!empty($request->comentario)) {

            $response = ModelComentariosClientesCrm::create([
                'comentario' => $request->comentario,
                'fecha' => date('Y-m-d'),
                'asesor' => Auth::user()->nombre,
                'id_cliente' => $request->cliente,
            ]);

            if ($response) {
                $comentarios = self::EstructuraComentariosCliente($request->cliente);
                return response()->json(['status' => true, 'comentarios' => $comentarios], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            } else {
                return response()->json(['status' => false], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        } else {
            return response()->json(['status' => false], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function ObtenerInformacionCliente(Request $request)
    {
        $id_cliente = $request->id_cliente;
        $info_ = ModelClientesCRM::find($id_cliente);
        $info = $info_->toArray();
        return response()->json(['status' => true, 'data' => $info], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function ActualizarInformacionCliente(Request $request)
    {
        if (!empty($request->ciudad)) {

            $info_c = ModelClientesCRM::find($request->id_cliente_crm);

            $info_array = $info_c->toArray();
            $json_ = json_encode($info_array);

            ModelHistorialCambios::create([
                'log_evento' => 'Data: ' . $json_,
                'log_id_registro' => $request->id_cliente_crm,
                'log_accion' => 'DELETE',
                'log_id_usuario' => Auth::user()->id,
                'log_nombre_usuario' => Auth::user()->nombre,
                'log_sucursal' => Auth::user()->sucursal
            ]);

            $info_c->cedula_cliente = $request->cedula_cliente;
            $info_c->nombre_1 = $request->primer_nombre;
            $info_c->nombre_2 = $request->segundo_nombre;
            $info_c->apellido_1 = $request->primer_apellido;
            $info_c->apellido_2 = $request->segundo_apellido;
            $info_c->direccion = $request->direccion;
            $info_c->ciudad = $request->ciudad;
            $info_c->barrio = $request->barrio;
            $info_c->celular_1 = $request->celular_1;
            $info_c->celular_2 = $request->celular_2;
            $info_c->email = $request->email;
            $info_c->id_ciudad = $request->id_ciudad;
            $info_c->id_depto = $request->id_depto;
            $info_c->id_pais = $request->id_pais;
            $info_c->fecha_cumple = $request->cumple;
            $info_c->genero = $request->genero;
            $info_c->origen = $request->origen;
            $info_c->save();

            $info_c = ModelClientesCRM::find($request->id_cliente_crm);

            $info_array = $info_c->toArray();
            $json_ = json_encode($info_array);

            ModelHistorialCambios::create([
                'log_evento' => 'Data: ' . $json_,
                'log_id_registro' => $request->id_cliente_crm,
                'log_accion' => 'UPDATE',
                'log_id_usuario' => Auth::user()->id,
                'log_nombre_usuario' => Auth::user()->nombre,
                'log_sucursal' => Auth::user()->sucursal
            ]);

            return response()->json(['status' => true, 'mensaje' => 'Información actualizada'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        } else {
            return response()->json(['status' => false, 'mensaje' => 'Debes ingresar una ciudad'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function ProgramarNuevaLlamada(Request $request)
    {
        $id_cliente = $request->id_cliente;
        $fecha = $request->fecha;

        ModelInfoLlamadasPendientes::where('id_cliente', $id_cliente)->where('estado', 'PENDIENTE')->delete();
        ModelInfoLlamadasPendientes::create([
            'fecha_a_llamar' => $fecha,
            'estado' => 'PENDIENTE',
            'id_cliente' => $id_cliente
        ]);

        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function whatsapp($celular)
    {
        $mensaje = "Hola 👋 buen día, le escribe " . Auth::user()->nombre . ", su especialista en productos para el hogar 🏡 de Muebles Albura SAS.";
        return Redirect::to("https://api.whatsapp.com/send/?phone=57$celular&text=$mensaje&type=phone_number&app_absent=0", 302, []);
    }

    public function encuesta(Request $request)
    {
        $mensaje = "Hola 👋 buen día " . $request->nombre . ", Espero que se encuentre muy bien.%0A%0APara nuestra empresa es muy valioso conocer sus comentarios con respecto a nuestro producto y servicio, por tal razón le envío esta breve encuesta.%0A%0A Estamos comprometidos en hacer cada día más hogares 🏡 felices y sus comentarios contribuyen a nuestra mejora continua.%0A%0AHaga click aquí 👇🏼%0A%0Ahttps://intranet.mueblesalbura.com.co/encuesta-satisfaccion/public/";
        return Redirect::to("https://api.whatsapp.com/send/?phone=57$request->celular&text=$mensaje&type=phone_number&app_absent=0", 302, []);
    }

    public function EliminarClienteCrm(Request $request)
    {
        $id_cliente = $request->id_cliente;
        $info_c = ModelClientesCRM::find($id_cliente);
        $info_c->tipo_cliente = '0';
        $info_c->save();

        self::EnviarNotificacion($id_cliente);
        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function ActualizarTipoCliente(Request $request)
    {
        $tipo = $request->tipo;
        $cliente = $request->cliente;

        ModelVentasEfectivasCrm::where('id_cliente', $cliente)->delete();

        $info_cliente = ModelClientesCRM::find($cliente);
        $info_cliente->tipo_cliente = $tipo;
        $info_cliente->save();

        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function EnviarNotificacion($id_cliente)
    {
        $value = ModelClientesCRM::find($id_cliente);
        $cliente = $value->nombre_1 . " " . $value->nombre_2 . " " . $value->apellido_1 . " " . $value->apellido_2;

        $to = (['sandram.gonzalez@mueblesalbura.com.co', 'coordinadoraventas@mueblesalbura.com.co']);
        Mail::send('apps.crm_almacenes.email.eliminar_cliente', ['asesor' => Auth::user()->nombre, 'co' => Auth::user()->sucursal, 'cliente' => $cliente, 'registro' => $id_cliente], function ($mail) use ($to) {
            $mail->to($to);
            $mail->subject('Solicitud Eliminación de cliente');
        });
    }
}
