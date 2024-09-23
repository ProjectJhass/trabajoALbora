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

    public function cargar_informacion_clientes($tipo_cliente, $asesor, $almacen, $fecha_i, $fecha_f)
    {
        $export = ModelClientesCRM::select(
            'id_cliente',
            'cedula_cliente',
            DB::raw('CONCAT(nombre_1, " " , nombre_2) as nombres'),
            DB::raw('CONCAT(apellido_1, " ",apellido_2) as apellidos'),
            'ciudad',
            'barrio',
            'direccion',
            'email',
            'celular_1',
            'celular_2',
            'fecha_registro',
            'tipo_cliente',
            'clientes_crm.estado',
            'co.nombre as asesor',
            'co.sucursal'
        )
            ->join('users as co', 'cedula_asesor', '=', 'co.id');
        if (!empty($tipo_cliente) && $tipo_cliente < 5) {
            $export->where('tipo_cliente', $tipo_cliente);
        } else if (!empty($tipo_cliente) && $tipo_cliente >= 5) {
            $export->where('clientes_crm.estado', $tipo_cliente);
        }
        if (!empty($asesor)) {
            $export->where('cedula_asesor', $asesor);
        }

        if (!empty($almacen)) {
            $export->where('co.sucursal', $almacen);
        }
        if (!empty($fecha_i) && !empty($fecha_f)) {
            $export->whereBetween('fecha_registro', [$fecha_i, $fecha_f]);
        } elseif (!empty($fecha_i)) {
            $export->where('fecha_registro', '>=', $fecha_i);
        } elseif (!empty($fecha_f)) {
            $export->where('fecha_registro', '<=', $fecha_f);
        }
        $response = $export->get();
        $tipos_cliente_1 = [
            0 => 'Eliminar',
            1 => 'Oportunidad',
            2 => 'Prospecto',
            3 => 'Efectivo',
            4 => 'Eliminar'
        ];
        $tipos_cliente_2 = [
            5 => 'Preferencial',
            6 => 'Pre Aprobado'
        ];
        $response = $response->map(function ($item) use ($tipos_cliente_1) {
            $item->tipo_cliente = $tipos_cliente_1[$item->tipo_cliente] ?? '';
            return $item;
        });
        $response = $response->map(function ($item) use ($tipos_cliente_2) {
            $item->estado = $tipos_cliente_2[$item->estado] ?? '';
            return $item;
        });
        return $response;
    }

    public function cargar_informacion_llamadas($estado, $asesor, $almacen, $fecha_i, $fecha_f)
    {

        $export = DB::connection('albura_cotizador')->table('llamadas_a_realizar as llar')
            ->join('clientes_crm as cc', 'llar.id_cliente', '=', 'cc.id_cliente')
            ->join('users as co', 'cc.cedula_asesor', '=', 'co.id');

        if (!empty($almacen)) {
            $export->where('co.sucursal', $almacen);
        }

        if (!empty($asesor)) {
            $export->where('cc.cedula_asesor', $asesor);
        }

        if (!empty($fecha_i) && !empty($fecha_f)) {
            $export->whereBetween('llar.fecha_a_llamar', [$fecha_i, $fecha_f]);
        } elseif (!empty($fecha_i)) {
            $export->where('llar.fecha_a_llamar', '>=', $fecha_i);
        } elseif (!empty($fecha_f)) {
            $export->where('llar.fecha_a_llamar', '<=', $fecha_f);
        }
        $export->where('llar.estado', $estado);
        return $export->get();
    }

    public function cargar_informacion_items($asesor, $almacen, $fecha_i, $fecha_f)
    {
        $export = ModelItemsCotizadosCrm::select(
            'idsession',
            'sku',
            'producto',
            'vlr_credito',
            'dsto_adicional',
            'plan',
            'descuento',
            'asesor',
            'fecha',
            'cotizaciones.sucursal'
        )->join('users as co', 'asesor', '=', 'co.nombre');


        if (!empty($asesor)) {
            $export->where('co.id', $asesor);
        }

        if (!empty($almacen)) {
            $export->where('co.sucursal', $almacen);
        }
        if (!empty($fecha_i) && !empty($fecha_f)) {
            $export->whereBetween('fecha', [$fecha_i, $fecha_f]);
        } elseif (!empty($fecha_i)) {
            $export->where('fecha', '>=', $fecha_i);
        } elseif (!empty($fecha_f)) {
            $export->where('fecha', '<=', $fecha_f);
        }
        return $export->get();
    }

    public function cargar_informacion_cotizaciones($asesor, $almacen, $fecha_i, $fecha_f)
    {
        $export = DB::connection('albura_cotizador')->table('clientes_crm as cc')
            ->join('users as co', 'cc.cedula_asesor', '=', 'co.id');

        if (!empty($almacen)) {
            $export->where('co.sucursal', $almacen);
        }

        if (!empty($asesor)) {
            $export->where('cc.cedula_asesor', $asesor);
        }

        if (!empty($fecha_i) && !empty($fecha_f)) {
            $export->whereBetween('cc.fecha_registro', [$fecha_i, $fecha_f]);
        } elseif (!empty($fecha_i)) {
            $export->where('cc.fecha_registro', '>=', $fecha_i);
        } elseif (!empty($fecha_f)) {
            $export->where('cc.fecha_registro', '<=', $fecha_f);
        }

        return $export->get();
    }

    public function cargar_informacion_tabla(Request $request)
    {
        $fecha_i = $request->fecha_i ?? "";
        $fecha_f = $request->fecha_f ?? "";
        $almacen = $request->almacen ?? "";
        $asesor = $request->asesor ?? "";

        if (!empty($almacen) && !empty($asesor)) {

            $cotizaciones_realizadas = count(self::cargar_informacion_cotizaciones($asesor, $almacen, $fecha_i, $fecha_f));
            $clientes_oportunidad = count(self::cargar_informacion_clientes(1, $asesor, $almacen, $fecha_i, $fecha_f));
            $clientes_prospectos = count(self::cargar_informacion_clientes(2, $asesor, $almacen, $fecha_i, $fecha_f));
            $clientes_efectivos = count(self::cargar_informacion_clientes(3, $asesor, $almacen, $fecha_i, $fecha_f));
            $llamadas_realizadas = count(self::cargar_informacion_llamadas('REALIZADA', $asesor, $almacen, $fecha_i, $fecha_f));
            $llamadas_pendientes = count(self::cargar_informacion_llamadas('PENDIENTE', $asesor, $almacen, $fecha_i, $fecha_f));
            $items_cotizados = count(self::cargar_informacion_items($asesor, $almacen, $fecha_i, $fecha_f));

            $view_table_totalizada = view(
                'apps.crm_almacenes.gcp.administrador.tables.tableTotalesInformeAsesor',
                [
                    'cotizaciones_realizadas' => $cotizaciones_realizadas,
                    'clientes_oportunidad' => $clientes_oportunidad,
                    'clientes_prospectos' => $clientes_prospectos,
                    'clientes_efectivos' => $clientes_efectivos,
                    'llamadas_realizadas' => $llamadas_realizadas,
                    'llamadas_pendientes' => $llamadas_pendientes,
                    'items_cotizados' => $items_cotizados
                ]
            )->render();

            return response()->json(
                [
                    "status" => true,
                    "message" => "Información cargada con exito",
                    "view_table_" => $view_table_totalizada,
                    'clientes_oportunidad' => $clientes_oportunidad,
                    'clientes_prospectos' => $clientes_prospectos,
                    'clientes_efectivos' => $clientes_efectivos,
                    'llamadas_realizadas' => $llamadas_realizadas,
                    'llamadas_pendientes' => $llamadas_pendientes,
                    'items_cotizados' => $items_cotizados,
                    'cotizaciones_realizadas' => $cotizaciones_realizadas
                ],
                200
            );
        } else {
            return response()->json(["status" => false, "message" => "Falta de parametros para continuar con la solicitud!"], 400);
        }
    }
}
