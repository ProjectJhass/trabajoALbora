<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios;

use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\servicios\ModelConductores;
use App\Models\apps\servicios_tecnicos\servicios\ModelVehiculos;
use Illuminate\Http\Request;

class ControllerAdmin extends Controller
{
    public function table($option, $info)
    {
        switch ($option) {
            case 'c':
                return view('apps.servicios_tecnicos.servicios_tecnicos.admin.table_c', ['info' => $info])->render();
                break;
            case 'v':
                return view('apps.servicios_tecnicos.servicios_tecnicos.admin.table_v', ['info' => $info])->render();
                break;
        }
    }

    public function home()
    {
        $vehiculos = self::table('v', ModelVehiculos::all());
        $conductores = self::table('c', ModelConductores::all());

        return view('apps.servicios_tecnicos.servicios_tecnicos.admin.conductores', ['vehiculos' => $vehiculos, 'conductores' => $conductores]);
    }

    public function createInfo(Request $request)
    {
        $option = $request->option;
        switch ($option) {
            case 'v':
                $response = ModelVehiculos::create([
                    'placa' => $request->input1,
                    'modelo' => $request->input2,
                    'estado' => 'Activo'
                ]);
                if ($response) {
                    $table = self::table('v', ModelVehiculos::all());
                }
                break;
            case 'c':
                $response = ModelConductores::create([
                    'nombre' => $request->input1,
                    'celular' => $request->input2,
                    'estado' => 'Activo'
                ]);
                if ($response) {
                    $table = self::table('c', ModelConductores::all());
                }
                break;
        }

        return response()->json(['table' => $table, 'seccion' => $option], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
