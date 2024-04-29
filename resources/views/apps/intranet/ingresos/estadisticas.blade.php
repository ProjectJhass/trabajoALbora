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
@section('estadisticas')
    bg-secondary active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Estadísticas</h4>
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
            <div class="row mb-5">
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


            <div class="row mb-3">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $diarios }}</h3>

                            <p>Ingresos diarios</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <a href="#" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $diarios > 0 ? round(($tarde * 100) / $diarios) : 0 }}<sup style="font-size: 20px">%</sup></h3>

                            <p>Llegadas tarde</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <a href="#" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $inasistencias[0]['inasistencia'] }}</h3>
                            <p>Inasistencias</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-times"></i>
                        </div>
                        <a href="#" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $empleados }}</h3>

                            <p>Total empleados</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Llegadas tarde</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="LlegadasTarde" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Inasistencias</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="Inasistencias" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Novedades</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="Novedades" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script>
        $(() => {
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

            var DataLlegadasTarde = {
                labels: [
                    'Puntual',
                    'Llegadas tarde',
                ],
                datasets: [{
                    data: [{{ $temprano }}, {{ $tarde }}],
                    backgroundColor: ['#00a65a', '#b30b0b'],
                }]
            };

            var DataInasistencias = {
                labels: [
                    'Asistencia',
                    'Inasistencia',
                ],
                datasets: [{
                    data: [
                        <?php foreach ($inasistencias as $key => $value) {
                            echo $value['asistencia'] . ',' . $value['inasistencia'];
                        } ?>
                    ],
                    backgroundColor: ['#00a65a', '#b30b0b'],
                }]
            };

            var DataNovedades = {
                labels: [
                    'Novedades'
                ],
                datasets: [{
                    data: [
                        <?php echo $novedades; ?>
                    ],
                    backgroundColor: ['#b30b0b'],
                }]
            };

            var LlegadasTarde = $('#LlegadasTarde').get(0).getContext('2d');
            var Inasistencias = $('#Inasistencias').get(0).getContext('2d');
            var Novedades = $('#Novedades').get(0).getContext('2d');

            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
            };
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            var pieDataTarde = DataLlegadasTarde;

            new Chart(LlegadasTarde, {
                type: 'pie',
                data: pieDataTarde,
                options: pieOptions
            });

            var pieDataInasis = DataInasistencias;
            new Chart(Inasistencias, {
                type: 'pie',
                data: pieDataInasis,
                options: pieOptions
            });

            var pieDataNoved = DataNovedades;
            new Chart(Novedades, {
                type: 'pie',
                data: pieDataNoved,
                options: pieOptions
            });
        });
    </script>
@endsection
