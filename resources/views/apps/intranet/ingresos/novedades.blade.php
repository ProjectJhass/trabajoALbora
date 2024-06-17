@extends('apps.intranet.plantilla.app')
@section('title')
    Ingresos y Salidas
@endsection
@section('menu-ingresos')
    menu-open
@endsection
@section('section-menu')
    bg-danger active
@endsection
@section('novedades')
    bg-secondary active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Novedades registradas</h4>
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
                        <input type="text" class="form-control float-right" value="{{ date('Y-m-d') . ' / ' . date('Y-m-d') }}"
                            name="fechas_estadisticas" id="fechas_estadisticas">
                        <button class="btn btn-success" type="button" onclick="consultarInfoNovedades()">Consultar</button>
                    </div>
                </div>
            </div>
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    Novedades de usuarios
                </div>
                <div class="card-body" id="infoGeneralNovedadesC">
                    {!! $table !!}
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script>
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

        consultarInfoNovedades = () => {
            var dateRangePicker = $('#fechas_estadisticas').data('daterangepicker');
            if (dateRangePicker.startDate && dateRangePicker.endDate) {
                var fecha_i = dateRangePicker.startDate.format('YYYY-MM-DD');
                var fecha_f = dateRangePicker.endDate.format('YYYY-MM-DD');
                var co = $('#centro_de_operacion').val()

                var datos = $.ajax({
                    type: "POST",
                    url: "{{ route('search.novedades') }}",
                    dataType: "json",
                    data: {
                        fecha_i,
                        fecha_f,
                        co
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                datos.done((res) => {
                    if (res.status == true) {
                        document.getElementById('infoGeneralNovedadesC').innerHTML = res.table
                    }
                })
            }
        }
    </script>
@endsection
