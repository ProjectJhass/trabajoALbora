@extends('apps.crm_almacenes.gcp.plantilla.app')
@section('title')
    Efectivos
@endsection
@section('header')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('efectivos')
    active
@endsection
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Información clientes efectivos</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">CRM</li>
                        <li class="breadcrumb-item active">Clientes efectivos</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10 text-center">
                    <label>Rango de fechas y asesor</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control float-right rounded-0" value="{{ $fechas }}" id="reservation">
                        <select class="form-control" name="almacen_co" id="almacen_co" onchange="ConsultarAsesoresCo(this.value)">
                            <option value="">Seleccionar...</option>
                            @foreach ($sucursales as $item)
                                <option value="{{ $item->co }}">{{ str_replace('Muebles Albura SAS ', '', $item->nombre_sucursal) }}</option>
                            @endforeach
                        </select>
                        <select class="form-control" name="asesor_co" id="asesor_co" onchange="ConsultarInformacionAsesor(this.value)">
                            <option value="">Seleccionar...</option>
                        </select>
                        <span class="input-group-append">
                            <button type="button" class="btn btn-danger btn-flat" onclick="ConsultarInfoFechas()">Consultar</button>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card card-outline card-danger">
                <div class="card-header">
                    Información general
                </div>
                <div class="card-body">
                    <table id="table-info-clientes-efectivos" class="table table-sm table-bordered table-striped">
                        <thead class="text-center" style="background-color: #c22121; color: white;">
                            <tr>
                                <th>Asesor</th>
                                <th>N°</th>
                                <th>Nombre</th>
                                <th>Ciudad</th>
                                <th>Categoria</th>
                                <th>Fecha compra</th>
                                <th>Recibo|Caja</th>
                                <th>N° Pedido</th>
                                <th>N° Factura</th>
                                <th>Estado</th>
                                <th>Valor venta</th>
                            </tr>
                        </thead>
                        <tbody class="text-center" style="font-size: 14px">
                            <?php $val_t = 0; ?>
                            @foreach ($clientes as $item)
                                <?php $val_t += $item['valor']; ?>
                                <tr>
                                    <td><small>{{ $item['asesor'] }}</small></td>
                                    <td>{{ $item['id_cliente'] }}</td>
                                    <td class="text-left">{{ $item['cliente'] }}</td>
                                    <td>{{ $item['ciudad'] }}</td>
                                    <td>{{ $item['categoria'] }}</td>
                                    <td>{{ $item['fecha_compra'] }}</td>
                                    <td>{{ $item['recibo'] }}</td>
                                    <td>{{ $item['pedido'] }}</td>
                                    <td>{{ $item['factura'] }}</td>
                                    <td>{{ $item['estado'] }}</td>
                                    <td>{{ number_format($item['valor']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="text-center">
                            <tr class="table-secondary">
                                <td colspan="10">Total</td>
                                <td>{{ number_format($val_t) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/efectivos_admin.js') }}"></script>
@endsection
