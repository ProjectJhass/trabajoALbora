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
            <div class="card card-outline card-danger">
                <div class="card-header">
                    Clientes ventas efectivas
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-sm" id="clientes-efectivos-maestra">
                        <thead class="text-center" style="background-color: #c22121; color: white;">
                            <tr>
                                <th>N°</th>
                                <th>Nombre</th>
                                <th>Ciudad</th>
                                <th>Categoria</th>
                                <th>Fecha compra</th>
                                <th>N° de Factura</th>
                                <th>Estado</th>
                                <th>items</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php $val_t = 0; ?>
                            @foreach ($clientes as $item)
                                <?php $val_t += $item['valor']; ?>
                                <tr>
                                    <td>{{ $item['id_cliente'] }}</td>
                                    <td class="text-left">
                                        {{ $item['nombre_1'] . ' ' . $item['nombre_2'] . ' ' . $item['apellido_1'] . ' ' . $item['apellido_2'] }}</td>
                                    <td>{{ $item['ciudad'] }}</td>
                                    <td>
                                        <select class="form-control"
                                            onchange="ActualizarInfoCLiente('categoria',this.value, '{{ $item['id_cliente'] }}')">
                                            <option value="">Seleccionar...</option>
                                            <option value="SALAS" {{ $item['categoria'] == 'SALAS' ? 'selected' : '' }}>SALAS</option>
                                            <option value="COMEDORES" {{ $item['categoria'] == 'COMEDORES' ? 'selected' : '' }}>COMEDORES</option>
                                            <option value="COLCHONES" {{ $item['categoria'] == 'COLCHONES' ? 'selected' : '' }}>COLCHONES</option>
                                            <option value="ALCOBAS" {{ $item['categoria'] == 'ALCOBAS' ? 'selected' : '' }}>ALCOBAS</option>
                                            <option value="ACCESORIOS" {{ $item['categoria'] == 'ACCESORIOS' ? 'selected' : '' }}>ACCESORIOS</option>
                                        </select>
                                    </td>
                                    <td>{{ $item['fecha_compra'] }}</td>
                                    <td>{{ $item['numero_factura'] }}</td>
                                    <td>
                                        <select class="form-control" onchange="ActualizarInfoCLiente('estado',this.value, '{{ $item['id_cliente'] }}')">
                                            <option value="">Seleccionar...</option>
                                            <option value="FACTURADO" {{ $item['estado'] == 'FACTURADO' ? 'selected' : '' }}>FACTURADO</option>
                                            <option value="EN PROCESO" {{ $item['estado'] == 'EN PROCESO' ? 'selected' : '' }}>EN PROCESO</option>
                                            <option value="FABRICACION" {{ $item['estado'] == 'FABRICACION' ? 'selected' : '' }}>FABRICACIÓN</option>
                                        </select>
                                    </td>
                                    <td><button class="btn btn-sm btn-danger" onclick="VisualizarProductosCliente('{{ $item->id_cliente }}')"><i
                                                class="fas fa-shopping-cart"></i></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="informacion-productos-cotizados">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #c22121; color: white;">
                    <h5 class="modal-title">Productos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="informacion-productos-cotizados-cliente"></div>
                    <div style="margin-left: 35%; margin-right: 35%;">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3"><strong>Valor a pagar</strong></span>
                            </div>
                            <input type="text" class="form-control" id="valor_a_pagar" aria-describedby="basic-addon3" disabled>
                        </div>
                    </div>
                </div>
                <div class="modal-footer left-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar información</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/efectivos_asesor.js') }}"></script>
    <script>
        $(() => {
            $('#clientes-efectivos-maestra').DataTable({
                "oLanguage": {
                    "sSearch": "Buscar:",
                    "sInfo": "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                    "oPaginate": {
                        "sPrevious": "Volver",
                        "sNext": "Siguiente"
                    },
                    "sEmptyTable": "No se encontró ningun registro en la base de datos",
                    "sZeroRecords": "No se encontraron resultados...",
                    "sLengthMenu": "Mostrar _MENU_ registros"
                },
                "order": [
                    [4, "desc"]
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": false,
            });
        });

        ActualizarInfoCLiente = (campo, valor, id) => {
            if (valor.length > 0) {
                var datos = $.ajax({
                    url: "{{ route('updateInfo.cliente.crm') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        campo,
                        valor,
                        id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                datos.done((res) => {
                    if (res.status == true) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Campo actualizado',
                            showConfirmButton: false,
                            timer: 1000
                        })
                    }
                })
                datos.fail(() => {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'No hay información para actualizar',
                        showConfirmButton: false,
                        timer: 1500
                    })
                })

            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'No hay información para actualizar',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }
    </script>
@endsection
