<?php

namespace App\Http\Controllers\apps\automoviles;

use App\Http\Controllers\Controller;
use App\Models\apps\automoviles\ModelKmRecorridos;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_IOFactory;

class ControllerAdminInfo extends Controller
{
    public function index()
    {
        $info = ModelKmRecorridos::all();
        return view("apps.automoviles.admin.cargueKm", ["info" => $info]);
    }

    public function importar(Request $request)
    {
        $request->validate([
            'archivo_excel' => 'required|mimes:xlsx,xls',
            'fecha_' => 'required'
        ]);
        $archivo = $request->file('archivo_excel');
        // Leer el archivo Excel
        $data = Excel::toArray([], $archivo);
        // Obtener los datos del primer hoja
        $datos = $data[0];
        // Procesar los datos según sea necesario
        foreach ($datos as $fila) {
            $placa = $fila[0];
            $kilometros = str_replace(",", ".", $fila[1]);
            if (strtolower($placa) != "placa" && !empty($placa)) {
                ModelKmRecorridos::create([
                    'placa' => $placa,
                    'km_recorridos' => $kilometros,
                    'fecha' => $request->fecha_
                ]);
            }
        }
        return redirect()->back()->with('success', 'Archivo Excel importado exitosamente.');
    }
}
