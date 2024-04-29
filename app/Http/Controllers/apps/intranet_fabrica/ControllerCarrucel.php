<?php

namespace App\Http\Controllers\apps\intranet_fabrica;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet_fabrica\ModelCarrucel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ControllerCarrucel extends Controller
{
    public function index()
    {
        $imagenes = ModelCarrucel::ImagenesDB();
        return view('apps.intranet_fabrica.fabrica.carrucel.carrucel', ['imagenes' => $imagenes]);
    }

    public function AgregarImagenes(Request $request)
    {
        $seccion = $request->tipo;

        if ($request->hasFile('imagenes_carrucel')) {
            $imagenes = $request->file('imagenes_carrucel');
            foreach ($imagenes as $file) {
                $nombre = uniqid() . "_" . $file->getClientOriginalName();
                $tama = filesize($file);
                $tipo = $file->getClientOriginalExtension();

                $response_file = $file->storeAs('carrucel', $nombre);
                if ($response_file) {
                    ModelCarrucel::GuardarInformacionImagenes($nombre, $tipo, $tama, $seccion);
                }
            }
            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function EliminarImagenes(Request $request)
    {
        $nombre_i = ModelCarrucel::ObtenerNombreIMG($request->id_imagen);
        if (Storage::delete('carrucel/' . $nombre_i)) {
            ModelCarrucel::EliminarImagenesCarrucel($request->id_imagen);
            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }

    public function ActivarImagenes(Request $request)
    {

        $id_img = $request->id_imagen;
        $estado = ModelCarrucel::ObtenerEstadoIMG($id_img);
        $new_estado = ($estado == '1') ? '0' : '1';
        $response = ModelCarrucel::ActualizarEstadoImg($id_img, $new_estado);
        if ($response) {
            return response()->json(['status' => true, 'estado' => $new_estado], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
