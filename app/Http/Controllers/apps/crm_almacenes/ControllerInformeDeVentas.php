<?php

namespace App\Http\Controllers\apps\crm_almacenes;

use App\Http\Controllers\Controller;
use App\Models\apps\crm_almacenes\ModelClientesCRM;
use App\Models\apps\crm_almacenes\ModelInfoAsesores;
use App\Models\apps\crm_almacenes\ModelItemsCotizadosCrm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ControllerInformeDeVentas extends Controller
{
    public function fechas(Request $request)
    {
        $asesor = Auth::user()->id;
        $fechaInicio = $request->fecha_i;
        $fechaFin = $request->fecha_f;

        $info_clientes = self::getInfoClientes($fechaInicio, $fechaFin, $asesor);
        $info_presupuesto = self::getInfoPresupuesto($fechaInicio, $fechaFin, $asesor);

        $resultados = self::getInfoProductosAdquiridos($info_presupuesto);
        $ventas_por_asesor_ciudad = self::getInfoCiudades($info_clientes);
        $ventas_medio_pago = self::getInfoMediosPago($info_clientes);
        $cotizaciones = self::getInfoCotizaciones($fechaInicio, $fechaFin, $asesor);
        $items_cotizados_al = self::getInfoProductosCotizadosAl(Auth::user()->nombre, $fechaInicio, $fechaFin);
        $items_cotizados = self::getInfoProductosCotizados(Auth::user()->nombre, $fechaInicio, $fechaFin);
        $items_cotizados_referencia  = self::getInfoProductosCotizadosPorReferencia(Auth::user()->nombre, $fechaInicio, $fechaFin);
        $estadisticas = view('apps.crm_almacenes.gcp.administrador.tables.tableInformeVentas', ['info' => $info_clientes, 'presupuesto' => $info_presupuesto, 'products' => $resultados, 'ciudades' => $ventas_por_asesor_ciudad, 'medios' => $ventas_medio_pago, 'cotizaciones' => $cotizaciones, 'itemsCot' => $items_cotizados, 'itemsCotAl' => $items_cotizados_al, 'itemsRef' => $items_cotizados_referencia])->render();
        return response()->json(['status' => true, 'estadisticas' => $estadisticas], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function index()
    {
        $fechaInicio = date("Y-m-01");
        $fechaFin = date("Y-m-d");

        $asesor = Auth::user()->id;

        $info_clientes = self::getInfoClientes($fechaInicio, $fechaFin, $asesor);
        $info_presupuesto = self::getInfoPresupuesto($fechaInicio, $fechaFin, $asesor);

        $resultados = self::getInfoProductosAdquiridos($info_presupuesto);
        $ventas_por_asesor_ciudad = self::getInfoCiudades($info_clientes);
        $ventas_medio_pago = self::getInfoMediosPago($info_clientes);
        $items_cotizados_al = self::getInfoProductosCotizadosAl(Auth::user()->nombre, $fechaInicio, $fechaFin);
        $items_cotizados = self::getInfoProductosCotizados(Auth::user()->nombre, $fechaInicio, $fechaFin);
        $items_cotizados_referencia  = self::getInfoProductosCotizadosPorReferencia($asesor, $fechaInicio, $fechaFin);
        $cotizaciones = self::getInfoCotizaciones($fechaInicio, $fechaFin, $asesor);
        $estadisticas = view('apps.crm_almacenes.gcp.administrador.tables.tableInformeVentas', ['info' => $info_clientes, 'presupuesto' => $info_presupuesto, 'products' => $resultados, 'ciudades' => $ventas_por_asesor_ciudad, 'medios' => $ventas_medio_pago, 'cotizaciones' => $cotizaciones, 'itemsCot' => $items_cotizados, 'itemsCotAl' => $items_cotizados_al, 'itemsRef' => $items_cotizados_referencia])->render();

        return view('apps.crm_almacenes.gcp.asesor.estadisticas', ['estadisticas' => $estadisticas]);
    }

    public function getInfoCotizaciones($fechaInicio, $fechaFin, $asesor)
    {
        return ModelClientesCRM::select(['nombre_1', 'nombre_2', 'apellido_1', 'apellido_2'])
            ->where('cedula_asesor', $asesor)
            ->whereBetween('fecha_registro', [$fechaInicio, $fechaFin])
            ->groupBy(['nombre_1', 'nombre_2', 'apellido_1', 'apellido_2'])->get();
    }

    public function getInfoPresupuesto($fechaInicio, $fechaFin, $asesor)
    {
        return  ModelInfoAsesores::with([
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

    public function getInfoClientes($fechaInicio, $fechaFin, $asesor)
    {
        return ModelClientesCRM::with([
            'ventasEfectivas' => function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha_compra', [$fechaInicio, $fechaFin]);
            },
            'itemsCotizados',
            'asesoresCRM'
        ])->whereHas('ventasEfectivas', function ($query) use ($fechaInicio, $fechaFin) {
            $query->whereBetween('fecha_compra', [$fechaInicio, $fechaFin]);
        })->where('cedula_asesor', $asesor)->get();
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

    public function getInfoProductosCotizados($asesor, $fecha_i, $fecha_f, $limit = 50)
    {
        $data = ModelItemsCotizadosCrm::join('users as u', 'u.nombre', '=', 'cotizaciones.asesor')
            ->select(['sku', 'producto', DB::raw('COUNT(sku) as cantidad')])
            ->where('u.cargo', 'asesor')
            ->where('u.nombre', $asesor)
            ->whereBetween('cotizaciones.fecha', [$fecha_i, $fecha_f])
            ->groupBy('sku', 'producto')
            ->orderBy('cantidad', 'desc')
            ->limit($limit)
            ->get();


        $data_info = [];

        foreach ($data as $value) {
            $nombre = $value->asesor;

            if (!isset($data_info[$nombre])) {
                $data_info[$nombre] = [];
            }

            $data_info[$nombre][] = [
                'cantidad' => $value->cantidad,
                'sku' => $value->sku,
                'item' => $value->producto,
                'asesor' => $value->asesor,
            ];
        }
        return $data_info;
    }

    public function getInfoProductosCotizadosAl($asesor, $fecha_i, $fecha_f)
    {
        $data = ModelItemsCotizadosCrm::join('users as u', 'u.nombre', '=', 'cotizaciones.asesor')
            ->select(['asesor', 'sku', 'producto', DB::raw('COUNT(sku) as cantidad')])
            ->where('u.cargo', 'asesor')
            ->where('u.nombre', $asesor)
            ->whereBetween('cotizaciones.fecha', [$fecha_i, $fecha_f])
            ->groupBy('asesor', 'sku', 'producto')
            ->orderBy('asesor')
            ->orderByDesc('cantidad')
            ->get();

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
    public function getInfoProductosCotizadosPorReferencia($asesor, $fecha_i, $fecha_f)
    {

        $colores = ["/", ".", "BLANC", "NEGR", "TURQUESA", "BEIGE", "GRIS", "AZUL", "GUYABA", "PINO", "CHOCOLATE", "CELESTE", "MARRON", "NUEZ", "MENTA", "CORAL", "NATURA", "MOSTAZA", "NATU", "MARF", "ROSA", "TAUPE", "SAND", "CARAM", "ZAREM", "FLOR", "CARLOTA", "ANTARTIDA", "MELANI", "PLAT", "TEXA", "MIEL", "VERD", "GRAFITO", "ARENA", "ALUMINIO"];
        $cotizaciones = self::getInfoProductosCotizados($asesor, $fecha_i, $fecha_f);
        // $cotizaciones = json_encode($cotizaciones);
        // $cotizaciones = json_decode($cotizaciones, true);
        $save = [];
        $dataInfo = [];
        $number_pattern = '/(V\d+|\d+)/';  //Patrón de busqueda de números enteros solos, y seguidos de una V
        foreach ($cotizaciones as $index => $cotizacion) {
            foreach ($cotizacion as $subIndex => $elemento) {
                $element = $elemento['item']; // Devuelve el nombre del producto sin números (eliminá el patrón encontrado en la string)
                $sku = $elemento['sku'];
                $cantidad = $elemento['cantidad'];

                $filtradoEncontrado = self::filtrarElementosPorPalabrasClave($element); // Devuelve los elementos que se desean filtrar

                $colorEncontrado = self::filtrarElementosPorColores($element, $colores); // Devuelve los elementos los cuales contienen un color (para eliminarlo)

                if ($filtradoEncontrado) { // Si se desea filtrar:
                    $element = preg_replace($number_pattern, "", $elemento['item']);
                    if ($colorEncontrado) {
                        $element = explode(" ", $element);
                        $keys = [];
                        foreach ($element as $index => $word) {
                            foreach ($colores as $color) {
                                if (strpos($word, $color) !== false) {
                                    $keys[$color][] = $index;
                                    unset($element[$index]); // Eliminar el color encontrado
                                }
                            }
                        }
                        if (!empty($keys)) {
                            $element = implode(" ", $element);
                        }
                    }
                } else { // Si no se desea aplicar filtro (accesorios):
                    $save[$index][$subIndex] = $elemento;
                    $dataInfo[$index][$subIndex]['item'] = $element;
                    $dataInfo[$index][$subIndex]['sku'] = $sku;
                    $dataInfo[$index][$subIndex]['cantidad'] = $cantidad;
                }
                if (isset($save[$index]) && isset($save[$index][$subIndex]) && !in_array($elemento, $save[$index][$subIndex])) {
                    //Si el elemento actual ya fue filtrado, no hacer nada
                } else { // De lo contrario, retornar cadena con las 3 primeras palabras de la cadena original
                    $element_exploded = explode(" ", $element);
                    array_splice($element_exploded, 3, count($element_exploded) - 1);
                    $element_imploded = implode(" ", $element_exploded);
                    $dataInfo[$index][$subIndex]['item'] = $element_imploded;
                    $dataInfo[$index][$subIndex]['sku'] = $sku;
                    $dataInfo[$index][$subIndex]['cantidad'] = $cantidad;
                }
            }
        }
        return self::filtrarYSumarCantidades($dataInfo);
    }
    function filtrarYSumarCantidades($dataInfo)
    {
        $elementosUnicos = array();
        foreach ($dataInfo as $data) {
            foreach ($data as $info) {
                $item = $info['item'];
                $cantidad = $info['cantidad'];
                $sku = $info['sku'];
                if (array_key_exists($item, $elementosUnicos)) {
                    $elementosUnicos[$item]['cantidad'] += $cantidad;
                } else {
                    $elementosUnicos[$item] = array(
                        'item' => $item,
                        'cantidad' => $cantidad,
                        'sku' => $sku
                    );
                }
            }
        }
        return $elementosUnicos;
    }
    function filtrarElementosPorPalabrasClave($elemento)
    {
        $filtrados = ["CAMA", "COLCHÓN", "CAMANIDO", "COMEDOR", "MESA", "SILLA", "BASE CAMA", "CABECERO", "SALA", "SOFA"];
        foreach ($filtrados as $filtro) {
            if (str_contains($elemento, $filtro)) {
                return true;
            }
        }
        return false;
    }
    function filtrarElementosPorColores($elemento, $colores)
    {
        foreach ($colores as $color) {
            if (str_contains($elemento, $color)) {
                return true;
            }
        }
        return false;
    }
}
