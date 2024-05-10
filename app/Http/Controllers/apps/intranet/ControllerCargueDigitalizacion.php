<?php

namespace App\Http\Controllers\apps\intranet;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelInfoClientesDigitalizacion;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ControllerCargueDigitalizacion extends Controller
{
    public function index()
    {
        return view("apps.intranet.cartera.upload");
    }

    public function getInfoExcel(Request $request)
    {
        if ($request->hasFile('archivo_excel')) {
            $archivo = $request->file('archivo_excel');
            $data = Excel::toArray([], $archivo);
            $datos = $data[0];
            $table = view("apps.intranet.cartera.table", ["info" => $datos])->render();
        } else {
            $table = '';
        }
        return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function uploadInfo(Request $request)
    {
        if ($request->hasFile('archivo_excel')) {
            $archivo = $request->file('archivo_excel');
            $data = Excel::toArray([], $archivo);
            $datos = $data[0];

            foreach ($datos as $key => $value) {
                if (strtolower($value[0]) != 'cedula' && !empty($value[0])) {
                    $cedula = $value[0];
                    $nombre = $value[1];
                    $factura = $value[2];
                    $almacen = $value[3];
                    $obs = $value[4];

                    ModelInfoClientesDigitalizacion::create([
                        'cedula_cliente' => $cedula,
                        'nombre_cliente' => $nombre,
                        'cuenta_cliente' => $factura,
                        'almacen_cliente' => $almacen,
                        'observaciones' => $obs,
                    ]);
                }
            }
            return response()->json(['status' => true, 'table' => '', 'mensaje' => 'BIEN! Información cargada exitosamente'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        } else {
            return response()->json(['status' => false, 'table' => '', 'mensaje' => 'ERROR! Debes agregar un archivo .xlsx'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
