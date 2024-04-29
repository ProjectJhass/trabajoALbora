@extends('apps.servicios_tecnicos.plantilla.app')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <style>
        .swal2-container {
            z-index: 10000 !important;
        }
    </style>
@endsection
@section('pwb')
    active
@endsection
@section('body')
    <div class="nav-align-top mb-4">
        <ul class="nav nav-tabs nav-fill" role="tablist">
            <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-home"
                    aria-controls="navs-justified-home" aria-selected="true">
                    <i class="tf-icons bx bx-home me-1"></i><span class="d-none d-sm-block">Solicitudes página web</span>
                </button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                <div id="info-table-solicitudes-web">
                    @php
                        echo $table;
                    @endphp
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasStart" style="min-width: 650px" aria-labelledby="offcanvasStartLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasStartLabel" class="offcanvas-title text-center">TICKET **<span id="txt-ticket"></span>**</h5>
                <button type="button" id="offcanvasBtnClose" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="divider">
                    <div class="divider-text">Información personal</div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="" class="text-muted">Cédula</label>
                        <p id="txt-web-id-user" hidden></p>
                        <p id="txt-cedula"></p>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="text-muted">Nombre</label>
                        <p id="txt-nombre"></p>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="text-muted">Telefono</label>
                        <p id="txt-telefono"></p>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="text-muted">Email</label>
                        <p id="txt-email"></p>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="text-muted">Categoría</label>
                        <p id="txt-categoria"></p>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="text-muted">Fecha</label>
                        <p id="txt-fecha"></p>
                    </div>
                    <div class="col-md-12">
                        <label for="" class="text-muted">Daño reportado</label>
                        <p id="txt-obs"></p>
                    </div>
                </div>
                <div class="btn-toolbar demo-inline-spacing" style="justify-content: center" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group" role="group" aria-label="First group">
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="CrearServicioWeb()" title="Crear Nueva OST">
                            <i class="tf-icons bx bx-check-shield"></i> Crear Orden de servicio
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarSolicitudWeb()" title="Eliminar">
                            <i class="tf-icons bx bx-trash-alt"></i> Eliminar
                        </button>
                    </div>
                </div>
                <div class="divider">
                    <div class="divider-text">Evidencias fotográficas</div>
                </div>
                <div class="row" id="fotografias-ost-web"></div>
                <div class="divider">
                    <div class="divider-text">Video</div>
                </div>
                <div class="row" id="video-ost-web"></div>
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
        $(document).ready(function() {
            setupTable();
        })

        setupTable = () => {
            $('#tableStSolicitadosWeb').DataTable({
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

        visualizarInfoStPw = (id_ost) => {
            var datos = $.ajax({
                url: "{{ route('search.info.pw') }}",
                type: "post",
                dataType: "json",
                data: {
                    id: id_ost
                }
            });
            datos.done((res) => {
                document.getElementById('txt-web-id-user').innerHTML = id_ost
                document.getElementById('txt-ticket').innerHTML = res.data.n_ticket
                document.getElementById('txt-cedula').innerHTML = res.data.cedula_cliente
                document.getElementById('txt-nombre').innerHTML = res.data.nombre
                document.getElementById('txt-telefono').innerHTML = res.data.telefono
                document.getElementById('txt-email').innerHTML = res.data.email
                document.getElementById('txt-categoria').innerHTML = res.data.articulo
                document.getElementById('txt-fecha').innerHTML = res.data.fecha
                document.getElementById('txt-obs').innerHTML = res.data.descripcion_servicio
                document.getElementById('fotografias-ost-web').innerHTML = res.img
                document.getElementById('video-ost-web').innerHTML = res.vid
            })
        }

        eliminarSolicitudWeb = () => {
            Swal.fire({
                title: "Está seguro/a?",
                text: "No podrá reversar esta operación!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "No, cancelar"
            }).then((result) => {
                if (result.isConfirmed) {

                    var datos = confirmSolicitudWebEliminar()

                    datos.done((res) => {
                        Swal.fire({
                            title: "Eliminado!",
                            text: "Su registro ha sido eliminado",
                            icon: "success"
                        });

                        $('#offcanvasBtnClose').click()
                        document.getElementById('info-table-solicitudes-web').innerHTML = res.table
                        setupTable()
                    })

                    datos.fail(() => {
                        Swal.fire({
                            title: "Error!",
                            text: "¡Vuelve a intentar! Hubo un problema al procesar la solicitud",
                            icon: "error"
                        });
                    })
                }
            });
        }

        confirmSolicitudWebEliminar = () => {
            var solicitud_id_web = $('#txt-web-id-user').text()

            var datos = $.ajax({
                url: "{{ route('delete.info.pw') }}",
                type: "post",
                dataType: "json",
                data: {
                    id: solicitud_id_web
                }
            });

            return datos;
        }
    </script>
@endsection
