@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    Usuarios
@endsection
@section('tables-bootstrap-css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('active-usuarios')
    bg-danger active
@endsection
@section('active-sub-usuarios')
    active
@endsection
@section('fabrica-body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Acceso a usuarios</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home.intranet.fabrica') }}">Fábrica</a></li>
                        <li class="breadcrumb-item active">Usuarios</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    Acceso a la plataforma
                    <div class="card-tools">
                        <a href="{{ route('registrar.usuario') }}" class="btn btn-success">Registrar nuevo</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="TableUsuariosActivos">
                            <thead style="background-color: rgb(177, 5, 5); color: white">
                                <tr class="text-center">
                                    <td>#</td>
                                    <td>Nombre</td>
                                    <td>Email</td>
                                    <td>Usuario</td>
                                    <td>Rol</td>
                                    <td>Eliminar</td>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($usuarios as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->nombre }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->usuario }}</td>
                                        <td><i class="nav-icon far fa-circle {{ $item->rol_user == 1 ? 'text-success' : 'text-danger' }}"></i></td>
                                        <td class="text-center"><i class="fas fa-trash text-danger" style="cursor: pointer;"
                                                onclick="EliminarUsuarioFab('{{ route('eliminar.user.fab') }}','{{ $item->id }}')"></i></td>
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
            $('#TableUsuariosActivos').DataTable({
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

        RegistrarNuevoUsuarioFab = (url, form) => {
            Swal.fire({
                title: 'Estás seguro de registrar este usuario?',
                text: "No podrás revertir esta operación",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, crear',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {

                    var response = ConfirmarRegistroNuevoUsuario(url, form);

                    response.done((res) => {
                        if (res.status == true) {
                            document.getElementById(form).reset();
                            Swal.fire(
                                'Excelente!',
                                'Usuario registrado exitosamente',
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

        ConfirmarRegistroNuevoUsuario = (url, form) => {
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

        EliminarUsuarioFab = (url, id_usuario) => {
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

                    var response = ConfirmEliminacionUsuario(url, id_usuario);

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

        ConfirmEliminacionUsuario = (url, id_usuario) => {
            var datos = $.ajax({
                url: url,
                type: "post",
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
