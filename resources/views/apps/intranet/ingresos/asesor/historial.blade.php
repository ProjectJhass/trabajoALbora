@extends('apps.intranet.plantilla.app')
@section('title')
    Calendario
@endsection
@section('calendar')
    bg-danger active
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Informe de firmas de descansos</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Calendario</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10 text-center">
                    <label>Rango de fechas</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control float-right rounded-0" value="{{ date('Y-m-01') . ' Hasta ' . date('Y-m-d') }}"
                            id="reservation">
                        <span class="input-group-append">
                            <button type="button" class="btn btn-danger btn-flat" onclick="ConsultarFechasDescansos()">Consultar</button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Historial
                </div>
                <div class="card-body" id="infoGeneralTableDescansos">
                    {!! $table !!}
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(() => {
            formatterTable()

            $('#reservation').daterangepicker({
                "locale": {
                    "format": "YYYY-MM-DD",
                    "separator": " Hasta ",
                    "applyLabel": "Aplicar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "Desde",
                    "toLabel": "Hasta",
                    "customRangeLabel": "Custom",
                    "daysOfWeek": [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                    "firstDay": 1
                }
            })
        })

        formatterTable = () => {
            $('#infoGeneralFirmasDescansos').DataTable({
                "oLanguage": {
                    "sSearch": "Buscar:",
                    "sInfo": "Mostrando _END_ de _TOTAL_ registros",
                    "oPaginate": {
                        "sPrevious": "Volver",
                        "sNext": "Siguiente"
                    },
                    "sEmptyTable": "No se encontró ningun registro en la base de datos",
                    "sZeroRecords": "No se encontraron resultados...",
                    "sLengthMenu": "Mostrar _MENU_ registros"
                },
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": false,
            });
        }

        ConsultarFechasDescansos = () => {
            loandingPanel()

            var fecha_i = $('#reservation').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var fecha_f = $('#reservation').data('daterangepicker').endDate.format('YYYY-MM-DD');

            var datos = $.ajax({
                url: "{{ route('firmas.asesor.fechas') }}",
                type: "POST",
                dataType: "json",
                data: {
                    fecha_i,
                    fecha_f
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                loadedPanel()
                document.getElementById('infoGeneralTableDescansos').innerHTML = res.table
                formatterTable()
            });
        }
    </script>
@endsection
