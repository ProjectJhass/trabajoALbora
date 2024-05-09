<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\pagina_web;

use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\pagina_web\ModelPaginaWeb;
use App\Models\apps\servicios_tecnicos\pagina_web\ModelWeb;
use App\Models\soap\st_ModelConsultas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ControllerWeb extends Controller
{
    function home()
    {
        return view("apps.servicios_tecnicos.pagina_web.home");
    }

    function formulario()
    {

        return view('apps.servicios_tecnicos.pagina_web.formulario');
    }

    function enviarEmail($email, $subject, $dataEmail)
    {
        $emails = [$email, 'serviciostecnicos@mueblesalbura.com.co'];

        Mail::send('apps.servicios_tecnicos.pagina_web.plantilla_email', ['data' => $dataEmail], function ($mail) use ($emails, $subject) {
            $mail->bcc($emails);
            $mail->subject($subject);
        });

        return true;
    }


    function comprobarTicket()
    {
        $ticket = "A2054";

        $ultimoRegistro = ModelWeb::ultimoRegistro();
        foreach ($ultimoRegistro as $key => $value) {
            $ticket = $value->n_ticket;
            $ticket = str_replace("A", "", $ticket);
            $ticket = "A" . $ticket + 1;
        }

        return $ticket;
    }


    function guardarOst(Request $request)
    {
        $cedula = $request->cedula;
        $nombre = $request->nombre;
        $telefono = $request->telefono;
        $email = $request->email;
        $opcion = $request->option;
        $descripcion = $request->descripcion;
        $almacen = $request->almacen;

        $ticket = self::comprobarTicket();

        $data_insert = ModelPaginaWeb::create([
            'n_ticket' => $ticket,
            'cedula_cliente' => $cedula,
            'nombre' => $nombre,
            'telefono' => $telefono,
            'email' => $email,
            'articulo' => $opcion,
            'descripcion_servicio' => $descripcion,
            'almacen' => $almacen,
            'fecha' => date('Y-m-d'),
            'estado' => 'creado',
            'num_ost' => NULL
        ]);

        $id_ost = $data_insert->id_ost;

        $dataFile = array("jpg", "jpeg", "png", "HEIF");
        $archivos = $request->file("evidencias");
        $video = $request->file("video");
        $tamanio_video = filesize($video);
        $data_video = [];

        if (isset($video)) {
            if ($tamanio_video <= 136314880) {

                $nombre_archivo = uniqid() . "_" . $video->getClientOriginalName();
                $video->storeAs('public/EvidenciasOST/', $nombre_archivo);
                $url_doc = Storage::url("EvidenciasOST/" . $nombre_archivo);
                $extension = $video->getClientOriginalExtension();

                $data_video = ([
                    'id_ost_FK' => $id_ost,
                    'extension' => $extension,
                    'url' => $url_doc,
                    'nombre_doc' => $nombre_archivo,
                    'tipo_doc' => '',
                    'tamanio' => $tamanio_video,
                    'fecha' => date('Y-m-d'),
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')
                ]);

                ModelWeb::insertEvidence($data_video);
            } else {

                ModelWeb::deleteOST($id_ost);

                $error = false;
                return response(['error' => $error]);
            }
        }


        $dataEvidence = [];

        if (count($archivos) >= 3 && count($archivos) <= 5) {

            foreach ($archivos as $index) {

                if (in_array($index->getClientOriginalExtension(), $dataFile)) {

                    $nombre_archivo = uniqid() . "_" . $index->getClientOriginalName();
                    $index->storeAs('public/EvidenciasOST/', $nombre_archivo);
                    $url_doc = Storage::url("EvidenciasOST/" . $nombre_archivo);
                    $extension = $index->getClientOriginalExtension();
                    $tamanio = filesize($index);

                    $dataEvidence = ([
                        'id_ost_FK' => $id_ost,
                        'extension' => $extension,
                        'url' => $url_doc,
                        'nombre_doc' => $nombre_archivo,
                        'tipo_doc' => '',
                        'tamanio' => $tamanio,
                        'fecha' => date('Y-m-d'),
                        'created_at' => date('Y-m-d'),
                        'updated_at' => date('Y-m-d')
                    ]);

                    ModelWeb::insertEvidence($dataEvidence);
                }
            }

            $data_email = [

                'n_ticket' => $ticket,
                'articulo' => $opcion,
                'cedula' => $cedula,
                'celular' => $telefono,
                'daño_reportado' => $descripcion,
                'almacen' => $almacen,
                'categoria' => $opcion,
                'nombre' => $nombre,
                'email' => $email
            ];

            $subject = "Solicitud de servicio técnico - Página web";
            self::enviarEmail($email, $subject, $data_email);
            //
            return response()->json(['ticket' => $ticket, 'email' => $email], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function getInfoClientePw(Request $request)
    {
        $cedulaU = $request->cedula_usuario;
        $numContacto = ["contacto" => ""];
        $nombre_ = ["fullname" => ""];
        $email_ = ["emailU" => ""];
        if (ctype_digit($cedulaU) && strlen($cedulaU) > 4 && strlen($cedulaU) < 20) {
            $info_ = st_ModelConsultas::getInfoCliente($cedulaU);
            $data_i = [];
            if (count($info_) > 0) {
                foreach ($info_ as $key => $value) {

                    $nombre_["fullname"] = trim($value["nombre"]) . " " . trim($value["ap1"]) . " " . trim($value["ap2"]);
                    $email_["emailU"] = isset($value["email"]) ? trim($value["email"]) : "";

                    if (isset($value['celular']) && !empty($value['celular'])) {
                        $numContacto["contacto"] = $value['celular'];
                    } else {
                        if (isset($value['celular2']) && !empty($value['celular2'])) {
                            $numContacto["contacto"] = $value['celular2'];
                        }
                    }
                }
                $data_i = $numContacto + $nombre_ + $email_;
            } else {
                $data_i = [];
            }

            return response()->json(['data' => $data_i], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
