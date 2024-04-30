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
@section('body')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h2>Historial de impresiones</h2>
            </div>
        </div>
        <div class="clearfix"></div>
        <div id="reportrange" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
            <i class="fa fa-calendar"></i>
            <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
        </div>
        <div class="clearfix"></div>
        <div class="page-body mt-4">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Información general de registro de madera</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <ul class="list-unstyled timeline" id="timeline-printer">
                        {!! $history !!}
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalEditarInformacionHistory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Información</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="viewEditHistory"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
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
