@extends('apps.intranet.plantilla.app')
@section('title')
    Usuarios
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('storage/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('storage/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
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
                                            <button class="btn btn-success btn-sm"
                                                onclick="ConsultarInformacion('{{ trim($item['cedula']) }}','{{ trim($item['nombre']) }}')"><i
                                                    class="fas fa-edit"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="ModalVisualizarInformacion" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header text-white" style="background-color: #cd0243;">
                        <h5 class="modal-title">Información general</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="was-validated" id="formulario-intranet-users" autocomplete="off">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Cédula</label>
                                                <input type="text" class="form-control" name="cedula_u" id="cedula_u" placeholder="Número de cédula"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Nombre</label>
                                                <input type="text" class="form-control" name="nombre_u" id="nombre_u" placeholder="Nombre completo"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="email" class="form-control" name="email_u" id="email_u" placeholder="Correo electrónico">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Departamento</label>
                                                <select name="dpto_u" id="dpto_u" class="form-control" required>
                                                    <option value="">Seleccionar...</option>
                                                    <?php foreach ($dptos as $key => $value) { ?>
                                                    <option value="{{ $value->id_dpto }}">{{ $value->nombre_dpto }}</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Permiso Departamento</label>
                                                <select name="permiso_dpto" id="permiso_dpto" class="form-control" required>
                                                    <option value="">Seleccionar...</option>
                                                    <option value="1">Editor</option>
                                                    <option value="0">Visualizar</option>
                                                    <option value="2">Especial</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Sucursal</label>
                                                <select class="form-control" name="sucursal_u" id="sucursal_u" required>
                                                    <option value="">Seleccionar</option>
                                                    <option value="002">002</option>
                                                    <option value="004">004</option>
                                                    <option value="006">006</option>
                                                    <option value="007">007</option>
                                                    <option value="008">008</option>
                                                    <option value="010">010</option>
                                                    <option value="011">011</option>
                                                    <option value="012">012</option>
                                                    <option value="014">014</option>
                                                    <option value="017">017</option>
                                                    <option value="020">020</option>
                                                    <option value="025">025</option>
                                                    <option value="027">027</option>
                                                    <option value="028">028</option>
                                                    <option value="036">036</option>
                                                    <option value="038">038</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Cargo</label>
                                                <select name="cargo_u" id="cargo_u" class="form-control" required>
                                                    <option value="">Seleccionar...</option>
                                                    <option value="administrador">Administrador</option>
                                                    <option value="asesor">Asesor</option>
                                                    <option value="guest">No aplica</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Usuario</label>
                                                <input type="text" class="form-control" name="nom_usuario_u" id="nom_usuario_u"
                                                    placeholder="Nombre de usuario" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Contraseña</label>
                                                <input type="text" class="form-control" name="pass_u" id="pass_u" placeholder="Contraseña">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Zona</label>
                                                <select name="zona_u" id="zona_u" class="form-control" required>
                                                    <option value="">Seleccionar...</option>
                                                    <option value="2">Norte</option>
                                                    <option value="1">Centro</option>
                                                    <option value="0">No aplica</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Ingreso - reloj</label>
                                                <select name="reloj_u" id="reloj_u" class="form-control" required>
                                                    <option value="">Seleccionar...</option>
                                                    <option value="1">Si</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Acceso - calendario</label>
                                                <select name="calendario_u" id="calendario_u" class="form-control" required>
                                                    <option value="">Seleccionar...</option>
                                                    <option value="1">Si</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Estado</label>
                                                <select name="estado_u" id="estado_u" class="form-control" required>
                                                    <option value="">Seleccionar...</option>
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Bitácora</label>
                                                <select name="bitacora" id="bitacora" class="form-control" required>
                                                    <option value="">Seleccionar...</option>
                                                    <option value="1">Usuario</option>
                                                    <option value="2">Asignado</option>
                                                    <option value="3">Administrador</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="card card-outline card-danger">
                                        <div class="card-header">
                                            Apps en donde está registrado
                                        </div>
                                        <div class="card-body">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="checksIntranet[]" value="intranet"
                                                    id="checkIntranet">
                                                <label class="form-check-label" for="checkIntranet">
                                                    Intranet
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="checksIntranet[]" value="c_real"
                                                    id="checkReal">
                                                <label class="form-check-label" for="checkReal">
                                                    Cotizador y Gcp
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="checksIntranet[]" value="c_pruebas"
                                                    id="checkPruebas">
                                                <label class="form-check-label" for="checkPruebas">
                                                    Cotizador pruebas
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" onclick="ActualizarInformacionPlataformas('formulario-intranet-users')">Actualizar
                            información</button>
                        <button type="button" class="btn btn-success" onclick="CrearInformacionPlataformas('formulario-intranet-users')">Crear
                            información</button>
                    </div>
                </div>
            </div>
        </div>


    </section>
@endsection
@section('footer')
    <script src="{{ asset('storage/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('storage/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('storage/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('storage/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
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
                url: "{{ $baseUrl }}/app/public/api/intranet/consultar",
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
                        $('#email_u').val(res.data[0].email);
                        $('#dpto_u').val(res.data[0].dpto);
                        $('#permiso_dpto').val(res.data[0].permiso_dpto);
                        $('#sucursal_u').val(res.data[0].sucursal);
                        $('#cargo_u').val(res.data[0].cargo);
                        $('#nom_usuario_u').val(res.data[0].usuario);
                        $('#zona_u').val(res.data[0].zona);
                        $('#reloj_u').val(res.data[0].ingreso);
                        $('#calendario_u').val(res.data[0].calendario);
                        $('#estado_u').val(res.data[0].estado);
                        $('#bitacora').val(res.data[0].bitacora)
                    }
                }
            });
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        }

        CrearInformacionPlataformas = (form) => {
            var formData = new FormData(document.getElementById(form));
            formData.append("valores", "agregar_u");

            var datos = $.ajax({
                url: "{{ $baseUrl }}/app/public/api/intranet/crear",
                type: "post",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });

            datos.done((res) => {
                if (res.status == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Información creada',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        }

        ActualizarInformacionPlataformas = (form) => {
            var formData = new FormData(document.getElementById(form));
            formData.append("valores", "agregar_u");

            var datos = $.ajax({
                url: "{{ $baseUrl }}/app/public/api/intranet/actualizar",
                type: "post",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });

            datos.done((res) => {
                if (res.status == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Información actualizada',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        }
    </script>
@endsection
