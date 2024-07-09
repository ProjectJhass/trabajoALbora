@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    Mantenimientos
@endsection
@section('menu-mtto')
    menu-open
@endsection
@section('active-mtto')
    bg-danger active
@endsection
@section('active-gestion-mantenimientos')
    active
@endsection
@section('tables-bootstrap-css')
    {{-- --------------------CSS------------------------ --}}
    <link rel="stylesheet" href="{{ asset('css/mantenimiento.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('fabrica-body')
    {{-- BODY --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Gestionar Mantenimientos</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home.intranet.fabrica') }}">Fábrica</a></li>
                        <li class="breadcrumb-item active">Mantenimientos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="card card-outline card-danger">
            <div class="card-header">
                Mantenimiento.
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div>

                        @if ($rol === 1)
                            {{-- EL BOTON VA EN ESTE ESPACIO --}}
                            <button type="button" class="btn btn-secondary shadow" data-toggle="modal"
                                data-target="#staticBackdrop">
                                <i class="fas fa-tools"></i>&nbsp; Crear Mantenimiento
                            </button>
                        @endif
                    </div>
                    <div id="container_table" class="mt-3">
                        <div class="table-responsive-sm">
                            <table class="table shadow rounded" id="history_tables">
                                <thead class="bg-danger" id="tablita">
                                    <tr>
                                        <th scope="col">Referencia</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Observación</th>
                                        @php
                                            $nombre = $rol == 1 ? 'Responsable' : 'Creador';
                                        @endphp
                                        <th scope="col">{{ $nombre }}</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($mantenimientos as $item)
                                        @php
                                            if ($rol === 1) {
                                                $fecha = $item['fecha_mantenimiento'];
                                                if ($fecha >= $hoy && $item['estado'] == 'programado') {
                                                    $info = 'btn btn-success';
                                                    $icono = '<i class="fas fa-edit"></i>';
                                                }
                                                if ($fecha < $hoy && $item['estado'] != 'programado') {
                                                    $info = 'btn btn-danger';
                                                    $icono = '<i class="fas fa-ban"></i>';
                                                }

                                                if ($fecha < $hoy && $item['estado'] == 'programado') {
                                                    $info = 'btn btn-warning';
                                                    $icono = '<i class="fas fa-exclamation-triangle"></i>';
                                                }

                                                $modal = $info === 'btn btn-danger' ? 'false' : 'modal';
                                            } else {
                                                $modali = 'modalAceptacion';
                                            }

                                        @endphp

                                        @if ($rol === 1)
                                            <tr>
                                                <td>{{ $item['referencia'] }}</td>
                                                <td>{{ $item['nombre_maquina'] }}</td>
                                                <td>{{ $item['observacion'] }}</td>
                                                <td>{{ $item['responsable'] }}</td>
                                                <td>{{ $item['fecha_mantenimiento'] }}</td>

                                                {{-- BOTON DE EDICIÓN o DE ACEPTACION DE MANTENIMIENTO --}}

                                                <td>
                                                    @if ($rol === 1)
                                                        <a type="button" class="{{ $info }}"
                                                            data-toggle="{{ $modal }}"
                                                            id="boton_{{ $item['id_mantenimiento'] }}"
                                                            onclick="chargeMantenice('{{ route('charge.mantenice') }}','{{ $item['id_mantenimiento'] }}'),validacion('{{ $modal }}')"
                                                            data-target="#modal"
                                                            data-button="{{ $info }}">{!! $icono !!}</a>
                                                    @else
                                                        @if ($hoy <= $item['fecha_mantenimiento'])
                                                            <button class="btn btn-success"data-toggle="modal"
                                                                data-target="#{{ $modali }}"
                                                                onclick="chargeInfo('{{ route('user.mantenice') }}', '{{ $item['id_mantenimiento'] }}')"><i
                                                                    class="fas fa-user-check"></i></button>
                                                        @elseif($hoy > $item['fecha_mantenimiento'] && $hoy <= $item['extemporaneo'])
                                                            <button class="btn btn-warning"data-toggle="modal"
                                                                data-target="#{{ $modali }}"
                                                                onclick="chargeInfo('{{ route('user.mantenice') }}', '{{ $item['id_mantenimiento'] }}')"><i
                                                                    class="fas fa-exclamation-triangle"></i></button>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @else
                                            @if ($hoy <= $item['extemporaneo'])
                                                <tr>
                                                    <td>{{ $item['referencia'] }}</td>
                                                    <td>{{ $item['nombre_maquina'] }}</td>
                                                    <td>{{ $item['observacion'] }}</td>
                                                    <td>{{ $item['responsable'] }}</td>
                                                    <td>{{ $item['fecha_mantenimiento'] }}</td>
                                                    {{-- BOTON DE EDICIÓN o DE ACEPTACION DE MANTENIMIENTO --}}
                                                    <td>

                                                        @if ($rol === 1)
                                                            <a type="button" class="{{ $info }}"
                                                                data-toggle="{{ $modal }}"
                                                                id="boton_{{ $item['id_mantenimiento'] }}"
                                                                onclick="chargeMantenice('{{ route('charge.mantenice') }}','{{ $item['id_mantenimiento'] }}'),validacion('{{ $modal }}')"
                                                                data-target="#modal"
                                                                data-button="{{ $info }}">{!! $icono !!}</a>
                                                        @else
                                                            @if ($hoy <= $item['fecha_mantenimiento'])
                                                                <button class="btn btn-success"data-toggle="modal"
                                                                    data-target="#{{ $modali }}"
                                                                    onclick="chargeInfo('{{ route('user.mantenice') }}', '{{ $item['id_mantenimiento'] }}')"><i
                                                                        class="fas fa-user-check"></i></button>
                                                            @elseif($hoy > $item['fecha_mantenimiento'] && $hoy <= $item['extemporaneo'])
                                                                <button class="btn btn-warning"data-toggle="modal"
                                                                    data-target="#{{ $modali }}"
                                                                    onclick="chargeInfo('{{ route('user.mantenice') }}', '{{ $item['id_mantenimiento'] }}')"><i
                                                                        class="fas fa-exclamation-triangle"></i></button>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
    </section>
    @if ($rol === 1)
        <!-- Modal de creacion de mantenimiento -->
        <div class="modal fade" id="staticBackdrop" data-keyboard="false" aria-hidden="true"
            style="font-family: sans-serif; color: #697a8d;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fas fa-wrench"></i>&nbsp;Crear
                            mantenimiento.
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" name="formulario" id="formulario" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="">Máquina</label>
                                    <select class="select2" id="seleccion_maquina" style="width: 100%!important;"
                                        name="select">
                                        <option value="seleccion">Seleccionar...</option>
                                        @foreach ($data as $value)
                                            <option value="{{ $value['id_maquina'] }}">
                                                {{ $value['referencia'] . ' ' . $value['nombre_maquina'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Responsable</label>
                                    <select name="responsable" id="responsable" class="select2" style="width: 100%!important;">
                                        <option value="seleccion">Seleccionar...</option>
                                        @foreach ($responsables as $key)
                                            <option value="{{ $key->id }}">{{ $key->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Fecha a realizar</label>
                                    <input type="date" class="form-control" name="calendar" id="calendar">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">¿Guardar en hoja de vida?</label>
                                    <select name="hoja_vida" id="hoja_vida" class="form-control">
                                        <option value="seleccion">Seleccionar...</option>
                                        <option value="true">SI</option>
                                        <option value="false">NO</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="">Observaciones</label>
                                    <textarea name="observacion" id="observacion" class="form-control" cols="30" rows="2"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger shadow" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success shadow"
                            onclick="enviardatos('{{ route('save.mantenice') }}')"><i class="fas fa-save"></i>&nbsp
                            Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal de edicion de mantenimiento-->
        <div class="modal fade" id="modal" data-keyboard="false" aria-hidden="true"
            style="font-family: sans-serif; color: #697a8d;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="title"><i class="fas fa-wrench"></i>&nbsp;Editar mantenimiento.
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="formulario" id="formulario_change" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div>

                                            <label for="perro">Máquina</label>
                                            <input type="text" class="form-control" id="input_info" disabled>
                                        </div>
                                        <div class="mt-2">
                                            <label for="responsable" class="d-block">Responsable:</label>
                                            <select name="responsable1" id="responsable1" class="select2"
                                                style="width: 100%!important;">

                                                </option>
                                                @foreach ($responsables as $key)
                                                    <option value="{{ $key->id }}">{{ $key->nombre }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="">
                                            <label for="calendar">Fecha Mantenimiento:</label>
                                            <input type="date" class="form-control" name="calendar1" id="calendar1">
                                        </div>
                                        <div class="mt-2">
                                            <label for="observacion">Observación:</label>
                                            <textarea type="text" class="form-control" id="observacion1" rows="2" name="observacion1"
                                                placeholder="Observaciones..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary shadow" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-danger shadow"
                            onclick="deleteMantenice('{{ route('delete.mantenice') }}')">&nbsp;Eliminar</button>
                        <button type="button" class="btn btn-success shadow" id="button_change" data-mantenice=""
                            onclick="changeMantenice('{{ route('change.mantenice') }}')"><i class="fas fa-save"></i>&nbsp
                            Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Modal de aceptacion-->
        <div class="modal fade" id="modalAceptacion" data-keyboard="false" aria-hidden="true"
            style="font-family: sans-serif; color: #697a8d;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="title"><i class="fas fa-wrench"></i>&nbsp;Realizar mantenimiento.
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="formulario" id="formulario_change" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div>
                                            <label for="perro">Máquina</label>
                                            <input type="text" class="form-control" id="maquina_" disabled>
                                        </div>
                                        <div class="mt-2">
                                            <label for="responsable" class="d-block">Responsable:</label>
                                            <input type="text" disabled id="responsable_"class="form-control"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="">
                                            <label for="calendar">Fecha Mantenimiento:</label>
                                            <input type="date" class="form-control" name="calendar_" id="calendar_"
                                                disabled>
                                        </div>
                                        <div class="mt-2">
                                            <label for="observacion3">Observación:</label>
                                            <textarea type="text" class="form-control" id="observacion_" rows="3" name="observacion1"
                                                placeholder="Observaciones..." autocomplete="off"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary shadow" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success shadow" id="button_aceptar" data-mantenice=""
                            onclick="okMantenice('{{ route('request.mantenice') }}')"><i
                                class="fas fa-paper-plane"></i>&nbsp;
                            Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('scripts')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            $("#seleccion_maquina").select2();
            $("#responsable").select2();
            $("#responsable1").select2();
            dataTable();
        });


        function dataTable() {
            $("#history_tables").DataTable({
                oLanguage: {
                    sSearch: "Buscar:",
                    sInfo: "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                    oPaginate: {
                        sPrevious: "Volver",
                        sNext: "Siguiente",
                    },
                    sEmptyTable: "No se encontró ningun registro en la base de datos",
                    sZeroRecords: "No se encontraron resultados...",
                    sLengthMenu: "Mostrar _MENU_ registros",
                },
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
                responsive: true,
            });

        }

        function okMantenice(url) {

            let id_mantenimiento = document.getElementById("button_aceptar").dataset.mantenice;
            let observacion = document.getElementById("observacion_").value;

            if (observacion.length != 0) {

                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "json",
                    data: {
                        mantenimiento: id_mantenimiento,
                        observacion: observacion,
                    },
                }).done(function(res) {

                    if (res.status == true) {
                        let observacion2 = document.getElementById("observacion_");
                        observacion2.value = "";
                        let container = document.getElementById("container_table");
                        container.innerHTML = res.tabla;

                        $("#modalAceptacion").modal("toggle");

                        Swal.fire({
                            title: "Excelente =)!",
                            text: "Mantenimiento Realizado!",
                            icon: "success",
                        });
                        dataTable();
                    }
                });
            } else {

                notificacion('Oops!', 'Debes ingresar una observación para realizar este mantenimiento!', 'error');
            }

        }

        function chargeInfo(url, id_mantenimiento) {
            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: {
                    mantenimiento: id_mantenimiento,
                },
            }).done(function(res) {
                if (res) {
                    let datos = res;

                    let fecha_mantenimiento;
                    let responsable;
                    let id_mantenimiento;
                    let referencia;
                    let nombre_maquina;

                    for (let key in datos) {
                        referencia = datos[key].referencia;
                        responsable = datos[key].responsable;
                        fecha_mantenimiento = datos[key].fecha_mantenimiento;
                        id_mantenimiento = datos[key].id_mantenimiento;
                        nombre_maquina = datos[key].maquina;
                    }
                    let mensaje = '' + referencia + ' ' + nombre_maquina;
                    document.getElementById("maquina_").value = mensaje;
                    document.getElementById("responsable_").value = responsable;
                    document.getElementById("calendar_").value = fecha_mantenimiento;
                    document.getElementById("button_aceptar").dataset.mantenice = id_mantenimiento;


                }
            });
        }

        function chargeMantenice(url, id_mantenice) {
            let titulo = document.getElementById("title");
            titulo.innerHTML = "Editar Mantenimiento";

            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: {
                    id_mantenimiento: id_mantenice,
                },
            }).done(function(res) {
                if (res) {
                    let datos = res.mantenice;

                    let referencia;
                    let comentario;
                    let fecha;
                    let responsable;
                    let id_user;
                    let id_mantenimiento;
                    let nombre_maquina;

                    for (let key in datos) {
                        referencia = datos[key].referencia;
                        nombre_maquina = datos[key].maquina;
                        responsable = datos[key].responsable;
                        comentario = datos[key].observacion;
                        fecha = datos[key].fecha_mantenimiento;
                        id_user = datos[key].id_user;
                        id_mantenimiento = datos[key].id_mantenimiento;
                    }

                    let nombre_completo = '' + referencia + '  ' + nombre_maquina;
                    document.getElementById("input_info").value = nombre_completo;
                    $('#responsable1').val(id_user).trigger('change');
                    document.getElementById("calendar1").value = fecha;
                    document.getElementById("observacion1").value = comentario;
                    document.getElementById("button_change").dataset.mantenice = id_mantenimiento;
                }
            });
        }

        function validacion(validacion) {
            if (validacion === "false") {
                Swal.fire({
                    icon: "error",
                    title: "Oops... no se puede editar!",
                    text: "Parece que el mantenimiento ya se realizó!",
                });
            }
        }

        function changeMantenice(url) {
            let formulario = document.getElementById("formulario_change");

            let boton = document.getElementById("button_change");
            let id_mantenimiento = boton.dataset.mantenice;
            let form = new FormData(formulario);

            form.append("id_mantenimiento", id_mantenimiento);

            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: form,
                cache: false,
                contentType: false,
                processData: false,
            }).done(function(res) {
                if (res) {
                    let container = document.getElementById("container_table");
                    container.innerHTML = res.render;

                    $("#modal").modal("toggle");
                    formulario.reset();
                    notificacion('Excelente!', 'Mantenimiento editado con éxito!', 'success')
                    dataTable();
                }
            });
        }

        function validacionCampos() {

            let calendario = document.getElementById("calendar").value;
            let observacion = document.getElementById("observacion").value;
            let responsable = document.getElementById("responsable").value;
            let selec_maquina = document.getElementById("seleccion_maquina").value;
            let seleccion = document.getElementById("hoja_vida").value;
            let data = [calendario, observacion, responsable, selec_maquina, seleccion];

            let resultado = 0;
            for (let i = 0; i < data.length; i++) {
                if (i >= 2) {
                    (data[i] == 'seleccion') ? resultado-- : resultado++;
                } else {
                    (data[i].length > 0) ? resultado++ : resultado--;
                }
            }

            return resultado;
        }

        function enviardatos(url) {
            let formulario = document.getElementById("formulario");
            let form = new FormData(formulario);
            let validacion = validacionCampos();

            form.append('errores', validacion);

            if (validacion >= 5) {

                $.ajax({
                        url: url,
                        type: "POST",
                        dataType: "json",
                        data: form,
                        cache: false,
                        contentType: false,
                        processData: false,
                    })
                    .done(function(res) {

                        if (res.status) {
                            let pegar = document.getElementById("container_table");
                            pegar.innerHTML = res.render;
                            dataTable()

                            formulario.reset();
                            $('#seleccion_maquina').val('seleccion').trigger('change');
                            $('#responsable').val('seleccion').trigger('change');
                            $("#staticBackdrop").modal("toggle");

                            notificacion('Excelente!', 'Mantenimiento programado con éxito!', 'success');
                        }
                    })
                    .fail(function(fail) {
                        if (fail) {
                            notificacion('Ooops', 'parece que algo no salió bien!', 'error');
                        }
                    });

            } else {
                notificacion('Oops...', 'Por favor revisa que todos los campos esten bien diligenciados', 'error');
            }
        }

        function deleteMantenice(url) {
            let formulario = document.getElementById("formulario");
            let boton = document.getElementById("button_change");
            let id_mantenimiento = boton.dataset.mantenice;

            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: {
                    id_mantenimiento: id_mantenimiento,
                },
            }).done(function(res) {
                if (res) {
                    let container = document.getElementById("container_table");
                    container.innerHTML = res.render;
                    $("#modal").modal("toggle");
                    formulario.reset();
                    Swal.fire({
                        title: "Excelente =)!",
                        text: "Mantenimiento eliminado con éxito!",
                        icon: "success",
                    });
                    dataTable();
                }
            });
        }

        function notificacion(title, text, icon) {

            Swal.fire({
                title: title,
                text: text,
                icon: icon,
            });
        }
    </script>
@endsection
