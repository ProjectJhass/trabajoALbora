@extends('apps.servicios_tecnicos.plantilla.app')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('usuarios')
    active
@endsection
@section('body')
    <button type="button" class="btn rounded-pill btn-outline-danger mb-4" data-bs-toggle="modal" data-bs-target="#basicModal">
        <span class="tf-icons bx bx-info-circle me-1"></span> Crear usuario
    </button>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">Usuarios activos</div>
                <div class="card-body" id="info-table-usuarios-admin">
                    @php
                        echo $usuarios;
                    @endphp
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Crear información</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="info-user-new" method="post" class="was-validated">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="">Cédula</label>
                                    <input type="number" onchange="buscarInfoAdminUser(this.value)" class="form-control" name="create_cedula"
                                        id="create_cedula" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" name="create_name" id="create_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Almacen</label>
                                    <select class="form-control" name="create_alm" id="create_alm" required>
                                        <option value="">Seleccionar...</option>
                                        @foreach ($almacenes as $item)
                                            <option value="{{ $item->numero }}">{{ $item->almacen }}</option>
                                        @endforeach                                        
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Empresa</label>
                                    <select class="form-control" name="create_empresa" id="create_empresa" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="MUEBLES ALBURA">MUEBLES ALBURA SAS</option>
                                        <option value="HAPPY SLEEP">HAPPY SLEEP SAS</option>
                                        <option value="HOTEL ABADIA">HOTEL ABADIA</option>
                                        <option value="HOTEL SONESTA">HOTEL SONESTA</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Rol</label>
                                    <select class="form-control" name="create_rol" id="create_rol" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="1">Admin</option>
                                        <option value="0">General</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Usuario</label>
                                    <input type="text" class="form-control" name="create_user" id="create_user" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Contraseña</label>
                                    <input type="text" class="form-control" name="create_pwd" id="create_pwd" required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cerrar
                        </button>
                        <button type="button" class="btn btn-success" onclick="crearInfoUserNew()">Guardar información</button>
                    </div>
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
    <script>
        $(() => {
            setupTable()
        })

        buscarInfoAdminUser = (id) => {
            var datos = $.ajax({
                url: "{{ route('search.users.admin') }}",
                type: "post",
                dataType: "json",
                data: {
                    id
                }
            });
            datos.done((res) => {
                $('#create_name').val(res.info.nombre)
                $('#create_alm').val(res.info.sucursal)
                $('#create_user').val(res.info.usuario)
                $('#create_pwd').val(res.info.password)
            })
        }

        setupTable = () => {
            $('#tableInfoUsuarios').DataTable({
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
                "info": false,
                "autoWidth": true,
                "responsive": false,
            });
        }

        crearInfoUserNew = () => {
            notificacion("Guardando información del nuevo usuario", "info", 5000);
            var formulario = new FormData(document.getElementById('info-user-new'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('create.users.admin') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                document.getElementById('info-table-usuarios-admin').innerHTML = res.table;
                notificacion("Excelente! información creada", "success", 2000);
                document.getElementById('info-user-new').reset()
                setupTable()
            })
            datos.fail(() => {
                notificacion("ERROR! Vuelve a intentarlo", "error", 2000);
            })
        }
    </script>
@endsection
