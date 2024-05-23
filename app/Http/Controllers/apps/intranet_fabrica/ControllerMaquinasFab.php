<?php

namespace App\Http\Controllers\apps\intranet_fabrica;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet_fabrica\ModelMaquinasFabrica;
use App\Models\apps\intranet_fabrica\orm\ModelHvMaquinas;
use App\Models\apps\intranet_fabrica\orm\ModelMaquinasFab;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ControllerMaquinasFab extends Controller
{
    public function MaquinasFabrica()
    {
        $maquinas = ModelMaquinasFab::all();
        return view('apps.intranet_fabrica.fabrica.usuarios.maquinas.maquinas', ['maquinas' => $maquinas]);
    }

    public function AgregarMaquinasFabrica()
    {
        return view('apps.intranet_fabrica.fabrica.usuarios.maquinas.agregar_referencia');
    }

    public function RegistarNuevaMaquinaFab(Request $request)
    {
        if ($request->hasFile('fileMaquina')) {
            $archivo = $request->file('fileMaquina');
            $data = Excel::toArray([], $archivo);
            $datos = $data[0];

            foreach ($datos as $key => $value) {
                if (strtolower($value[0]) != 'referencia' && !empty($value[0])) {
                    $referencia = $value[0];
                    $nombre_maquina = $value[1];

                    $response = ModelMaquinasFab::create([
                        'referencia' => trim($referencia),
                        'nombre_maquina' => trim($nombre_maquina)
                    ]);

                    if ($response) {
                        ModelHvMaquinas::create([
                            'referencia' => trim($referencia),
                            'nombre_maquina' => trim($nombre_maquina)
                        ]);
                    }
                }
            }
            return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        } else {
            if (!empty($request->referencia) && !empty($request->nombre_maquina)) {

                $response = ModelMaquinasFab::create([
                    'referencia' => trim($request->referencia),
                    'nombre_maquina' => trim($request->nombre_maquina)
                ]);

                if ($response) {
                    ModelHvMaquinas::create([
                        'referencia' => trim($request->referencia),
                        'nombre_maquina' => trim($request->nombre_maquina)
                    ]);
                    return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                }
            }
        }
    }

    public function EliminarRefMaquinaFabrica(Request $request)
    {
        $maquina = ModelMaquinasFab::find($request->id_maquina);
        $maquina->delete();
        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
