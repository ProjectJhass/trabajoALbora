@extends('apps.intranet.plantilla.app')
@section('title')
    Ingresos y Salidas
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('menu-ingresos')
    menu-open
@endsection
@section('section-menu')
    bg-danger active
@endsection
@section('diarios')
    bg-secondary active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Ingresos diarios</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Ingresos y salidas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="input-group">
                        <select name="centro_de_operacion" id="centro_de_operacion" class="form-control">
                            <option value="">Seleccionar...</option>
                            <option value="002">002 - Armenia</option>
                            <option value="004">004 - Ibague</option>
                            <option value="006">006 - P.Plaza</option>
                            <option value="007">007 - Cartago</option>
                            <option value="008">008 - Dosquebradas</option>
                            <option value="010">010 - Pereira</option>
                            <option value="011">011 - Girardot</option>
                            <option value="012">012 - Neiva</option>
                            <option value="014">014 - Pereira</option>
                            <option value="017">017 - Manizales</option>
                            <option value="020" selected>020 - Of Ppal</option>
                            <option value="025">025 - Ibague</option>
                            <option value="027">027 - Girardot</option>
                            <option value="028">028 - Pereira</option>
                            <option value="036">036 - Cali</option>
                        </select>
                        <input type="text" class="form-control float-right" value="{{ $fecha_i . ' / ' . $fecha_f }}" name="fechas_estadisticas" id="fechas_estadisticas">
                        <button class="btn btn-success" type="button" onclick="ValidarSesionesEstadisticas()">Consultar</button>
                    </div>
                </div>
            </div>
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    Ingresos diarios
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm" id="UsuariosIngresosDiarios">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Cédula</th>
                                <th>Nombre</th>
                                <th>Fecha</th>
                                <th>Hora ingreso</th>
                                <th>Hora salida</th>
                                <th>Hora re-ingreso</th>
                                <th>Hora re-salida</th>
                            </tr>
                        </thead>
                        <tbody class="text-center" style="font-size: 14px">
                            <?php $n = 0; ?>
                            @foreach ($info as $item)
                                <?php $n++; ?>
                                <tr>
                                    <td>{{ $n }}</td>
                                    <td class="text-left">{{ $item->id }}</td>
                                    <td class="text-left">{{ $item->nombre }}</td>
                                    <td>{{ $item->fecha_registro }}</td>
                                    <td>{{ $item->hora_ingreso }}</td>
                                    <td>{{ $item->hora_salida }}</td>
                                    <td>{{ $item->hora_reingreso }}</td>
                                    <td>{{ $item->hora_salida_reingreso }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
        $(function() {
            $('#centro_de_operacion').val('{{ $co_ }}');
            $('#fechas_estadisticas').daterangepicker({
                "locale": {
                    "format": "YYYY-MM-DD",
                    "separator": " / ",
                    "applyLabel": "Aplicar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "De",
                    "toLabel": "Até",
                    "customRangeLabel": "Custom",
                    "daysOfWeek": [
                        "Dom",
                        "Lun",
                        "Mar",
                        "Mier",
                        "Jue",
                        "Vie",
                        "Sab"
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
                    "firstDay": 0
                }
            });
            $('#UsuariosIngresosDiarios').DataTable({
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
    </script>
@endsection
