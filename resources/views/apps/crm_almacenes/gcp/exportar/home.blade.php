@extends('apps.crm_almacenes.gcp.plantilla.app')
@section('title')
    Exportar información
@endsection
@section('header')
@endsection
@section('exportar')
    active
@endsection
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Exportar Información CRM</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">CRM</li>
                        <li class="breadcrumb-item active">Exportar Información</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-md-center ">
                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                        <div id="daterange" class="pull-left form-control"
                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                            <span></span> <b class="caret"></b>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Almacen</div>
                        </div>
                        <select class="form-control" name="almacen_co" id="almacen_co"
                            onchange=" ConsultarAsesoresCo(this.value)">
                            <option value="">Seleccionar...</option>
                            @foreach ($sucursales as $item)
                                <option value="{{ $item->co }}">
                                    {{ str_replace('Muebles Albura SAS ', '', $item->nombre_sucursal) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Asesor</div>
                        </div>
                        <select class="form-control" name="asesor_co" id="asesor_co" onchange="filtrarInformacion()">
                            <option value="" data-nombre="">Seleccionar...</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-wrap flex-column justify-content-center align-items-center p-2 pt-4 w-100" id="informacion">
                {!! $informacion !!}
            </div>
        </div>
    </div>
@endsection
<style>

    .excel {
        filter: invert(38%) sepia(100%) saturate(343%) hue-rotate(96deg) brightness(91%) contrast(93%);
    }
</style>
@section('footer')
    <script>
        $(document).ready(function(){
            filtrarInformacion();
        })
        var start =  moment().startOf('month');
        var end = moment();

        moment.locale('es');

        function cb(start, end) {
            $('#daterange span').html(start && end ? start.format('YYYY-MM-D') + ' hasta ' + end.format('YYYY-MM-D') :
                'Selecciona un rango de fechas');
        }

        $('#daterange').daterangepicker({
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
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                    'Octubre',
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
                'Último mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                    'month')]
            }
        }, cb);

        cb(start, end);

        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            filtrarInformacion()
        });
        $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
            $('#daterange').val('');
            $('#daterange span').html('Selecciona un rango de fechas');
        })
        $('#almacen_co').change(function(){
            $('#asesor_co').val('');
            filtrarInformacion();
        })
        filtrarInformacion = () => {
            var fecha_i = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var fecha_f = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
            var almacen = $('#almacen_co').val();
            var asesor = $('#asesor_co').val();
            var datos = $.ajax({
                url: "{{ route('crm.filtrar.info') }}",
                type: "get",
                dataType: "json",
                data: {
                    fecha_i,
                    fecha_f,
                    almacen,
                    asesor
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            datos.done((res) => {
                document.getElementById('informacion').innerHTML = res.informacion;
            })

        }
    </script>
@endsection
