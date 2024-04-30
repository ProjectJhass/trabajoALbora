@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    Usuarios Encuesta
@endsection
@section('tables-bootstrap-css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('menu-usuarios')
    menu-open
@endsection
@section('active-usuarios')
    bg-danger active
@endsection
@section('active-sub-user-encuesta')
    active
@endsection
@section('fabrica-body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Usuarios registrados encuesta</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home.intranet.fabrica') }}">Fábrica</a></li>
                        <li class="breadcrumb-item active">Usuarios encuesta</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    Acceso a la encuesta
                    <div class="card-tools">
                        <a href="{{ route('nuevo.user.encuesta') }}" class="btn btn-success">Agregar usuario</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="TableUsuariosActivosEncuesta">
                            <thead style="background-color: rgb(177, 5, 5); color: white">
                                <tr class="text-center">
                                    <td>#</td>
                                    <td>Cédula</td>
                                    <td>Nombre</td>
                                    <td>Eliminar</td>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($usuarios as $item)
                                    <tr>
                                        <td>{{ $item->id_usuario_e }}</td>
                                        <td>{{ $item->cedula_usuario }}</td>
                                        <td>{{ $item->nombre_usuario }}</td>
                                        <td><i class="fas fa-trash text-danger" style="cursor: pointer;"
                                                onclick="EliminarUsuarioEncuesta('{{ $item->id_usuario_e }}','{{ route('eliminar.user.encuesta') }}')"></i>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            $('#TableUsuariosActivosEncuesta').DataTable({
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
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });
        });

        AgregarNuevoRegistroEncuesta = (url, form) => {
            Swal.fire({
                title: 'Estás seguro de agregar este usuario?',
                text: "No podrás revertir esta operación",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, agregar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {

                    var response = ConfirmAgregarRegistroEncuesta(url, form);

                    response.done((res) => {
                        if (res.status == true) {
                            document.getElementById(form).reset();
                            Swal.fire(
                                'Excelente!',
                                'Usuario agregado exitosamente',
                                'success'
                            )
                        }
                    });
                    response.fail(() => {
                        Swal.fire(
                            'ERROR!',
                            'Hubo un problema al procesar la solicitud',
                            'error'
                        )
                    });
                }
            });
        }

        ConfirmAgregarRegistroEncuesta = (url, form) => {
            var info = new FormData(document.getElementById(form));
            info.append('valor', 'valor');
            var datos = $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: info,
                cache: false,
                contentType: false,
                processData: false
            });
            return datos;
        }

        EliminarUsuarioEncuesta = (id_usuario, url) => {
            Swal.fire({
                title: 'Estás seguro de eliminar este usuario?',
                text: "No podrás revertir esta operación",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {

                    var response = ConfirmEliminacionUsuarioEncuesta(id_usuario, url);

                    response.done((res) => {
                        if (res.status == true) {
                            Swal.fire(
                                'Excelente!',
                                'Usuario eliminado exitosamente',
                                'success'
                            )
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    });
                    response.fail(() => {
                        Swal.fire(
                            'ERROR!',
                            'Hubo un problema al procesar la solicitud',
                            'error'
                        )
                    });
                }
            });
        }

        ConfirmEliminacionUsuarioEncuesta = (id_usuario, url) => {
            var datos = $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                data: {
                    id_usuario
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            return datos;
        }
    </script>
@endsection
