<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\cotizador\ModelDepartamentos;
use App\Models\apps\intranet\ModelCalendar;
use App\Models\apps\intranet\ModelEventosDominicales;
use App\Models\apps\intranet\ModelFirmasDescansosCompensatorios;
use App\Models\apps\servicios_tecnicos\servicios\infoAlmacenes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ControllerCalendar extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $eventos = ModelCalendar::eventos($id);
        $deptos = ModelDepartamentos::all();
        $almacen = infoAlmacenes::where('estado', '1')->get();
        return view('apps.intranet.ingresos.asesor.calendario', ['eventos' => $eventos, 'deptos' => $deptos, 'almacen' => $almacen]);
    }

    public function searchEvento()
    {
        $asesor = Auth::user()->id;
        $dominical_ = '<option value="">Seleccionar...</option>';
        $descansos_ = '<option value="">Seleccionar...</option>';
        $dominicales = ModelEventosDominicales::where("cedula_evento", $asesor)->where("tipo_evento", "2")->whereNull("firmar")->get();
        $descansos = ModelEventosDominicales::where("cedula_evento", $asesor)->where("tipo_evento", "1")->whereNull("firmar")->get();
        foreach ($dominicales as $key => $value) {
            $dominical_ .= '<option value="' . $value->id_evento . '" data-fecha="' . $value->fecha_i . '">' . $value->fecha_i . '</option>';
        }
        foreach ($descansos as $key => $val) {
            $descansos_ .= '<option value="' . $val->id_evento . '" data-fecha="' . $val->fecha_i . '">' . $val->fecha_i . '</option>';
        }

        return response()->json(['status' => true, 'dominicales' => $dominical_, 'descansos' => $descansos_], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function saveInfoFotoDescanso()
    {
        $datos = file_get_contents("php://input");
        if (strlen($datos) <= 0) {
            return response()->json(['status' => false], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
        $imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", urldecode($datos));
        $imagenDecodificada = base64_decode($imagenCodificadaLimpia);
        $nombreImagenGuardada = uniqid() . "_" . Auth::user()->nombre . ".png";
        Storage::put('public/firmas-descansos/' . $nombreImagenGuardada, $imagenDecodificada);
        $url_doc = Storage::url("firmas-descansos/" . $nombreImagenGuardada);
        return response()->json(['status' => true, 'name' => base64_encode($nombreImagenGuardada), 'url' => base64_encode($url_doc)], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function saveFormFirmaDescanso(Request $request)
    {
        $cedula = Auth::user()->id;
        $nombre = Auth::user()->nombre;
        $departamento = $request->depto;
        $ciudad = $request->ciudad;
        $almacen = $request->almacen;
        $id_dominical = $request->dominical_laborado;
        $id_descanso = $request->dia_compensado;
        $foto = base64_decode($request->img);
        $url_foto = base64_decode($request->url);
        $tipo = 'png';
        $ip = $_SERVER['REMOTE_ADDR'];
        $hash = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
        $observaciones = $request->observaciones;

        if (!empty($departamento) && !empty($ciudad) && !empty($almacen)) {
            $info_dominical = ModelEventosDominicales::find($id_dominical);
            $info_descanso = ModelEventosDominicales::find($id_descanso);
            if ($info_dominical) {
                $fecha_dominical = $info_dominical->fecha_i;
                $info_dominical->firmar = "firmado";
                $info_dominical->save();
            } else {
                $fecha_dominical = null;
            }
            if ($info_descanso) {
                $fecha_descanso = $info_descanso->fecha_i;
                $info_descanso->firmar = "firmado";
                $info_descanso->save();
            } else {
                $fecha_descanso = null;
            }

            ModelFirmasDescansosCompensatorios::create([
                'nombre' => $nombre,
                'cedula' => $cedula,
                'ciudad' => $ciudad,
                'depto' => $departamento,
                'almacen' => $almacen,
                'dominical_laborado' => $fecha_dominical,
                'dia_compensatorio' => $fecha_descanso,
                'nombre_firma' => $foto,
                'url_firma' => $url_foto,
                'tipo_firma' => $tipo,
                'ip_firma' => $ip,
                'hash_firma' => $hash,
                'observaciones' => $observaciones
            ]);

            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        } else {
            $url_ = str_replace("/storage/", "", "public/" . $url_foto);
            Storage::delete($url_);

            return response()->json(['status' => false], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
