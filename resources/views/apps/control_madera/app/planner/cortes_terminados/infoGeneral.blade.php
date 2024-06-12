@extends('apps.control_madera.plantilla.app')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('p.corte.terminado')
    active
@endsection
@section('body')
    <div class="row mt-4 justify-content-center">
        <div class="col-md-4 mt-5 col-lg-4">
            <div class="row row-cols-1">
                <div class="overflow-hidden">
                    <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                        <li class="swiper-slide card alert-top card-slide" data-aos="fade-up" data-aos-delay="200">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p class="mb-2">Fecha</p>
                                            </div>
                                            <div class="col-md-9">
                                                <div id="dateRangePlanner" class="pull-left form-control"
                                                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                                    <i class="fa fa-calendar"></i>
                                                    <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p class="mb-2">Reporte</p>
                                            </div>
                                            <div class="col-md-9">
                                                <select name="txtTipoReporteCorte" id="txtTipoReporteCorte" onchange="buscarInformacionCortes()"
                                                    class="form-control">
                                                    <option value="series">Corte de series</option>
                                                    <option value="tablas">Corte de tablas</option>
                                                </select>
                                            </div>
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
        <div class="col-md-12">
            <div class="card alert-top alert-danger" data-aos="fade-up" data-aos-delay="300">
                <div class="card-header">
                    <h5>Cortes terminados</h5>
                </div>
                <div class="card-body table-responsive" id="infoGeneralTableCortesTerminados">
                    {!! $tableCorteTerminado !!}
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function() {
            formatterTable()

            var start = moment().subtract(29, 'days');
            var end = moment();

            moment.locale('es');

            function cb(start, end) {
                $('#dateRangePlanner span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#dateRangePlanner').daterangepicker({
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

            $('#dateRangePlanner').on('apply.daterangepicker', function(ev, picker) {
                buscarInformacionCortes()
            });
        });

        buscarInformacionCortes = () => {
            var fecha_i = $('#dateRangePlanner').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var fecha_f = $('#dateRangePlanner').data('daterangepicker').endDate.format('YYYY-MM-DD');
            var reporte = $('#txtTipoReporteCorte').val()

            var datos = $.ajax({
                url: "{{ route('search.madera.completado') }}",
                type: "post",
                dataType: "json",
                data: {
                    fecha_i,
                    fecha_f,
                    reporte
                }
            })
            datos.done((res) => {
                document.getElementById('infoGeneralTableCortesTerminados').innerHTML = res.table
                formatterTable()
            })

        }

        formatterTable = () => {
            $('#datatableMadera').DataTable({
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
    </script>
@endsection
