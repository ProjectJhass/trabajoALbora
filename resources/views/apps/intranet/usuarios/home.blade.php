@extends('apps.intranet.plantilla.app')
@section('title')
    Usuarios
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('usuarios')
    bg-danger active
@endsection
@section('body')
    @php
        $baseUrl = env('APP_BASE_URL', 'http://localhost');
    @endphp
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Usuarios</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Usuarios</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <a href="{{ route('crear.info.usuario', ['cedula' => '', 'nombre' => '']) }}" class="btn btn-danger mb-4"><i class="fas fa-user-alt"></i>
                Crear
                usuario</a>

            <div class="card card-outline card-danger">
                <div class="card-header">
                    Gestión de usuarios
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="TotalUsuariosEmpresa">
                            <thead>
                                <tr style="background-color: #cd0243;" class="text-white">
                                    <th>#</th>
                                    <th>Cédula</th>
                                    <th>Nombre</th>
                                    <th>Empresa</th>
                                    <th>Sucursal</th>
                                    <th>Usuario</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php $n = 0; ?>
                                @foreach ($usuarios as $item)
                                    <?php $n++; ?>
                                    <tr>
                                        <td>{{ $n }}</td>
                                        <td>{{ $item['cedula'] }}</td>
                                        <td>{{ $item['nombre'] }}</td>
                                        <td>{{ $item['empresa'] }}</td>
                                        <td>{{ $item['sucursal'] }}</td>
                                        <td>{{ $item['usuario'] }}</td>
                                        <td><?php echo $item['estado']; ?></td>
                                        <td>
                                            <a href="{{ route('crear.info.usuario', ['cedula' => trim($item['cedula']), 'nombre' => trim($item['nombre'])]) }}"
                                                type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-edit"></i></a>
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
@section('footer')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            $('#TotalUsuariosEmpresa').DataTable({
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
                "autoWidth": true,
                "responsive": false,
            });
        });

        ConsultarInformacion = (cedula, nombre) => {
            document.getElementById('formulario-intranet-users').reset();
            $('#ModalVisualizarInformacion').modal('show');
            var datos = $.ajax({
                type: "POST",
                url: "{{ route('get.info.usuarios') }}",
                dataType: "json",
                data: {
                    cedula
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    $('#cedula_u').val(cedula);
                    $('#nombre_u').val(nombre);
                    $('#checkIntranet').prop('checked', res.intranet);
                    $('#checkReal').prop('checked', res.real);
                    $('#checkPruebas').prop('checked', res.pruebas);
                    if (res.intranet == true) {
                        $('#email_u').val(res.data.email);
                        $('#dpto_u').val(res.data.dpto_user);
                        $('#permiso_dpto').val(res.data.permiso_dpto);
                        $('#sucursal_u').val(res.data.sucursal);
                        $('#cargo_u').val(res.data.cargo);
                        $('#nom_usuario_u').val(res.data.usuario);
                        $('#zona_u').val(res.data.zona);
                        $('#reloj_u').val(res.data.ingreso_personal);
                        $('#calendario_u').val(res.data.calendario);
                        $('#estado_u').val(res.data.estado);
                        $('#bitacora').val(res.data.bitacora)
                    }
                }
            });
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 2000,
                    toast: true
                });
            });
        }
    </script>
@endsection
