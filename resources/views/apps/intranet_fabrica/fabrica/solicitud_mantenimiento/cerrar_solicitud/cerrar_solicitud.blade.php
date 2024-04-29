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
@section('active-sub-mantenimiento-cerrar')
    active
@endsection
@section('tables-bootstrap-css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
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
                    <strong>Cerrar solicitudes mantenimiento</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <div class="callout callout-danger">
                                <div class="row">
                                    <div class="col-md-9 mb-3">
                                        <div class="form-group">
                                            <label for="">Sección</label>
                                            <select name="nombre_seccion_consultar" id="nombre_seccion_consultar" class="form-control">
                                                <option value="">Seleccionar...</option>
                                                @foreach ($secciones as $key => $value)
                                                    <option value="{{ $value->nombre_seccion }}">{{ $value->nombre_seccion }}</option>
                                                @endforeach
                                                <option value="CORTE Y COSTURA">CORTE Y COSTURA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3" style="margin-top: 3.1%">
                                        <button class="btn btn-danger" id="btn-actualizar-mtto-fab"
                                            onclick="BuscarInformacionCerrarSolicitudMtto('{{ route('cerrar.informacion') }}')">Consultar
                                            información</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-5">
                            <div class="card card-outline card-danger">
                                <div class="card-body">
                                    <div>
                                        <table class="table table-bordered table-sm" id="TableCerrarSolicitudesMtt">
                                            <thead style="background-color: rgb(177, 5, 5); color: white">
                                                <tr class="text-center">
                                                    <td>#</td>
                                                    <td>Máquina</td>
                                                    <td>Solicitud</td>
                                                    <td>Fecha</td>
                                                    <td>Acción</td>
                                                </tr>
                                            </thead>
                                            <tbody id="respuesta-cerrar-solicitud-mantenimiento">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <div class="modal fade" id="Modal-cerrar-solicitud-mantenimiento">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(177, 5, 5); color: white">
                    <h4 class="modal-title">Cerrar solicitud de mantenimiento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" class="was-validated">
                        <div class="row" id="respuesta-modal-solicitud-mtto"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-outline card-danger ">
                                    <div class="card-header">
                                        Definir
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Fecha devolución</label>
                                                    <input type="date" class="form-control" name="fecha_cerrar_fin" id="fecha_cerrar_fin"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Responsable</label>
                                                    <input type="text" class="form-control" name="responsable_cerrar" id="responsable_cerrar"
                                                        placeholder="Nombre del responsable" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-left">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar informacion</button>
                    <button type="button" class="btn btn-success" onclick="CerrarSolicitudMttoAdmin('{{ route('cerrar.solicitud.admin') }}')">Definir
                        solicitud mantenimiento</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
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
