<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelComments;
use App\Models\apps\intranet\Modelidea;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ControllerIdeas extends Controller
{
    public function viewIdeasSection($section)
    {
        $ideas_section = ModelIdea::getIdeasSection($section);

        $data = [];

        foreach ($ideas_section as $value) {

            $id = $value->id_idea;
            $id_persona = $value->id_usuario;
            $nombre = $value->nombre_documento;
            $url = $value->url_doc;
            $fecha = $value->fecha_cargue;
            $conteo = ModelIdea::getCountComments($id);
            $nombrePersona = ModelComments::getPersonName($id_persona);
            $self_usuario = Auth::user()->id;
            $categoria = $value->categoria;
            $link = $value->link;

            array_push($data, [

                'id' => $id,
                'nombre' => $nombre,
                'url' => $url,
                'fecha' => $fecha,
                'conteo' => $conteo,
                'nombre_persona' => $nombrePersona,
                'self_usuario' => $self_usuario,
                'id_usuario' => $id_persona,
                'categoria' => $categoria,
                'link' => $link,
            ]);
        }

        return view("apps.intranet.fabrica.vista.tarjetas", ['info' => $data])->render();
    }


    public function ideasRender(Request $request)
    {

        $render = self::viewIdeasSection($request->seccion);
        return response()->json(['status' => true, 'render' => $render], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function viewIdeas($info)
    {
        $data = [];

        foreach ($info as $key => $value) {
            $id = $value->id_idea;
            $id_persona = $value->id_usuario;
            $nombre = $value->nombre_documento;
            $url = $value->url_doc;
            $fecha = $value->fecha_cargue;
            $conteo = ModelIdea::getCountComments($id);
            $nombrePersona = ModelComments::getPersonName($id_persona);
            $self_usuario = Auth::user()->id;


            array_push($data, [
                'id' => $id,
                'nombre' => $nombre,
                'url' => $url,
                'fecha' => $fecha,
                'conteo' => $conteo,
                'nombre_persona' => $nombrePersona,
                'self_usuario' => $self_usuario,
                'id_usuario' => $id_persona

            ]);
        }
        return view('apps.intranet.fabrica.vista.tarjetas', ['info' => $data])->render();
    }

    public function getInfoIdeas()
    {
        // $info = ModelIdea::getIdeas();
        //$ideas = self::viewIdeas($info);
        $prototipos = self::viewIdeasSection('salas');
        return view('apps.intranet.fabrica.ideas', ['form' => $prototipos]);
    }

    public function getViewComentarios($id)
    {
        $data = [];

        $comentarios = ModelComments::getComments($id);

        foreach ($comentarios as $key => $value) {

            array_push($data, [
                'id_comentario' => $value->id_comentario,
                'comentarios' => $value->comentarios,
                'fecha_comentario' => $value->fecha_comentario,
                'hora_comentario' => $value->hora_comentario,
                'id_ideas' => $value->id_ideas,
                'id_usuario' => $value->id,
                'self_usuario' => Auth::user()->id,
                'nombre' => $value->nombre
            ]);
        }
        return view('apps.intranet.fabrica.vista.comentarios', ['info' => $data])->render();
    }


    public function mostrarComentarios(Request $request)
    {

        $id_idea = $request->id_idea;
        $consulta = self::getViewComentarios($id_idea);

        return response()->json(['status' => true, 'comment' => $consulta], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }


    public function enviarComentario(Request $request)
    {

        $date = Carbon::now();
        $hora = $date->toTimeString();
        $date = $date->format('Y-m-d');

        $comentario = $request->texto;
        $id_idea = $request->id_ideas;
        $id_usuario = Auth::user()->id;
        $fecha = date('Y-m-d');

        $data = ([
            'comentarios' => $comentario,
            'fecha_comentario' => $fecha,
            'id_ideas' => $id_idea,
            'hora_comentario' => $hora,
            'id_usuario' => $id_usuario
        ]);

        $response = ModelComments::insertComment($data);
        if ($response) {

            $consulta = self::getViewComentarios($id_idea);
            $viewCount = self::viewIdeasSection($request->seccion);

            return response()->json(['status' => true, 'comment' => $consulta, 'viewCount' => $viewCount], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
        return response()->json([], 500);
    }


    public function deleteIdea(Request $request)
    {

        $id_borrar = $request->id_borrar_idea;

        $response = ModelIdea::deleteIdea($id_borrar);

        if ($response) {
            $response2 = self::viewIdeasSection($request->seccion);

            return response()->json(['status' => true, 'idea' => $response2], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        return response()->json([], 500);
    }

    public function deletecomment(Request $request)
    {

        $id_comentarios = $request->id_comentario;
        $id_idea = $request->id_ideas;
        $res = ModelComments::deleteComment($id_comentarios);


        if ($res) {

            $response = self::getViewComentarios($id_idea);
            $response2 = self::viewIdeasSection($request->seccion);
            return response()->json(['status' => true, 'borrar_comentario' => $response, 'borrado' => $response2], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function uploadFiles(Request $request)
    {
        $dataFile = array("pdf", "jpg", "jpeg", "png", "JPG", "JPEG", "PNG");


        $archivo =  $request->file('file');
        $link = $request->input_link;

        if (isset($archivo) && isset($link)) {

            $nombre_archivo = $archivo->getClientOriginalName();
            $tipo = $archivo->getClientOriginalExtension();
            $categoria = $request->seccion;

            if (in_array($tipo, $dataFile)) {

                $archivo->storeAs('public/ideas/', $nombre_archivo);
                $url_doc = Storage::url("ideas/" . $nombre_archivo);

                $nombre_documento = $request->nombre_idea;

                $data = ([
                    'url_doc' => $url_doc,
                    'fecha_cargue' => date('Y-m-d'),
                    'hora_cargue' => date('H:i:s'),
                    'tipo_doc' => $tipo,
                    'id_usuario' => Auth::user()->id,
                    'nombre_documento' => $nombre_documento,
                    'categoria' => $categoria,
                    'link' => $link
                ]);


                $response = ModelIdea::insertIdea($data);
                if ($response) {
                    $response2 = self::viewIdeasSection($request->seccion);
                    return response()->json(['status' => true, 'respuesta' => $response2], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                }
            }

            return response()->json(["status", false], 500);
        } else if (!isset($archivo) && isset($link)) {
            $nombre_documento = $request->nombre_idea;
            $categoria = $request->seccion;

            $data = ([

                'url_doc' => '/storage/img/web.jpg',
                'fecha_cargue' => date('Y-m-d'),
                'hora_cargue' => date('H:i:s'),
                'tipo_doc' => "link",
                'id_usuario' => Auth::user()->id,
                'nombre_documento' => $nombre_documento,
                'categoria' => $categoria,
                'link' => $link
            ]);

            $response = ModelIdea::insertIdea($data);
            if ($response) {
                $response2 = self::viewIdeasSection($request->seccion);

                return response()->json(['status' => true, 'respuesta' => $response2], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        } else if (isset($archivo) && !isset($link)) {

            $nombre_archivo = $archivo->getClientOriginalName();
            $tipo = $archivo->getClientOriginalExtension();
            $categoria = $request->seccion;
            if (in_array($tipo, $dataFile)) {

                $archivo->storeAs('public/ideas/', $nombre_archivo);
                $url_doc = Storage::url("ideas/" . $nombre_archivo);

                $nombre_documento = $request->nombre_idea;

                $data = ([
                    'url_doc' => $url_doc,
                    'fecha_cargue' => date('Y-m-d'),
                    'hora_cargue' => date('H:i:s'),
                    'tipo_doc' => $tipo,
                    'id_usuario' => Auth::user()->id,
                    'nombre_documento' => $nombre_documento,
                    'categoria' => $categoria

                ]);


                $response = ModelIdea::insertIdea($data);
                if ($response) {
                    $response2 = self::viewIdeasSection($request->seccion);

                    return response()->json(['status' => true, 'respuesta' => $response2], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                }
            }

            return response()->json(["status", false], 500);
        }
    }


    public function buscadorCategoria($request)
    {

        $buscar = $request->buscar;
        $section = $request->seccion;

        $ideas_section = ModelIdea::searcher($buscar, $section);
        $data = [];

        foreach ($ideas_section as $value) {

            $id = $value->id_idea;
            $id_persona = $value->id_usuario;
            $nombre = $value->nombre_documento;
            $url = $value->url_doc;
            $fecha = $value->fecha_cargue;
            $conteo = ModelIdea::getCountComments($id);
            $nombrePersona = ModelComments::getPersonName($id_persona);
            $self_usuario = Auth::user()->id;
            $categoria = $value->categoria;
            $link = $value->link;

            array_push($data, [

                'id' => $id,
                'nombre' => $nombre,
                'url' => $url,
                'fecha' => $fecha,
                'conteo' => $conteo,
                'nombre_persona' => $nombrePersona,
                'self_usuario' => $self_usuario,
                'id_usuario' => $id_persona,
                'categoria' => $categoria,
                'link' => $link,
            ]);
        }


        return view("apps.intranet.fabrica.vista.tarjetas", ['info' => $data])->render();
    }

    public function searchIdea(Request $request)
    {
        $response = self::buscadorCategoria($request);
        ////// ACA ESTOY
        if ($response) {

            return response()->json(['status' => true, 'respuesta' => $response], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        return response()->json(['status', false], 500);
    }

    public function changeSection(Request $request)
    {


        $id_idea = $request->id_idea;
        $section_c = $request->seccion_c;
        $archivo = $request->file("input-cambio");
        $section = $request->seccion;
        $link = $request->link;





        if ($section != $section_c && isset($archivo)) {

            $borrado = self::borrarImage($request);
            $nombre_doc = $archivo->getClientOriginalName();
            $ext_doc = $archivo->getClientOriginalExtension();
            $archivo->storeAs('public/ideas/', $nombre_doc);
            $url_doc = Storage::url("ideas/" . $nombre_doc);


            $datos = ([
                'url_doc' => $url_doc,
                'tipo_doc' => $ext_doc
            ]);

            ModelIdea::updateImage($datos, $id_idea);

            $update = ModelIdea::updateIdea($id_idea, $section_c);

            $update2 = self::viewIdeasSection($request->seccion);

            if ($update) {

                return response()->json(['cambio' => $update2], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        } else if ($section == $section_c && isset($archivo)) {


            $borrado = self::borrarImage($request);
            if (!$borrado || $borrado) {

                $actualizar_imagen = self::updateImage($request);
                if ($actualizar_imagen) {

                    $update2 = self::viewIdeasSection($request->seccion);
                    return response()->json(['cambio' => $update2], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                }
            }
        } else if ($section != $section_c && !isset($archivo)) {

            $update = ModelIdea::updateIdea($id_idea, $section_c);

            $update2 = self::viewIdeasSection($request->seccion);

            if ($update) {

                return response()->json(['cambio' => $update2], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        } else if (isset($link) && $section == $section_c && !isset($archivo)) {

            $insert_link = ModelIdea::editLink($id_idea, $link);

            $update2 = self::viewIdeasSection($request->seccion);

            if ($insert_link) {

                return response()->json(['cambio' => $update2], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
            }
        }
    }


    public function deleteImg(Request $request)
    {
        $id_idea = $request->id_idea;

        $url_delete = ModelIdea::getPath($id_idea);

        foreach ($url_delete as $key => $value) {

            $url = $value->url_doc;
        }

        $url_nueva = str_replace("/storage", "", $url);

        $url_borrar = "/img/sin_fondo.jpg";
        $url_link = "/img/web.jpg";



        if ($url_borrar == $url_nueva || $url_nueva == $url_link) {


            return response()->json(['cambio' => 'sin imagen'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        } else {
            $update = ModelIdea::deleteImg($id_idea);
            $update2 = self::viewIdeasSection($request->seccion);

            $borrado =  Storage::delete('public' . $url_nueva);
            return response()->json(['cambio' => $update2], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }



    public function borrarImage(Request $request)
    {

        $id_idea = $request->id_idea;

        $url_delete = ModelIdea::getPath($id_idea);
        $url = "";

        foreach ($url_delete  as $value) {

            $url = $value->url_doc;
        }

        $url_nueva = str_replace("/storage", "", $url);

        $url_borrar = "/img/sin_fondo.jpg";
        $url_link = "/img/web.jpg";


        if ($url_borrar == $url_nueva || $url_nueva == $url_link) {


            return false;
        } else {

            $borrado =  Storage::delete('public' . $url_nueva);

            return true;
        }
    }


    public function updateImage($request)
    {

        $id_idea = $request->id_idea;
        $archivo = $request->file("input-cambio");

        $nombre_doc = $archivo->getClientOriginalName();
        $ext_doc = $archivo->getClientOriginalExtension();
        $archivo->storeAs('public/ideas/', $nombre_doc);
        $url_doc = Storage::url("ideas/" . $nombre_doc);


        $datos = ([
            'url_doc' => $url_doc,
            'tipo_doc' => $ext_doc
        ]);

        $actualizar_url = ModelIdea::updateImage($datos, $id_idea);

        if ($actualizar_url) {

            return true;
        }
    }


    function deleteLink(Request $request)
    {

        $id_idea = $request->id_idea;
        $section = $request->seccion;

        $borrar_link = Modelidea::deleteLink($id_idea);

        if ($borrar_link) {

            $update2 = self::viewIdeasSection($request->seccion);
            return response()->json(['cambio' => $update2], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
