<div class="card card-outline card-danger">
    <div class="card-header">
        Clientes efectivos
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered table-sm" id="table-clientes-efectivos">
            <thead>
                <tr class="text-center" style="font-size: 13px; background-color: #c22121; color: white;">
                    <th>Asesor</th>
                    <th>Cédula</th>
                    <th>Cliente</th>
                    <th>Fecha compra</th>
                    <th>N° Factura</th>
                    <th>Cantidad</th>
                    <th>Productos</th>
                    <th>Origen</th>
                    <th>Cierre</th>
                    <th>Valor</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody class="text-center" style="font-size: 14px">
                @php
                    $total_ventas = 0;
                @endphp
                @foreach ($info as $item)
                    @php
                        $ventas_ef = $item->ventasEfectivas->toArray();
                        $asesor = $item->asesoresCRM->toArray();
                    @endphp
                    <tr>
                        <td class="text-left"><small>{{ $asesor[0]['nombre'] ?? "" }}</small></td>
                        <td>{{ $item->cedula_cliente }}</td>
                        <td class="text-left">{{ $item->nombre_1 . ' ' . $item->nombre_2 . ' ' . $item->apellido_1 . ' ' . $item->apellido_1 }}</td>
                        <td>{{ $ventas_ef[0]['fecha_compra'] }}</td>
                        <td>{{ $ventas_ef[0]['numero_factura'] }}</td>
                        <td>{{ count($item->itemsCotizados) }}</td>
                        <td>
                            <div class="nav-item dropdown">
                                <a class="nav-link text-danger" data-toggle="dropdown" href="#">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
                                    <span class="dropdown-item dropdown-header">Productos</span>
                                    <div class="dropdown-divider"></div>
                                    @php
                                        $valor_venta = 0;
                                    @endphp
                                    @foreach ($item->itemsCotizados as $prod)
                                        @php
                                            $valor_prod = $prod->vlr_credito;
                                            $valor_venta += ($valor_prod - $valor_prod * $prod->descuento) * $prod->cantidad;
                                        @endphp
                                        <div class="dropdown-item">{{ $prod->producto }}</div>
                                        <div class="dropdown-divider"></div>
                                    @endforeach
                                </div>
                            </div>
                        </td>
                        <td>{{ $item->origen }}</td>
                        <td>{{ $ventas_ef[0]['medio_de_pago'] }}</td>
                        @php
                            $total_ventas += $valor_venta;
                        @endphp
                        <td>$ {{ number_format($valor_venta) }}</td>
                        <td>{{ $ventas_ef[0]['estado'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="text-center table-secondary">
                <tr>
                    <td colspan="9"><strong>Total</strong></td>
                    <td colspan="2"><strong>$ {{ number_format($total_ventas) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="card card-outline card-danger">
    <div class="card-header">
        Presupuesto asesor
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered table-sm" id="presupuesto-asesor-alm">
            <thead>
                <tr class="text-center" style="background-color: #c22121; color: white;">
                    <th>Asesor</th>
                    <th>N° Ventas</th>
                    <th>Valor</th>
                    <th>Sin iva</th>
                    <th>Escala 1</th>
                    <th>% 1</th>
                    <th>Escala 2</th>
                    <th>% 2</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @php
                    $ttal_ = 0;
                @endphp
                @foreach ($presupuesto as $asesor)
                    @php
                        $efect_ = count($asesor->clientesEfectivos);
                        $ttal_ += $efect_;
                        $pres_ = $asesor->presupuestoAsesor->toArray();
                    @endphp
                    <tr>
                        <td class="text-left">{{ $asesor->nombre }}</td>
                        <td>{{ $efect_ }}</td>
                        @php
                            $valor_v_a = 0;
                        @endphp
                        @foreach ($asesor->clientesEfectivos as $item)
                            @foreach ($item->itemsCotizados as $items)
                                @php
                                    $valor_ = $items->vlr_credito;
                                    $valor_v_a += ($valor_ - $valor_ * $items->descuento) * $items->cantidad;
                                @endphp
                            @endforeach
                        @endforeach
                        <td>$ {{ number_format($valor_v_a) }}</td>
                        <td>$ {{ number_format($valor_v_a / 1.19) }}</td>
                        @php
                            $presupuesto_1 = isset($pres_[0]['presupuesto']) ? $pres_[0]['presupuesto'] : 0;
                        @endphp
                        <td>$ {{ number_format($presupuesto_1) }}</td>

                        @php
                            $porcentaje_1 = $presupuesto_1 == 0 ? 0 : round(($valor_v_a * 100) / $presupuesto_1);
                            if ($porcentaje_1 < 33) {
                                $color_p_1 = 'red';
                            } elseif ($porcentaje_1 >= 33 && $porcentaje_1 < 90) {
                                $color_p_1 = 'warning';
                            } else {
                                $color_p_1 = 'green';
                                $porcentaje_1 = min($porcentaje_1, 100);
                            }
                        @endphp
                        <td class="text-{{ $color_p_1 }}"><strong>{{ $porcentaje_1 }}%</strong></td>
                        @php
                            $presupuesto_2 = isset($pres_[0]['presupuesto_2']) ? $pres_[0]['presupuesto_2'] : '0';
                        @endphp
                        <td>$ {{ number_format($presupuesto_2) }}</td>
                        @php
                            $porcentaje_2 = $presupuesto_2 == 0 ? 0 : round(($valor_v_a * 100) / $presupuesto_2);
                            if ($porcentaje_2 < 33) {
                                $color_p_2 = 'red';
                            } elseif ($porcentaje_2 >= 33 && $porcentaje_2 < 90) {
                                $color_p_2 = 'warning';
                            } else {
                                $color_p_2 = 'green';
                                $porcentaje_2 = min($porcentaje_2, 100);
                            }
                        @endphp
                        <td class="text-{{ $color_p_2 }}"><strong>{{ $porcentaje_2 }}</strong>%</td>
                        <td>$ {{ number_format($valor_v_a) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="text-center table-secondary">
                <tr>
                    <td colspan="3"><strong>COTIZACIONES</strong></td>
                    <td><strong>{{ count($cotizaciones) }}</strong></td>
                    <td colspan="3"><strong>EFECTIVIDAD</strong></td>
                    <td colspan="2"><strong>{{ count($cotizaciones) == 0 ? 0 : round(($ttal_ / count($cotizaciones)) * 100, 2) }}%</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card card-outline card-danger">
            <div class="card-header">
                Medios de pago
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-sm" id="medios-de-pago-cliente">
                    <thead>
                        <tr class="text-center" style="background-color: #c22121; color: white;">
                            <th>Asesor</th>
                            <th>Medio de pago</th>
                            <th>Cantidad</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @php
                            $total_ = 0;
                        @endphp
                        @foreach ($medios as $item)
                            @foreach ($item as $medio)
                                @php
                                    $total_ += $medio['valor_total'];
                                @endphp
                                <tr>
                                    <td>{{ $medio['asesor'] }}</td>
                                    <td>{{ $medio['pago'] }}</td>
                                    <td>{{ $medio['cantidad'] }}</td>
                                    <td>$ {{ number_format($medio['valor_total']) }}</td>
                                </tr>
                            @endforeach
                        @endforeach

                    </tbody>
                    <tfoot class="text-center table-secondary">
                        <tr>
                            <td colspan="3"><strong>TOTAL</strong></td>
                            <td><strong>$ {{ number_format($total_) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card card-outline card-danger">
            <div class="card-header">
                Ciudades de compra
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-sm" id="ciudades-de-compra-cli">
                    <thead>
                        <tr class="text-center" style="background-color: #c22121; color: white;">
                            <th>Asesor</th>
                            <th>Ciudad</th>
                            <th>Cantidad</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @php
                            $total_ = 0;
                        @endphp
                        @foreach ($ciudades as $item)
                            @foreach ($item as $valor)
                                @php
                                    $total_ += $valor['total_venta'];
                                @endphp
                                <tr>
                                    <td>{{ $valor['asesor'] }}</td>
                                    <td>{{ $valor['ciudad'] }}</td>
                                    <td>{{ $valor['cantidad_ventas'] }}</td>
                                    <td>$ {{ number_format($valor['total_venta']) }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot class="text-center">
                        <tr class="table-secondary">
                            <td colspan="3"><strong>TOTAL</strong></td>
                            <td><strong>$ {{ number_format($total_) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="card card-outline card-danger">
            <div class="card-header">
                Productos más cotizados
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-sm" id="productos-mas-cotizados">
                    <thead>
                        <tr class="text-center" style="background-color: #c22121; color: white;">
                            <th>Cantidad</th>
                            <th>Producto</th>
                            <th>Sku</th>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                        @foreach ($itemsCot as $item => $registros)
                            @foreach ($registros as $registro)
                                <tr>
                                    <td>{{ $registro['cantidad'] }}</td>
                                    <td class="text-left">{{ $registro['item'] }}</td>
                                    <td>{{ $registro['sku'] }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
                        @if(Route::current()->uri() === 'crm_almacenes/administrador/informe-de-ventas/estadisticas')

    <div class="col-md-12 mb-3">
        <div class="card card-outline card-danger">
            <div class="card-header">
                Productos más cotizados por asesor
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-sm" id="productos-mas-cotizados-al">
                    <thead>
                        <tr class="text-center" style="background-color: #c22121; color: white;">
                            <th>Asesor</th>
                            <th>Cantidad</th>
                            <th>Producto</th>
                            <th>Sku</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($itemsCotAl as $item => $registros)
                            @foreach ($registros as $registro)
                                <tr>
                                    <td>{{ $registro['asesor'] }}</td>
                                    <td>{{ $registro['cantidad'] }}</td>
                                    <td class="text-left">{{ $registro['item'] }}</td>
                                    <td>{{ $registro['sku'] }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

     @endif
     <div class="col-md-12 mb-3">
        <div class="card card-outline card-danger">
            <div class="card-header">
                Productos más cotizados por referencia
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-sm" id="productos-mas-cotizados-ref">
                    <thead>
                        <tr class="text-center" style="background-color: #c22121; color: white;">
                            <th>Cantidad</th>
                            <th>Producto</th>
                            <th>Sku</th>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                        @foreach ($itemsRef as $item => $registro)
                                <tr>
                                    <td>{{ $registro['cantidad'] }}</td>
                                    <td class="text-left">{{ $registro['item'] }}</td>
                                    <td>{{ $registro['sku'] }}</td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="card card-outline card-danger">
            <div class="card-header">
                Productos vendidos
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-sm" id="productos-vendidos-alb">
                    <thead>
                        <tr class="text-center" style="background-color: #c22121; color: white;">
                            <th>Asesor</th>
                            <th>Sku</th>
                            <th>Producto</th>
                            <th>Cant</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_ = 0;
                        @endphp
                        @foreach ($products as $asesor => $items)
                            @foreach ($items as $resultado)
                                @php
                                    $total_ += $resultado['valor'];
                                @endphp
                                <tr>
                                    <td>{{ $resultado['asesor'] }}</td>
                                    <td class="text-center">{{ $resultado['sku'] }}</td>
                                    <td>{{ $resultado['item'] }}</td>
                                    <td class="text-center">{{ $resultado['cantidad'] }}</td>
                                    <td class="text-center">${{ number_format($resultado['valor']) }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot class="text-center table-secondary">
                        <tr>
                            <td colspan="4"><strong>TOTAL</strong></td>
                            <td><strong>$ {{ number_format($total_) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
