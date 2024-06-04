@extends('apps.control_madera.plantilla.app')
@section('head')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .tag {
            background: #b60202 !important;
        }

        .tag:after {
            border-left: 11px solid #b60202 !important;
        }
    </style>
@endsection
@section('h.printer')
    active
@endsection
@section('body')
    <div class="row mt-4 justify-content-center">
        <div class="col-md-4 mt-5 col-lg-4">
            <div class="row row-cols-1">
                <div class="overflow-hidden">
                    <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                        <li class="swiper-slide card card-slide alert-top" data-aos="fade-up" data-aos-delay="200">
                            <div class="card-body">
                                <div class="progress-widget">
                                    <div class="progress-detail">
                                        <p class="mb-2">Filtro por fecha</p>
                                        <div id="reportrange" class="pull-left form-control"
                                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                            <i class="fa fa-calendar"></i>
                                            <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card alert-top alert-danger" data-aos="fade-up" data-aos-delay="300">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h5 class="card-title">Historial de etiquetas impresas</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap5">
                            <div class="table-responsive border-bottom my-3" id="timeline-printer">
                                {!! $history !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalEditarInformacionHistory" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="exampleModalFullscreenLabel">Consecutivos impresos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewEditHistory"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-gray" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        formatearTable = () => {
            $('#datatable').DataTable({
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
        }

        $(function() {

            formatearTable()

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                locale: {
                    format: 'DD/MM/YYYY',
                    applyLabel: 'Aplicar',
                    cancelLabel: 'Cancelar',
                    fromLabel: 'Desde',
                    toLabel: 'Hasta',
                    customRangeLabel: 'Personalizado',
                    daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
                        'Noviembre', 'Diciembre'
                    ],
                    firstDay: 1
                },
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
                    'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
                    'Este mes': [moment().startOf('month'), moment().endOf('month')],
                    'Último mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

            $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
                var fecha_i = picker.startDate.format('YYYY-MM-DD')
                var fecha_f = picker.endDate.format('YYYY-MM-DD')

                var datos = $.ajax({
                    url: "{{ route('search.history.printer') }}",
                    type: "post",
                    dataType: "json",
                    data: {
                        fecha_i,
                        fecha_f
                    }
                })
                datos.done((res) => {
                    document.getElementById('timeline-printer').innerHTML = res.history
                    formatearTable()
                })

            });

        });

        printInfoImpresiones = (id) => {
            var url_p = "{{ route('print.history.info', ['id' => 'ID_PRINT_MADERA']) }}"
            url_p = url_p.replace("ID_PRINT_MADERA", id)
            var ventana = window.open(url_p, "Inspección de madera Albura", "width=720, height=640");

            ventana.onload = function() {
                ventana.print();
            };

            ventana.addEventListener("afterprint", function(event) {
                ventana.close();
            });
        }

        EditInformacionEtiquetas = (id) => {
            $('#ModalEditarInformacionHistory').modal('show')
            var datos = $.ajax({
                url: "{{ route('edit.history.printed') }}",
                type: "post",
                dataType: "json",
                data: {
                    id
                }
            })
            datos.done((res) => {
                document.getElementById('viewEditHistory').innerHTML = res.view
            })
        }

        editInfoHistory = (accion, id) => {
            var subproceso = ""
            var placa = ""
            var conducto = ""
            var ancho = 0
            var grueso = 0
            var largo = 0

            if (accion == 2) {
                ancho = $("#ancho" + id).val()
                grueso = $("#grueso" + id).val()
                largo = $("#largo" + id).val()
                var pulgadas_ = (ancho * grueso) * (largo / 3)
                $('#pulgadas' + id).text(Math.round(pulgadas_))
            } else {
                subproceso = $("#subproceso" + id).val()
                placa = $("#placa" + id).val()
                conducto = $("#conducto" + id).val()
            }

            var datos = $.ajax({
                url: "{{ route('edit.info.printed') }}",
                type: "post",
                dataType: "json",
                data: {
                    id,
                    accion,
                    subproceso,
                    placa,
                    conducto,
                    ancho,
                    grueso,
                    largo
                }
            })
        }
    </script>
@endsection
