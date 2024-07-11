<?php

namespace App\Http\Controllers\apps\crm_almacenes;

use App\Exports\ExportClientesCRM;
use App\Exports\ExportCotizacionesCRM;
use App\Exports\ExportLlamadasCRM;
use App\Http\Controllers\Controller;
use App\Models\apps\crm_almacenes\ModelClientesCRM;
use App\Models\apps\crm_almacenes\ModelInfoAsesores;
use App\Models\apps\crm_almacenes\ModelInfoDepartamentos;
use App\Models\apps\crm_almacenes\ModelInfoLlamadasPendientes;
use App\Models\apps\crm_almacenes\ModelInfoSucursales;
use App\Models\apps\crm_almacenes\ModelItemsCotizadosCrm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ControllerExportarInfoCRM extends Controller
{
    public function index()
    {
        $almacenes = ModelInfoSucursales::all();
        $dptos = ModelInfoDepartamentos::all();
        $fecha_i = '';
        $fecha_f = '';
        $almacen = '';
        $asesor = '';
        $informacion = view('apps.crm_almacenes.gcp.exportar.informacion', ['fecha_i' => $fecha_i, 'fecha_f' => $fecha_f, 'almacen' => $almacen, 'asesor' => $asesor]);
        return view('apps.crm_almacenes.gcp.exportar.home', ['sucursales' => $almacenes, 'deptos' => $dptos, 'informacion' => $informacion])->render();
    }
    public function filtrarInfo(Request $request)
    {
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $almacen = $request->almacen;
        $asesor = $request->asesor;
        $informacion = view('apps.crm_almacenes.gcp.exportar.informacion', ['fecha_i' => $fecha_i, 'fecha_f' => $fecha_f, 'almacen' => $almacen, 'asesor' => $asesor])->render();
        return response()->json(['informacion' => $informacion]);
    }
    public function exportarClientes(Request $request)
    {
        $tipo_cliente = $request->tipo_cliente;
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $almacen = $request->almacen;
        $asesor = $request->asesor;

        switch ($tipo_cliente) {
            case 1:
                $nombre_archivo = 'clientes-oportunidad-crm.xlsx';
                break;
            case 2:
                $nombre_archivo = 'clientes-prospectos-crm.xlsx';
                break;
            case 3:
                $nombre_archivo = 'clientes-efectivos-crm.xlsx';
                break;
            default:
                $nombre_archivo = 'informe-general-crm.xlsx';
                break;
        }
        return Excel::download(new ExportClientesCRM($tipo_cliente, $fecha_i, $fecha_f, $almacen, $asesor), $nombre_archivo);
    }
    public function exportarLlamadas(Request $request)
    {
        $estado_llamada = $request->estado;
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $almacen = $request->almacen;
        $asesor = $request->asesor;
        $estado_llamada == 'REALIZADA' ? $nombre_archivo = 'llamadas-realizadas-crm.xlsx' : $nombre_archivo = 'llamadas-pendientes-crm.xlsx';
        return Excel::download(new ExportLlamadasCRM($estado_llamada, $fecha_i, $fecha_f, $almacen, $asesor), $nombre_archivo);
    }
    public function exportarCotizaciones(Request $request)
    {
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $almacen = $request->almacen;
        $asesor = $request->asesor;
        return Excel::download(new ExportCotizacionesCRM($fecha_i, $fecha_f, $almacen, $asesor), 'cotizaciones-crm.xlsx');
    }
}
