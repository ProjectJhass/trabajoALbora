@extends('apps.automoviles.layout.app')
@section('title')
    Comparativos
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('active-admin')
    active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Cargue de información</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('albura.autos') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Cargue info</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="container" style="width: 40%">
                <div class="card card-outline card-secondary">
                    <div class="card-header">
                        <h6>Información general</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('import.excel') }}" enctype="multipart/form-data" autocomplete="off" method="post"
                            class="text-center mb-3">
                            <div class="row mb-4 justify-content-center">
                                <div class="col-md-12 mb-3 text-center">
                                    <label for="">Cargue información km recorridos</label>
                                    <input type="file" class="form-control" name="archivo_excel" id="archivo_excel">
                                </div>
                                <div class="col-md-6 text-center">
                                    <label for="">Fecha de corte</label>
                                    <input type="date" class="form-control" name="fecha_" id="fecha_">
                                </div>

                            </div>
                            <button type="submit" class="btn btn-sm btn-danger">Cargar información</button>
                        </form>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h6>Información almacenada</h6>
                </div>
                <div class="card-body">
                    <table id="tableInfoKmRecorridos" class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>Id</th>
                                <th>Placa</th>
                                <th>Km recorridos</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($info as $item)
                                <tr>
                                    <td>{{ $item->id_km }} {{-- <br><i class="fas fa-trash-alt text-red" onclick="" ></i> --}}</td>
                                    <td>{{ $item->placa }}</td>
                                    <td>{{ $item->km_recorridos }}</td>
                                    <td>{{ $item->fecha }}</td>
                                </tr>
                            @endforeach
                        </tbody>
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
    <script>
        $(() => {
            $('#tableInfoKmRecorridos').DataTable({
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
                "order": [0, "desc"],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        })

        ConsultarInfoAutosComp = (form) => {
            NotificacionAlert('info', 'Buscando informacion...', 20000);

            var formData = new FormData(document.getElementById(form));
            formData.append('dato', 'valor');
            var datos = $.ajax({
                url: window.location.href,
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });

            datos.done((res) => {
                if (res.status == true) {
                    NotificacionAlert('success', 'Información encontrada', 1000);
                    document.getElementById('informacion-general-autos').innerHTML = res.data;
                    CargueInformacionGeneral();
                }
            });
            datos.fail(() => {
                NotificacionAlert('error', 'Hubo un problema al procesar la petición', 1500);
            });
        }
    </script>
@endsection
