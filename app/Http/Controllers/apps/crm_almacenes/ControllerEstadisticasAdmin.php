<?php

namespace App\Http\Controllers\apps\crm_almacenes;

use App\Http\Controllers\Controller;
use App\Models\apps\crm_almacenes\ModelClientesCRM;
use App\Models\apps\crm_almacenes\ModelInfoAsesores;
use App\Models\apps\crm_almacenes\ModelInfoSucursales;
use App\Models\apps\crm_almacenes\ModelItemsCotizadosCrm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerEstadisticasAdmin extends Controller
{

    public function fechas(Request $request)
    {
        $asesor = $request->asesor_co;
        $fechaInicio = $request->fecha_i;
        $fechaFin = $request->fecha_f;

        $info_ase = ModelInfoAsesores::find($asesor);

        if (empty($asesor)) {
            $info_clientes = self::getInfoClientes($fechaInicio, $fechaFin, '');
            $info_presupuesto = self::getInfoPresupuesto($fechaInicio, $fechaFin, '');

            $resultados = self::getInfoProductosAdquiridos($info_presupuesto);
            $ventas_por_asesor_ciudad = self::getInfoCiudades($info_clientes);
            $ventas_medio_pago = self::getInfoMediosPago($info_clientes);
            $cotizaciones = self::getInfoCotizaciones($fechaInicio, $fechaFin, '');

            $items_cotizados = self::getInfoProductosCotizados('', $fechaInicio, $fechaFin);
        } else {
            $info_clientes = self::getInfoClientes($fechaInicio, $fechaFin, $asesor);
            $info_presupuesto = self::getInfoPresupuesto($fechaInicio, $fechaFin, $asesor);

            $resultados = self::getInfoProductosAdquiridos($info_presupuesto);
            $ventas_por_asesor_ciudad = self::getInfoCiudades($info_clientes);
            $ventas_medio_pago = self::getInfoMediosPago($info_clientes);
            $cotizaciones = self::getInfoCotizaciones($fechaInicio, $fechaFin, $asesor);

            $items_cotizados = self::getInfoProductosCotizados($info_ase->nombre, $fechaInicio, $fechaFin);
        }

        $estadisticas = view('apps.crm_almacenes.gcp.administrador.tables.tableInformeVentas', ['info' => $info_clientes, 'presupuesto' => $info_presupuesto, 'products' => $resultados, 'ciudades' => $ventas_por_asesor_ciudad, 'medios' => $ventas_medio_pago, 'cotizaciones' => $cotizaciones, 'itemsCot' => $items_cotizados])->render();
        return response()->json(['status' => true, 'estadisticas' => $estadisticas], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function index()
    {
        $fechaInicio = date("Y-m-01");
        $fechaFin = date("Y-m-d");

        $almacenes = ModelInfoSucursales::all();

        $info_clientes = self::getInfoClientes($fechaInicio, $fechaFin, '');
        $info_presupuesto = self::getInfoPresupuesto($fechaInicio, $fechaFin, '');
        $resultados = self::getInfoProductosAdquiridos($info_presupuesto);
        $ventas_por_asesor_ciudad = self::getInfoCiudades($info_clientes);
        $ventas_medio_pago = self::getInfoMediosPago($info_clientes);

        $items_cotizados = self::getInfoProductosCotizados('', $fechaInicio, $fechaFin);

        $cotizaciones = self::getInfoCotizaciones($fechaInicio, $fechaFin, '');
        $estadisticas = view('apps.crm_almacenes.gcp.administrador.tables.tableInformeVentas', ['info' => $info_clientes, 'presupuesto' => $info_presupuesto, 'products' => $resultados, 'ciudades' => $ventas_por_asesor_ciudad, 'medios' => $ventas_medio_pago, 'cotizaciones' => $cotizaciones, 'itemsCot' => $items_cotizados])->render();

        return view('apps.crm_almacenes.gcp.administrador.estadisticas', ['sucursales' => $almacenes, 'estadisticas' => $estadisticas]);
    }

    public function getInfoCotizaciones($fechaInicio, $fechaFin, $asesor)
    {
        if (empty($asesor)) {
            return ModelClientesCRM::select(['nombre_1', 'nombre_2', 'apellido_1', 'apellido_2'])
                ->whereBetween('fecha_registro', [$fechaInicio, $fechaFin])
                ->groupBy(['nombre_1', 'nombre_2', 'apellido_1', 'apellido_2'])->get();
        } else {
            return ModelClientesCRM::select(['nombre_1', 'nombre_2', 'apellido_1', 'apellido_2'])
                ->where('cedula_asesor', $asesor)
                ->whereBetween('fecha_registro', [$fechaInicio, $fechaFin])
                ->groupBy(['nombre_1', 'nombre_2', 'apellido_1', 'apellido_2'])->get();
        }
    }

    public function getInfoPresupuesto($fechaInicio, $fechaFin, $asesor)
    {
        if (empty($asesor)) {
            $info_presupuesto = ModelInfoAsesores::with([
                'presupuestoAsesor',
                'clientesEfectivos' => function ($query) use ($fechaInicio, $fechaFin) {
                    $query->with([
                        'itemsCotizados',
                        'ventasEfectivas'
                    ])->whereHas('ventasEfectivas', function ($query) use ($fechaInicio, $fechaFin) {
                        $query->whereBetween('fecha_compra', [$fechaInicio, $fechaFin]);
                    });
                }
            ])->where('cargo', 'asesor')->where('estado', '1')->get();
        } else {
            $info_presupuesto = ModelInfoAsesores::with([
                'presupuestoAsesor',
                'clientesEfectivos' => function ($query) use ($fechaInicio, $fechaFin) {
                    $query->with([
                        'itemsCotizados',
                        'ventasEfectivas'
                    ])->whereHas('ventasEfectivas', function ($query) use ($fechaInicio, $fechaFin) {
                        $query->whereBetween('fecha_compra', [$fechaInicio, $fechaFin]);
                    });
                }
            ])->where('id', $asesor)->get();
        }

        return $info_presupuesto;
    }

    public function getInfoClientes($fechaInicio, $fechaFin, $asesor)
    {
        if (empty($asesor)) {
            $info_clientes = ModelClientesCRM::with([
                'ventasEfectivas' => function ($query) use ($fechaInicio, $fechaFin) {
                    $query->whereBetween('fecha_compra', [$fechaInicio, $fechaFin]);
                },
                'itemsCotizados',
                'asesoresCRM'
            ])->whereHas('ventasEfectivas', function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha_compra', [$fechaInicio, $fechaFin]);
            })->get();
        } else {
            $info_clientes = ModelClientesCRM::with([
                'ventasEfectivas' => function ($query) use ($fechaInicio, $fechaFin) {
                    $query->whereBetween('fecha_compra', [$fechaInicio, $fechaFin]);
                },
                'itemsCotizados',
                'asesoresCRM'
            ])->whereHas('ventasEfectivas', function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha_compra', [$fechaInicio, $fechaFin]);
            })->where('cedula_asesor', $asesor)->get();
        }
        return $info_clientes;
    }

    public function getInfoMediosPago($info_clientes)
    {
        $resultados = [];

        // Iteramos sobre los clientes y sus ventas efectivas
        foreach ($info_clientes as $cliente) {
            foreach ($cliente->ventasEfectivas as $venta) {
                $nombre_asesor = $cliente->asesoresCRM[0]->nombre; // Suponiendo que "nombre" es el campo que almacena el nombre del asesor
                $medio_pago = $venta->medio_de_pago; // Suponiendo que "nombre" es el campo que almacena el tipo de pago
                $valor_venta_total = 0; // Inicializamos el valor total de la venta en 0
                foreach ($cliente->itemsCotizados as $producto) {
                    $valor_venta_total += (($producto->vlr_credito - (($producto->vlr_credito * $producto->descuento))) * $producto->cantidad);
                }
                // Verificamos si ya tenemos registrado este asesor en los resultados
                if (isset($resultados[$nombre_asesor][$medio_pago])) {
                    // Si ya está registrado, incrementamos el valor de venta y la cantidad
                    $resultados[$nombre_asesor][$medio_pago]['valor_total'] += $valor_venta_total;
                    $resultados[$nombre_asesor][$medio_pago]['cantidad'] += 1;
                } else {
                    // Si no está registrado, creamos una entrada para este asesor y tipo de pago
                    $resultados[$nombre_asesor][$medio_pago] = [
                        'asesor' => $nombre_asesor,
                        'pago' => $medio_pago,
                        'cantidad' => 1,
                        'valor_total' => $valor_venta_total
                    ];
                }
            }
        }
        return $resultados;
    }

    public function getInfoProductosAdquiridos($info_presupuesto)
    {
        $resultados = [];

        foreach ($info_presupuesto as $info) {
            $asesor = $info->nombre;
            foreach ($info->clientesEfectivos as $cliente) {
                foreach ($cliente->itemsCotizados as $item) {
                    // Verificar si ya existe el item para este asesor en los resultados
                    if (array_key_exists($asesor, $resultados) && array_key_exists($item->sku, $resultados[$asesor])) {
                        // Si existe, aumentar la cantidad
                        $resultados[$asesor][$item->sku]['cantidad']++;
                        $resultados[$asesor][$item->sku]['valor'] += (($item->vlr_credito - (($item->vlr_credito * $item->descuento))) * $item->cantidad);
                    } else {
                        // Si no existe, agregarlo con cantidad 1
                        $resultados[$asesor][$item->sku] = [
                            'asesor' => $asesor,
                            'sku' => $item->sku,
                            'item' => $item->producto,
                            'cantidad' => 1,
                            'valor' => (($item->vlr_credito - (($item->vlr_credito * $item->descuento))) * $item->cantidad)
                        ];
                    }
                }
            }
        }
        return $resultados;
    }

    public function getInfoCiudades($info_clientes)
    {
        $ventas_por_asesor_ciudad = [];

        foreach ($info_clientes as $cliente) {
            $asesor_nombre = $cliente->asesoresCRM[0]->nombre;
            $ciudad = $cliente->ciudad;
            $total_venta_cliente = 0;

            foreach ($cliente->itemsCotizados as $producto) {
                // Sumar el valor de cada producto vendido
                $total_venta_cliente += (($producto->vlr_credito - (($producto->vlr_credito * $producto->descuento))) * $producto->cantidad);
            }

            if (!isset($ventas_por_asesor_ciudad[$asesor_nombre][$ciudad])) {
                // Si no existe una entrada para el asesor en la ciudad actual, la inicializamos
                $ventas_por_asesor_ciudad[$asesor_nombre][$ciudad] = [
                    'asesor' => $asesor_nombre,
                    'ciudad' => $ciudad,
                    'cantidad_ventas' => 1, // Empezamos con una venta
                    'total_venta' => $total_venta_cliente,
                ];
            } else {
                // Si ya existe una entrada para el asesor en la ciudad actual, actualizamos los valores
                $ventas_por_asesor_ciudad[$asesor_nombre][$ciudad]['total_venta'] += $total_venta_cliente;
                $ventas_por_asesor_ciudad[$asesor_nombre][$ciudad]['cantidad_ventas']++;
            }
        }

        return $ventas_por_asesor_ciudad;
    }

    public function getInfoProductosCotizados($asesor, $fecha_i, $fecha_f)
    {
        if (empty($asesor)) {
            $data = ModelItemsCotizadosCrm::join('users as u', 'u.nombre', '=', 'cotizaciones.asesor')
                ->select(['asesor', 'sku', 'producto', DB::raw('COUNT(sku) as cantidad')])
                ->where('u.cargo', 'asesor')
                ->whereBetween('cotizaciones.fecha', [$fecha_i, $fecha_f])
                ->groupBy('asesor', 'sku', 'producto')
                ->orderBy('asesor')
                ->orderByDesc('cantidad')
                ->get();
        } else {
            $data = ModelItemsCotizadosCrm::join('users as u', 'u.nombre', '=', 'cotizaciones.asesor')
                ->select(['asesor', 'sku', 'producto', DB::raw('COUNT(sku) as cantidad')])
                ->where('u.cargo', 'asesor')
                ->where('u.nombre', $asesor)
                ->whereBetween('cotizaciones.fecha', [$fecha_i, $fecha_f])
                ->groupBy('asesor', 'sku', 'producto')
                ->orderBy('asesor')
                ->orderByDesc('cantidad')
                ->get();
        }

        $data_info = [];

        foreach ($data as $value) {
            $nombre = $value->asesor;

            if (!isset($data_info[$nombre])) {
                $data_info[$nombre] = [];
            }

            if (count($data_info[$nombre]) < 10) {
                $data_info[$nombre][] = [
                    'asesor' => $value->asesor,
                    'sku' => $value->sku,
                    'item' => $value->producto,
                    'cantidad' => $value->cantidad
                ];
            }
        }
        return $data_info;
    }
}
