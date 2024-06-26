<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios;

use App\Http\Controllers\apps\servicios_tecnicos\servicios\seguimiento\ControllerSeguimiento;
use App\Http\Controllers\Controller;
use App\Mail\NotificacionCreacionOst;
use App\Models\apps\servicios_tecnicos\pagina_web\ModelEvidenciasPw;
use App\Models\apps\servicios_tecnicos\pagina_web\ModelPaginaWeb;
use App\Models\apps\servicios_tecnicos\servicios\infoAlmacenes;
use App\Models\apps\servicios_tecnicos\servicios\ModelEvidenciasVisita;
use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use App\Models\apps\servicios_tecnicos\servicios\ModelSeguimientoVisita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ControllerNuevaSolicitud extends Controller
{
    public function addEvidenciasSt($id_insert, $imagenes, $comentario, $responsable, $fecha, $tipo_st_)
    {

        $extensions = (['png', 'jpg', 'jpeg', 'tiff', 'webp', 'mp4']);

        $info_seg = ModelSeguimientoVisita::create([
            'comentario' => $comentario,
            'responsable' => $responsable,
            'id_st' => $id_insert,
            'fecha_responsable' => $fecha
        ]);

        foreach ($imagenes as $file) {
            $tipo = $file->getClientOriginalExtension();

            if (in_array($tipo, $extensions)) {
                $name_ = str_replace("." . $tipo, "", $file->getClientOriginalName());
                $nombre = uniqid() . "_" . $file->getClientOriginalName();
                $tama = filesize($file);

                $response_file = $file->storeAs('public/evidencias', $nombre);
                $url_doc = Storage::url("public/evidencias/" . $nombre);

                if ($response_file) {

                    ModelEvidenciasVisita::create([
                        'nombre_img' => $name_,
                        'tipo' => $tipo,
                        'tama' => $tama,
                        'url' => $url_doc,
                        'tabla' => 'visita',
                        'id_comentario' => $info_seg->id,
                        'id_st' => $id_insert
                    ]);
                }
            }
        }

        if ($tipo_st_ != "ALMACEN" && $tipo_st_ != "BODEGA") {
            $seg_ = new ControllerSeguimiento();
            $seg_->updateSeguimiento($id_insert, 2);
            $seg_->agregarSeguimiento($id_insert, 3);

            ModelNuevaSolicitud::where('id_st', $id_insert)->update(['proceso' => 'Fabrica', 'estado' => 'En valoracion']);
            $email = new ControllerSeguimientoSt();
            $email->mailValoracionFab($id_insert);
        }
    }

    public function UpdateInfoSolicitudWeb($ticket, $id_insert)
    {
        $data_i = ModelPaginaWeb::where('n_ticket', $ticket)->get();
        $data_ = $data_i->first();
        $id_solicitud = $data_->id_ost;

        $info_seg = ModelSeguimientoVisita::create([
            'comentario' => 'Cliente envió las evidencias al momento de realizar la solicitud',
            'responsable' => Auth::user()->nombre,
            'id_st' => $id_insert,
            'fecha_responsable' => date('Y-m-d')
        ]);

        $url = ModelEvidenciasPw::where('id_ost_FK', $id_solicitud)->get();
        foreach ($url as $key => $value) {
            $name_ = str_replace("." . $value->extension, "", $value->nombre_doc);
            $nombre = uniqid() . "_" . $value->nombre_doc;

            $url_origen = public_path('storage/EvidenciasOST/' . $value->nombre_doc);
            $url_destino = public_path('storage/evidencias/' . $nombre);
            $dat_res =  File::move($url_origen, $url_destino);

            if ($dat_res) {

                ModelEvidenciasPw::where('id_evidencia', $value->id_evidencia)->delete();

                $url_doc = Storage::url("public/evidencias/" . $nombre);
                ModelEvidenciasVisita::create([
                    'nombre_img' => $name_,
                    'tipo' => $value->extension,
                    'tama' => $value->tamanio,
                    'url' => $url_doc,
                    'tabla' => 'visita',
                    'id_comentario' => $info_seg->id,
                    'id_st' => $id_insert
                ]);
            }
        }

        ModelNuevaSolicitud::where('id_st', $id_insert)->update(['proceso' => 'Fabrica', 'estado' => 'En valoracion']);
        ModelPaginaWeb::where('n_ticket', $ticket)->update(['estado' => 'procesado', 'num_ost' => $id_insert]);
        $email = new ControllerSeguimientoSt();
        $email->mailValoracionFab($id_insert);
    }

    public function validarEmail($email)
    {
        $patron = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';
        // Utilizando la función preg_match para hacer la validación
        if (preg_match($patron, $email)) {
            return true; // El correo es válido
        } else {
            return false; // El correo no es válido
        }
    }

    public function crearNuevaSolicitud(Request $request)
    {
        $causales = $request->has('causales_st') ? implode(", ", $request->causales_st) : NULL;

        $ticket = $request->ticket_pw;
        $almacen = $request->co_new_ost;
        $nombre_ = $request->nombre_st;
        $email_user = $request->email_st;
        $cantidad_item = $request->cantidad_item;
        $tipo_st_ = $request->txt_tipo_st;

        if (!self::validarEmail($email_user)) {
            return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        if (strlen($almacen) == 3) {
            $dat = infoAlmacenes::where('numero', $almacen)->get();
            $almacen_ = $dat->first();
            $almacen = $almacen_->almacen;
        }

        if ($cantidad_item != 0 && !empty($cantidad_item)) {
            $articulo_ = $request->articulo_st . " X " . $request->cantidad_item . " UND";
        } else {
            $articulo_ = $request->articulo_st;
            $cantidad_item = '0';
        }

        $respuesta_st = 'Por definir';
        $proceso = 'Servicio tecnico';
        $estado = 'Creado';

        if ($tipo_st_ == "ALMACEN" || $tipo_st_ == "BODEGA") {
            $respuesta_st = 'Valoracion';
            $proceso = 'Taller';
            $estado = 'Por ingresar';
        }

        $response = ModelNuevaSolicitud::create([
            'proveedor' => $request->proveedor_st,
            'ced_asesor' => Auth::user()->id,
            'asesor' => Auth::user()->nombre,
            'almacen' => $almacen,
            'tipo_servicio' => $tipo_st_,
            'cedula' => $request->cedula_st,
            'nombre' => $nombre_,
            'celular' => $request->celular_st,
            'email' => $email_user,
            'direccion' => $request->direccion_st,
            'barrio' => $request->barrio_st,
            'ciudad' => $request->ciudad_st,
            'forma_pago' => $request->pago_st,
            'cantidad' => $cantidad_item,
            'id_item' => $request->id_item,
            'articulo' => $articulo_,
            'ext1' => $request->ext1,
            'ext2' => $request->ext2,
            'factura' => $request->factura_st,
            'fecha_factura' => $request->fecha_factura,
            'remision' => $request->remision_st,
            'fecha_remision' => $request->fecha_remision,
            'inconveniente' => $request->obs,
            'causales' => $causales,
            'otro_causal' => $request->otro_causal_st,
            'respuesta_st' => $respuesta_st,
            'proceso' => $proceso,
            'estado' => $estado
        ]);

        $id_insert = $response->id_st;

        if (!empty($ticket)) {
            self::UpdateInfoSolicitudWeb($ticket, $id_insert);
        }

        if ($request->hasFile('evidencias_st')) {
            self::addEvidenciasSt($id_insert, $request->file('evidencias_st'), 'Cliente envió las evidencias al momento de realizar la solicitud', Auth::user()->nombre, date('Y-m-d'), $tipo_st_);
        }

        if ($response) {
            $seg_ = new ControllerSeguimiento();

            if ($tipo_st_ == "ALMACEN" || $tipo_st_ == "BODEGA") {
                $seg_->agregarSeguimiento($id_insert, 1);
                $seg_->updateSeguimiento($id_insert, 1);
                $seg_->agregarSeguimiento($id_insert, 2);
                $seg_->updateSeguimiento($id_insert, 2);
                $seg_->agregarSeguimiento($id_insert, 3);
                $seg_->updateSeguimiento($id_insert, 3);
                $seg_->agregarSeguimiento($id_insert, 4);
                $seg_->updateSeguimiento($id_insert, 4);
                $seg_->agregarSeguimiento($id_insert, 5);
            } else {
                $seg_->agregarSeguimiento($id_insert, 1);
                $seg_->updateSeguimiento($id_insert, 1);
                $seg_->agregarSeguimiento($id_insert, 2);
            }

            Mail::to($email_user)->later(now()->addSeconds(5), new NotificacionCreacionOst($id_insert, $nombre_, $articulo_));
            return response()->json(['status' => true, 'ost' => $id_insert], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function getInfoEmailAlmacen(Request $request)
    {
        $id_co = $request->co;
        $info = infoAlmacenes::where("numero", $id_co)->first();
        if ($info) {
            $email_ =  $info->email_info;
        } else {
            $email_ = "";
        }
        return response()->json(['status' => true, 'email' => $email_], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
