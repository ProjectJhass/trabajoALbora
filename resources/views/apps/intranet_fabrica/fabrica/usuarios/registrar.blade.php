@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    Usuarios
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
                    Registrar usuario
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card card-outline card-secondary">
                                <div class="card-header">{{ __('Información') }}</div>

                                <div class="card-body">
                                    <form method="POST" id="formulario-registro-nuevo-usuario" class="was-validated" autocomplete="off">
                                        @csrf

                                        <div class="row mb-3">
                                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>

                                            <div class="col-md-6">
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                                    name="name" value="{{ old('name') }}" placeholder="Nombre completo" required autofocus>

                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                                    name="email" value="{{ old('email') }}" placeholder="Dirección de correo" required>

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="usuario" class="col-md-4 col-form-label text-md-end">{{ __('Usuario') }}</label>

                                            <div class="col-md-6">
                                                <input id="usuario" type="text" class="form-control @error('usuario') is-invalid @enderror"
                                                    name="usuario" value="{{ old('usuario') }}" placeholder="Usuario" required>

                                                @error('usuario')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                                    name="password" placeholder="Contraseña" required>

                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="password-confirm"
                                                class="col-md-4 col-form-label text-md-end">{{ __('Confirmar contraseña') }}</label>
                                            <div class="col-md-6">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                                    placeholder="Escribe nuevamente la contraseña" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Tipo de usuario') }}</label>
                                            <div class="col-md-6">
                                                <select name="tipo_de_usuario_fab" id="tipo_de_usuario_fab" class="form-control" required>
                                                    <option value="">Seleccionar...</option>
                                                    <option value="1">Administrador</option>
                                                    <option value="2">General</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="button" class="btn btn-danger"
                                                    onclick="RegistrarNuevoUsuarioFab('{{ route('registrar.users.fab') }}','formulario-registro-nuevo-usuario')">
                                                    {{ __('Agregar usuario') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
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
