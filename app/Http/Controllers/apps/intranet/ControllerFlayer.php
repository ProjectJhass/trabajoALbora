<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelFlayer;
use App\Models\apps\intranet\ModelInfoFlayer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ControllerFlayer extends Controller
{
    public function index()
    {
        return view('apps.intranet.sagrilaft.home');
    }
    public function home()
    {
        $fecha = date('Y-m');
        $img = ModelFlayer::where('imagen', $fecha)->first();
        $info = self::infoFlayer(date('m'));
        return view('apps.intranet.sagrilaft.ptee_sagrilaft', ['img' => $img, 'cantidad' => $info[0], 'table' => $info[1]]);
    }

    public function infoFlayer($month)
    {
        $cantidad = ModelInfoFlayer::whereMonth('created_at', $month)->count();
        $usuarios = ModelInfoFlayer::select(['id', 'cedula', 'nombre', 'fecha', 'id_estado', 'estado'])->whereMonth('created_at', $month)->get();
        $table = view('apps.intranet.sagrilaft.table_flayer', ['usuarios' => $usuarios])->render();

        return ([$cantidad, $table]);
    }

    public function searchInfoFlayer(Request $request)
    {
        $fecha = $request->fecha;
        $month = date("m", strtotime($fecha));
        $imgObject = ModelFlayer::where('imagen', $fecha)->first();
        $info = self::infoFlayer($month);
        if($imgObject){
            $img = '<a href="' . asset($imgObject->url) . '" target="_BLANK"><img src="' . asset($imgObject->url) . '" width="100%" alt=""></a>';
        }else{
            $img = "";
        }
        return response()->json(['status' => true, 'img' => $img, 'cantidad' => $info[0], 'table' => $info[1]], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function updateImgFlayer(Request $request)
    {
        if ($request->hasFile('imgPrevFlayer')) {

            $flayer =  $request->file('imgPrevFlayer');

            // $original_nombre = $flayer->getClientOriginalName();
            $tipo = $flayer->getClientOriginalExtension();
            $nombre = $request->fecha; // El nombre será el Año y mes del flayer
            $response_file = $flayer->storeAs('public/flayer/', $nombre . '.' . $tipo);
            $url_doc = Storage::url("flayer/" . $nombre . '.' . $tipo);
            if ($response_file) {
                $exist = ModelFlayer::where('imagen', $nombre)->first();
                if ($exist) {
                    $response = $exist->update([
                        'imagen'=>$nombre
                    ]);
                } else {
                    $response = ModelFlayer::create([
                        'imagen' => $nombre,
                        'url' => $url_doc,
                        'tipo' => $tipo,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
                if ($response) {
                    $img = '<a href="' . asset($url_doc) . '" target="_BLANK"><img src="' . asset($url_doc) . '" width="100%" alt=""></a>';
                    return response()->json(['status' => true, 'img' => $img], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                }
            }
        }
    }
}
