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
                    <strong>Dar solución a solicitud de mantenimiento</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <div class="card card-outline card-danger">
                                <div class="card-body">
                                    <div>
                                        <table class="table table-bordered table-sm" id="TableSolicitudesMttoPendientes">
                                            <thead style="background-color: rgb(177, 5, 5); color: white">
                                                <tr class="text-center">
                                                    <td>#</td>
                                                    <td>Máquina</td>
                                                    <td>Solicitud</td>
                                                    <td>Sección</td>
                                                    <td>Fecha</td>
                                                    <td>Acción</td>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                @foreach ($solicitudes as $item)
                                                    <tr>
                                                        <td>{{ $item->id_solicitud }}</td>
                                                        <td class="text-left">{{ $item->maquina }}</td>
                                                        <td class="text-left">{{ $item->solicitud }}</td>
                                                        <td>{{ $item->seccion }}</td>
                                                        <td>{{ $item->fecha_solicitud }}</td>
                                                        <td><button class="btn btn-danger btn-sm"
                                                                onclick="ResponderSolicitudMantenimiento('{{ $item->id_solicitud }}','{{ route('verificar.info.mtto') }}')"><i
                                                                    class="fas fa-edit"></i></button></td>
                                                    </tr>
                                                @endforeach
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



    <div class="modal fade" id="Modal-seguimiento-solicitud-mantenimiento">
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
                                        Dar solución
                                    </div>
                                    <div class="card-body">
                                        <div id="informacion-general-solicitud-mtto"></div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="">Solución</label>
                                                    <textarea name="solucion-propuesta-solicitud-mtto" id="solucion-propuesta-solicitud-mtto" class="form-control" cols="30" rows="1"
                                                        placeholder="Solución brindada" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Responsable</label>
                                                    <input type="text" class="form-control" name="responsable_solucionar-mtto"
                                                        id="responsable_solucionar-mtto" placeholder="Nombre del responsable" required>
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
                    <button type="button" class="btn btn-success" onclick="DarSolucionSolicituMtto('{{ route('dar.solucion.mtto') }}')">Dar solución
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
            $('#TableSolicitudesMttoPendientes').DataTable({
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

        ResponderSolicitudMantenimiento = (id_solicitud, url) => {

            $('#Modal-seguimiento-solicitud-mantenimiento').modal('show');

            var datos = $.ajax({
                type: "POST",
                url: url,
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
                    document.getElementById('informacion-general-solicitud-mtto').innerHTML = res.valores;
                }
            });
            datos.fail(() => {
                toastr.error('ERROR: Hubo un proble al procesar la solicitud');
            });
        }

        DarSolucionSolicituMtto = (url) => {
            Swal.fire({
                title: 'Seguro de dar solución a esta solicitud?',
                text: "No podrás reversar esta operación!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, emitir concepto',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var response = ConfirmarActualizarSolucionMtto(url);
                    response.done((res) => {
                        if (res.status == true) {
                            Swal.fire(
                                'EXCELENTE!',
                                'Solicitud solucionada',
                                'success'
                            )
                            setTimeout(() => {
                                location.reload();
                            }, 1100);
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
            })
        }

        ConfirmarActualizarSolucionMtto = (url) => {
            var solucion = $('#solucion-propuesta-solicitud-mtto').val();
            var responsable = $('#responsable_solucionar-mtto').val();
            var id_solicitud = $('#id_solicitud_mtto_res').val();

            var datos = $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                data: {
                    id_solicitud,
                    solucion,
                    responsable
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            return datos;
        }
    </script>
@endsection
