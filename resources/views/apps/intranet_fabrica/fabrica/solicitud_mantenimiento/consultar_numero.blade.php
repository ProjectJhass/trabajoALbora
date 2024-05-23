@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    Solicitudes Mtto
@endsection
@section('menu-mtto')
    menu-open
@endsection
@section('active-mtto')
    bg-danger active
@endsection
@section('active-sub-mantenimiento')
    active
@endsection
@section('fabrica-body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Solicitudes Mantenimiento</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home.intranet.fabrica') }}">Fábrica</a></li>
                        <li class="breadcrumb-item active">Solicitudes mantenimiento</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    Consultar solicitud de mantenimiento por número
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <div class="callout callout-danger">
                                <div class="row">
                                    <div class="col-md-9 mb-3">
                                        <div class="form-group">
                                            <label for="">Número de solicitud</label>
                                            <input type="number" class="form-control" min="0" name="numero-solicitud-mtto"
                                                id="numero-solicitud-mtto" placeholder="Número de solicitud">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3" style="margin-top: 3.1%">
                                        <button class="btn btn-danger" onclick="BuscarInformacionSolicitudMtto()">Consultar información</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-5">
                            <div id="respuesta-solicitud-mantenimiento"></div>
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
            $('#TableCerrarSolicitudesMtto').DataTable({
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

        BuscarInformacionSolicitudMtto = () => {
            var numero_solicitud = $('#numero-solicitud-mtto').val();
            if (numero_solicitud > 0) {
                var datos = $.ajax({
                    url: "{{ route('consultar.numero') }}",
                    type: "post",
                    dataType: "json",
                    data: {
                        id_solicitud: numero_solicitud
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                datos.done((res) => {
                    if (res.status == true) {
                        document.getElementById('respuesta-solicitud-mantenimiento').innerHTML = res.data;
                    }
                });
                datos.fail(() => {
                    toastr.error('Hubo un problema al procesar la solicitud');
                });
            } else {
                toastr.error('ERROR: Selecciona una sección');
            }
        }

        BuscarInformacionCerrarSolicitudMtto = (url) => {
            var seccion = $('#nombre_seccion_consultar').val();
            if (seccion.length > 0) {
                var datos = $.ajax({
                    url: url,
                    type: "post",
                    dataType: "json",
                    data: {
                        seccion
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                datos.done((res) => {
                    if (res.status == true) {
                        document.getElementById('respuesta-cerrar-solicitud-mantenimiento').innerHTML = res.data;
                    }
                });
                datos.fail(() => {
                    toastr.error('Hubo un problema al procesar la solicitud');
                });
            } else {
                toastr.error('ERROR: Selecciona una sección');
            }
        }

        ModalCerrarSolicitudMtto = (id_solicitud, url) => {
            $('#Modal-cerrar-solicitud-mantenimiento').modal('show');
            var datos = $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: {
                    id_solicitud
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    document.getElementById('respuesta-modal-solicitud-mtto').innerHTML = res.data;
                }
            });
            datos.fail(() => {
                toastr.error('Hubo un problema al procesar la solicitud');
            });
        }

        CerrarSolicitudMttoAdmin = (url) => {
            toastr.info('Cerrando solicitud...');

            var responsable = $('#responsable_cerrar').val();
            var fecha_fin = $('#fecha_cerrar_fin').val();
            var id_solicitud = $('#id_cerrar_solicit_mtto').val();

            if (fecha_fin.length > 0 && responsable.length > 0) {
                var datos = $.ajax({
                    url: url,
                    type: "post",
                    dataType: "json",
                    data: {
                        id_solicitud,
                        responsable,
                        fecha_fin
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                datos.done((res) => {
                    if (res.status == true) {
                        $('#btn-cerrar-mmto' + res.id_solicitud).prop('disabled', true);
                        $('#Modal-cerrar-solicitud-mantenimiento').modal('hide');
                        $('#btn-actualizar-mtto-fab').click();
                        toastr.success('Información actualizada');
                    }
                });
                datos.fail(() => {
                    toastr.error('Hubo un problema al procesar la solicitud');
                });
            } else {
                toastr.error('Error al procesar la solicitud');
            }
        }
    </script>
@endsection
