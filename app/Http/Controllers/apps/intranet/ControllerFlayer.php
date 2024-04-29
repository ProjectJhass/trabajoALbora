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
    public function home()
    {
        $img = ModelFlayer::all();
        $info = self::infoFlayer(date('m'));
        return view('apps.intranet.rrhh.ptee_sagrilaft', ['img' => $img, 'cantidad' => $info[0], 'table' => $info[1]]);
    }

    public function infoFlayer($month)
    {
        $cantidad = ModelInfoFlayer::whereMonth('created_at', $month)->count();
        $usuarios = ModelInfoFlayer::select(['id', 'cedula', 'nombre', 'fecha', 'id_estado','estado'])->whereMonth('created_at', $month)->get();
        $table = view('apps.intranet.rrhh.table_flayer', ['usuarios' => $usuarios])->render();

        return ([$cantidad, $table]);
    }

    public function searchInfoFlayer(Request $request)
    {
        $fecha = $request->fecha;
        $month = date("m", strtotime($fecha));

        $info = self::infoFlayer($month);

        return response()->json(['status' => true, 'cantidad' => $info[0], 'table' => $info[1]], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function updateImgFlayer(Request $request)
    {
        if ($request->hasFile('imgPrevFlayer')) {

            $flayer =  $request->file('imgPrevFlayer');

            $nombre = $flayer->getClientOriginalName();
            $tipo = $flayer->getClientOriginalExtension();

            $response_file = $flayer->storeAs('public/flayer/', $nombre);

            $url_doc = Storage::url("flayer/" . $nombre);

            if ($response_file) {

                ModelFlayer::truncate();

                $response = ModelFlayer::create([
                    'imagen' => $nombre,
                    'url' => $url_doc,
                    'tipo' => $tipo,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                if ($response) {
                    $img = '<a href="' . asset($url_doc) . '" target="_BLANK"><img src="' . asset($url_doc) . '" width="100%" alt=""></a>';
                    return response()->json(['status' => true, 'img' => $img], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                }
            }
        }
    }
}
