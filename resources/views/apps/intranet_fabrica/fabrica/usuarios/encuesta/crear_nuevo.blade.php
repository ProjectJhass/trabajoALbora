@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    Usuarios Encuesta
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
                    <h5 class="m-0">Registrar nuevo usuario</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home.intranet.fabrica') }}">Fábrica</a></li>
                        <li class="breadcrumb-item active">Registrar usuario</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    Información
                </div>
                <div class="card-body">
                    <form id="formulario-nuevo-registro-encuesta" autocomplete="off" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="">Número de cédula</label>
                                    <input type="number" class="form-control" min="0" name="cedula_nuevo_registro" id="cedula_nuevo_registro"
                                        placeholder="Número de cédula">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Nombre completo</label>
                                <input type="text" class="form-control" onkeyup="this.value=this.value.toUpperCase();" name="nombre_nuevo_registro"
                                    id="nombre_nuevo_registro" placeholder="Nombre completo">
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger"
                            onclick="AgregarNuevoRegistroEncuesta('{{ route('agregar.user.encuesta') }}','formulario-nuevo-registro-encuesta')">Registrar
                            Información</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
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
