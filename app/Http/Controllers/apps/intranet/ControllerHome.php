<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelHome;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ControllerHome extends Controller
{
    
    public function index()
    {
        session()->forget(['centro_operacion', 'fecha_i_ingresos', 'fecha_f_ingresos']);

        if (session('idFraseFilosofo') != '') {
            $id = session('idFraseFilosofo');
        } else {
            session(['idFraseFilosofo' => rand(1, 52)]);
            $id = session('idFraseFilosofo');
        }

        $frase = ModelHome::FraseDelDia($id);
        $imagenes = ModelHome::ImagenesCarrucel();
        $numeros = ModelHome::NumerosContacto();

        return view('apps.intranet.home', ['frase' => $frase, 'imagenes' => $imagenes, 'numeros' => $numeros]);
    }

    public function editar()
    {
        $imagenes = ModelHome::ImagenesCarrucel();
        $numeros = ModelHome::NumerosContacto();

        return view('apps.intranet.edit_home', ['imagenes' => $imagenes, 'numeros' => $numeros]);
    }

    public function cargar(Request $request)
    {
        if ($request->has('img')) {
            if ($request->hasFile('imagen_carrucel')) {

                $documentos =  $request->file('imagen_carrucel');

                foreach ($documentos as $key => $value) {

                    $nombre = $value->getClientOriginalName();
                    $tipo = $value->getClientOriginalExtension();

                    $nombre_doc = str_replace('.' . $tipo, '', $nombre);
                    $nombre_cargue = uniqid() . "_" . $nombre;

                    $response_file = $value->storeAs('public/carrusel/', $nombre_cargue);
                    $url_doc = Storage::url("carrusel/" . $nombre_cargue);

                    if ($response_file) {
                        $data = ([
                            'nombre_imagen' => $nombre_doc,
                            'url_imagen' => $url_doc,
                            'tipo' => $tipo,
                            'orden' => '1',
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                        ModelHome::AgregarDocumentosCarrusel($data);
                    }
                }
            }
        }
        if ($request->has('cel')) {
            $data = ([
                'nombre_propietario' => $request->nombre_u,
                'numero_celular' => $request->numero_cel,
                'co' => '020',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            ModelHome::AgregarNuevosNumeros($data);
        }

        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function eliminar(Request $request)
    {
        switch ($request->valor) {
            case 'n':
                ModelHome::EliminarValorNumeroContacto($request->id);
                break;
            case 'c':
                ModelHome::EliminarImagenCarrucel($request->id);
                break;
        }
        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function actualizar(Request $request)
    {
        $data = ([
            'orden' => !empty($request->valor) ? $request->valor : '999',
            'updated_at' => Carbon::now()
        ]);
        ModelHome::ActualizarCarrucel($request->id, $data);
        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
