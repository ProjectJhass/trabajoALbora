@extends('apps.automoviles.layout.app')
@section('title')
    Automoviles
@endsection
@section('head')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('active-autos')
    active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Automóviles</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('albura.autos') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Información individual</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <strong>Información general</strong>
                    {{-- <h6>Información general</h6> --}}
                    <div class="card-tools">
                        <form action="" method="post">
                            @csrf
                            <div class="form-row align-items-center">
                                <div class="col-sm-5 mt-3 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Desde</div>
                                        </div>
                                        <input type="month" name="fecha_i" id="fecha_i" class="form-control" min="2022-01"
                                            value="{{ date('Y-m', strtotime($fecha_i)) }}" id="inlineFormInputGroupUsername" placeholder="Username">
                                    </div>
                                </div>
                                <div class="col-sm-5 mt-3 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Hasta</div>
                                        </div>
                                        <input type="month" name="fecha_f" id="fecha_f" class="form-control" min="2022-01"
                                            value="{{ date('Y-m', strtotime($fecha_f)) }}" id="inlineFormInputGroupUsername" placeholder="Username">
                                    </div>
                                </div>
                                <div class="col-sm-2 mt-3 mb-2">
                                    <button type="button" class="btn btn-danger btn-sm btn-block" onclick="BuscarInformacionPlataforma()">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card card-outline card-danger">
                                <div class="card-body text-center">
                                    <a href="{{ asset('storage/autos/' . $info_auto->imagen) }}" target="_BLANK">
                                        <img src="{{ asset('storage/autos/' . $info_auto->imagen) }}" width="80%" alt="Imagen Autos Albura">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card card-outline card-danger">
                                <div class="card-header">
                                    <strong>Automóvil</strong>
                                </div>
                                <div class="card-body">
                                    <p><strong>Matrícula:</strong> {{ $info_auto->placa }}</p>
                                    <p><strong>Modelo:</strong> {{ $info_auto->modelo }}</p>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card card-outline card-danger">
                                <div class="card-header">
                                    <strong>Resumen</strong>
                                </div>
                                <div class="card-body">
                                    <p><strong>Km recorridos:</strong> {{ $km_recorridos }} km</p>
                                    <p><strong>Gasto en combustible:</strong> $ {{ number_format($gasto_combustible) }}</p>
                                    <p><strong>Gastos de mantenimiento:</strong> $ {{ number_format($gasto_mtto) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="card card-outline card-danger">
                                <div class="card-header">
                                    <strong>Información por meses</strong>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-sm" id="reporte-km-recorridos-y-consumo">
                                        <thead>
                                            <tr class="text-center">
                                                <th hidden>#</th>
                                                <th>Año</th>
                                                <th>Mes</th>
                                                <th>Km recorridos</th>
                                                <th>Galones obtenidos</th>
                                                <th>Inversión</th>
                                                <th>Gastos Mtto</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            @foreach ($data_tabla as $item)
                                                <tr>
                                                    <td hidden></td>
                                                    <td>{{ $item['year'] }}</td>
                                                    <td class="text-left">{{ $item['month'] }}</td>
                                                    <td>{{ $item['km_recorridos'] }}</td>
                                                    <td>{{ number_format($item['galones'], 1) }}</td>
                                                    <td>$ {{ number_format($item['inversion']) }}</td>
                                                    <td>$ {{ number_format($item['gasto_mtto']) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="card card-outline card-danger">
                                <div class="card-header">
                                    <strong>Mantenimientos realizados</strong>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-sm" id="table-mantenimientos-realizados">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Fecha</th>
                                                <th>Concepto</th>
                                                <th>Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $value)
                                                <tr>
                                                    <td>{{ date('Y-m-d', strtotime($value['fecha'])) }}</td>
                                                    <td>{{ $value['concepto'] }}</td>
                                                    <td>$ {{ number_format($value['valor']) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {

            $('#table-mantenimientos-realizados').DataTable({
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
                    [0, "desc"]
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            $('#reporte-km-recorridos-y-consumo').DataTable({
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
                    [0, "asc"]
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": false,
                "autoWidth": true,
                "responsive": true,
            });
        });

        NotificacionAlert = (tipo, mensaje, tiempo) => {
            Swal.fire({
                position: 'top-end',
                icon: tipo,
                title: mensaje,
                showConfirmButton: false,
                timer: tiempo
            });
        }

        BuscarInformacionPlataforma = () => {

            NotificacionAlert('info', 'Buscando información...', '2000');

            var datos = $.ajax({
                type: "POST",
                url: window.location.href,
                dataType: "json",
                data: {
                    fecha_i: $('#fecha_i').val(),
                    fecha_f: $('#fecha_f').val()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    NotificacionAlert('success', 'Información encontrada', '2000');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            });
            datos.fail(() => {
                NotificacionAlert('error', 'Hubo un problema al procesar la solicitud', '2000');
            });
        }
    </script>
@endsection
