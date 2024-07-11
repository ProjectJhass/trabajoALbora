@extends('apps.servicios_tecnicos.plantilla.app')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="./../../css/tiempos_respuesta.css">
    <link rel="stylesheet" href="./../../css/causalidades.css">
@endsection
@section('analytics')
    active
@endsection
@section('body')
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Items</h5>
                    </div>
                    <div class="text-center">
                        <select name="" id="" class="btn btn-sm btn-outline-primary"
                            onchange="actualizarInfoGrafica('1', this.value)" type="button">
                            <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                            <?php for ($i = 2019; $i < date('Y') + 1; $i++) { ?>
                            <option value="{{ $i }}">{{ $i }}</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-column align-items-center gap-1">
                            <h2 class="mb-2" id="cantidad-items-ost">{{ $cantidad }}</h2>
                            <span>Total items</span>
                        </div>
                        <div id="orderStatisticsChart"></div>
                    </div>
                    <ul class="p-0 m-0" id="items-mas-ost">
                        @php
                            $contador = 0;
                        @endphp
                        @foreach ($items as $item)
                            @php
                                $contador++;
                            @endphp
                            @if ($contador < 5)
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-secondary"><i
                                                class="bx bx-cart-alt"></i></span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">{{ $item->articulo }}</h6>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-medium">{{ $item->cantidad }}</small>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Variaciones en el año</h5>
                    </div>
                    <div class="text-center">
                        <select name="" id="" class="btn btn-sm btn-outline-primary"
                            onchange="actualizarInfoGrafica('2', this.value)" type="button">
                            <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                            <?php for ($i = 2019; $i < date('Y') + 1; $i++) { ?>
                            <option value="{{ $i }}">{{ $i }}</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="card-body px-0">
                    <div class="tab-content p-0">
                        <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                            <div class="d-flex p-4 pt-3">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="../../assets/img/icons/unicons/wallet.png" alt="User" />
                                </div>
                                <div>
                                    <small class="text-muted d-block">Total servicios técnicos</small>
                                    <div class="d-flex align-items-center">
                                        <h6 class="mb-0 me-1" id="total-ost-year">{{ $cantidad }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div id="incomeChart"></div>
                            <div class="d-flex justify-content-center pt-4 gap-2">
                                <div class="flex-shrink-0">
                                    <div id="expensesOfWeek"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="informesContainer" class="col-md mb-3">
            <div class="card h-100 mt-4">
                <div class="card-header d-flex align-items-center justify-content-between border-bottom w-100">
                    <h4 class="m-0">INFORMES: Ordenes de Servicio</h4>
                    <div class="filtrosContainer border border-top-0 border-bottom-0 w-50 px-4 pr-0">
                        <div class='fechasContainer d-flex align-items-center justify-content-betweeen'>
                            <input type='month' class='form-control' name='fecha_inicial' id='fecha_tiempos_i'
                                onchange="filtroFechasTiempos()">
                            <label class="mx-4" for=''>Hasta:</label>
                            <input type='month' class='form-control' name='fecha_final' id='fecha_tiempos_f'
                                onchange="filtroFechasTiempos()">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="causalidadesContainer" class="col-md mb-3">
                        <div class="card shadow-lg h-100 mt-4">
                            <div
                                class="card-header graph-header border-bottom d-flex justify-content-between align-items-center mb-4">
                                <div class="card-title d-flex align-items-center justify-content-center m-0">
                                    <h5 style="text-align: center; margin: 0;">Informe de Causalidades</h5>
                                </div>
                                <button id="exportarCausales" type="button" class="btn btn-sm btn-success text-nowrap"
                                    onclick="exportarExcel('causales')" title="Exportar">
                                    <i class="bx bxs-file-export"></i>
                                </button>
                            </div>
                            <div class="card-body" id="graficaCausalidades">
                                {!! $causalidades_graph !!}
                            </div>
                        </div>
                    </div>
                    <div id="tiemposRespuestContainer" class="col-md mb-3">
                        <div class="card shadow-lg h-100 mt-4">
                            <div class="card-header graph-header border-bottom d-flex align-items-center">
                                <div class="card-title d-flex align-items-center justify-content-center m-0">
                                    <h5 style="text-align: center; margin: 0;">Informe de Tiempos de Respuesta por Etapa
                                    </h5>
                                </div>
                                <style>
                                    .semaforo {
                                        height: 36px;
                                        box-sizing: border-box;
                                        padding: 2px;
                                        display: flex;
                                        flex-direction: row;
                                        background-color: rgb(48, 48, 48);
                                        border-radius: 10px;
                                    }

                                    .btn_semaforo {
                                        margin: 1px;
                                        border: none;
                                        box-shadow: 0 -2px;
                                        width: 30px;
                                        height: 30px;
                                        border-radius: 50%;
                                        filter: brightness(0.7);
                                    }

                                    .btn_semaforo:hover,
                                    .btn_semaforo:focus {
                                        filter: brightness(1);
                                    }
                                </style>
                                <div id="ordenServicioContainer">
                                    <input name="searchInputGraph" type="text" id="searchInputGraph"
                                        class="form-control border-0" placeholder="Buscar Orden de Servicio" required
                                        autocomplete="off" onchange="buscarGraficaODT()">
                                </div>
                                <div class="semaforo">
                                    <button class="btn_semaforo" onclick="filtroEstadosTiempos('peligro')" type="button"
                                        style="background-color: #ff3e1d;"></button>
                                    <button class="btn_semaforo" onclick="filtroEstadosTiempos('advertencia')"
                                        type="button" style="background-color: #e8b009;"></button>
                                    <button class="btn_semaforo" onclick="filtroEstadosTiempos('a_tiempo')"
                                        type="button" style="background-color: #62bd30;"></button>
                                </div>
                                <button type="button" class="btn btn-sm btn-success text-nowrap"
                                    onclick="exportarExcel('tiempos')" title="Exportar Excel">
                                    <i class="bx bxs-file-export"></i>
                                </button>
                            </div>
                            <div class="my-5">
                                <div class="steps-container" id="graficaTiemposRespuesta">
                                    @php
                                        echo $tiempos_graph;
                                    @endphp
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-5 d-none">
                                <div class="d-flex flex-column p-4 text-center">
                                    <div class="h-100 border rounded">
                                        <div id="inputContainer">
                                            <input name="searchInput" type="number" id="searchInput"
                                                class="form-control border-0" placeholder="Buscar Orden..." required
                                                autocomplete="off">
                                            <img id="sorting_icon"
                                                src="./../../assets/img/icons/unicons/sort-vertical.png" alt=""
                                                srcset="">
                                        </div>
                                        <div class="list-container ">
                                            <ul id="list" class="list-group">
                                                @foreach ($odts as $key)
                                                    <li class="item "> {{ $key['id_st'] }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body " id="infoTiemposRespuesta">
                                    @php
                                        echo $tiempos_table;
                                    @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('assets/js/ui-popover.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script src="https://unpkg.com/@popperjs/core@^2.0.0"></script>
    <script src="./../../js/tiempos_respuesta.js"></script>
    <script src="./../../js/causalidades.js"></script>
    <script>
        $(document).ready(function() {
            setupTable();
            loadTiemposGraph();
            loadCausalesGraph();
        })
        $(() => {
            var array_1 = @json($js);
            var array_2 = @json($periodico);
            render(array_1);
            renderG2(array_2);
        })
        let cardColor, headingColor, axisColor, shadeColor, borderColor;

        cardColor = config.colors.cardColor;
        headingColor = config.colors.headingColor;
        axisColor = config.colors.axisColor;
        borderColor = config.colors.borderColor;


        function render(dataArray) {

            var items = [];
            var cantidad = [];

            dataArray.forEach(element => {
                items.push(element.articulo);
                cantidad.push(element.cantidad);
            });

            const chartOrderStatistics = document.querySelector('#orderStatisticsChart'),
                orderChartConfig = {
                    chart: {
                        height: 165,
                        width: 130,
                        type: 'donut'
                    },
                    labels: items,
                    series: cantidad,
                    colors: [config.colors.primary, config.colors.secondary, config.colors.info, config.colors.success],
                    stroke: {
                        width: 5,
                        colors: [cardColor]
                    },
                    dataLabels: {
                        enabled: false,
                        formatter: function(val, opt) {
                            return parseInt(val) + '%';
                        }
                    },
                    legend: {
                        show: false
                    },
                    grid: {
                        padding: {
                            top: 0,
                            bottom: 0,
                            right: 15
                        }
                    },
                    states: {
                        hover: {
                            filter: {
                                type: 'none'
                            }
                        },
                        active: {
                            filter: {
                                type: 'none'
                            }
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '75%',
                                labels: {
                                    show: true,
                                    value: {
                                        fontSize: '1.5rem',
                                        fontFamily: 'Public Sans',
                                        color: headingColor,
                                        offsetY: -15,
                                        formatter: function(val) {
                                            return parseInt(val) + '%';
                                        }
                                    },
                                    name: {
                                        offsetY: 20,
                                        fontFamily: 'Public Sans'
                                    },
                                    total: {
                                        show: true,
                                        fontSize: '0.8125rem',
                                        color: axisColor,
                                        label: 'OST',
                                        formatter: function(w) {
                                            return '100%';
                                        }
                                    }
                                }
                            }
                        }
                    }
                };
            if (typeof chartOrderStatistics !== undefined && chartOrderStatistics !== null) {
                const statisticsChart = new ApexCharts(chartOrderStatistics, orderChartConfig);
                statisticsChart.render();
            }
        }

        function renderG2(periodico) {

            var dat_p = ['0'];

            periodico.forEach(item => {
                dat_p.push(item.cantidad)
            });

            const incomeChartEl = document.querySelector('#incomeChart'),
                incomeChartConfig = {
                    series: [{
                        data: dat_p
                    }],
                    chart: {
                        height: 250,
                        parentHeightOffset: 0,
                        parentWidthOffset: 0,
                        toolbar: {
                            show: false
                        },
                        type: 'area'
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2,
                        curve: 'smooth'
                    },
                    legend: {
                        show: false
                    },
                    markers: {
                        size: 6,
                        colors: 'transparent',
                        strokeColors: 'transparent',
                        strokeWidth: 4,
                        discrete: [{
                            fillColor: config.colors.white,
                            seriesIndex: 0,
                            dataPointIndex: 7,
                            strokeColor: config.colors.primary,
                            strokeWidth: 2,
                            size: 6,
                            radius: 8
                        }],
                        hover: {
                            size: 7
                        }
                    },
                    colors: [config.colors.primary],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: shadeColor,
                            shadeIntensity: 0.6,
                            opacityFrom: 0.5,
                            opacityTo: 0.25,
                            stops: [0, 95, 100]
                        }
                    },
                    grid: {
                        borderColor: borderColor,
                        strokeDashArray: 3,
                        padding: {
                            top: -20,
                            bottom: -8,
                            left: -10,
                            right: 8
                        }
                    },
                    xaxis: {
                        categories: ['', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov',
                            'Dic'
                        ],
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            show: true,
                            style: {
                                fontSize: '13px',
                                colors: axisColor
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            show: false
                        },
                        min: 10,
                        max: 200,
                        tickAmount: 4
                    }
                };
            if (typeof incomeChartEl !== undefined && incomeChartEl !== null) {
                const incomeChart = new ApexCharts(incomeChartEl, incomeChartConfig);
                incomeChart.render();
            }
        }

        function actualizarInfoGrafica(grafica, year) {
            var datos = $.ajax({
                url: "{{ route('analytics.search') }}",
                type: "post",
                dataType: "json",
                data: {
                    grafica,
                    year
                }
            });
            datos.done((res) => {
                switch (grafica) {
                    case '1':
                        render(res.data);
                        document.getElementById('items-mas-ost').innerHTML = res.items;
                        document.getElementById('cantidad-items-ost').innerHTML = res.cantidad;
                        break;
                    case '2':
                        renderG2(res.data);
                        document.getElementById('total-ost-year').innerHTML = res.cantidad;
                        break;
                }
            })
        }

        buscarOrdenST = (co) => {
            var datos = $.ajax({
                url: "{{ route('search.orden.st') }}",
                type: "POST",
                dataType: "json",
                data: {
                    co
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    document.getElementById('infoTiemposRespuesta').innerHTML = res.table;
                    setupTable();
                }
            });
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 1500
                })
            });
        }
        buscarGraficaODT = (co) => {
            var fecha_i = $('#fecha_tiempos_i').val();
            var fecha_f = $('#fecha_tiempos_f').val();
            fecha_i ? fecha_i += "-01" : null;
            fecha_f ? fecha_f = getLastDayOfMonth(fecha_f) : null;
            var datos = $.ajax({
                url: "{{ route('search.graph.st') }}",
                type: "POST",
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
                    document.getElementById('graficaTiemposRespuesta').innerHTML = res.graph;
                    loadTiemposGraph();
                }
            });
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 1500
                })
            });
        }
        filtroFechasTiempos = () => {
            var fecha_i = $('#fecha_tiempos_i').val();
            var fecha_f = $('#fecha_tiempos_f').val();
            fecha_i ? fecha_i += "-01" : null;
            fecha_f ? fecha_f = getLastDayOfMonth(fecha_f) : null;
            var datos = $.ajax({
                url: "{{ route('search.analytics.fechas') }}",
                type: "GET",
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
                document.getElementById('graficaCausalidades').innerHTML = res.causales
                loadCausalesGraph();
                document.getElementById('graficaTiemposRespuesta').innerHTML = res.tiempos
                loadTiemposGraph();
                // setupTable();
            });
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 1500
                })
            });
        }
        getLastDayOfMonth = (dateString) => {
            // Crear una nueva fecha con el primer día del mes siguiente
            let [year, month] = dateString.split('-').map(Number);
            let date = new Date(year, month, 0); // El día 0 del mes siguiente es el último día del mes actual

            // Formatear la fecha a YYYY-MM-dd
            let lastDay = date.getDate();
            let formattedMonth = month.toString().padStart(2, '0');
            let formattedDay = lastDay.toString().padStart(2, '0');

            return `${year}-${formattedMonth}-${formattedDay}`;
        }
        exportarExcel = (grafica) => {
            var fecha_i = $('#fecha_tiempos_i').val();
            var fecha_f = $('#fecha_tiempos_f').val();
            fecha_i ? fecha_i += "-01" : null;
            fecha_f ? fecha_f = getLastDayOfMonth(fecha_f) : null;
            let url;
            let title;
            if (grafica == "tiempos") {
                url = '{{ route('analytics.export.tiempos.respuesta.st') }}'
                title = "informe-tiempos-respuesta.xlsx";
            } else if (grafica == "causales") {
                url = '{{ route('analytics.export.causales.st') }}';
                title = "informe-causales.xlsx";
            }
            var datos = $.ajax({
                url: url,
                method: 'POST',
                data: {
                    fecha_i,
                    fecha_f
                },
                xhrFields: {
                    responseType: 'blob' // Permite recibir datos binarios (como archivos)
                },
                success: function(response, status, xhr) {
                    // Crear un objeto URL y descargar el archivo
                    var blob = new Blob([response]);
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = title;
                    link.click();
                },
                error: function(xhr, status, error) {
                    console.error('Error al exportar Excel:', error);
                }
            });
        }
        buscarArticulos = (causalidad) => {
            var fecha_i = $('#fecha_tiempos_i').val();
            var fecha_f = $('#fecha_tiempos_f').val();
            fecha_i ? fecha_i += "-01" : null;
            fecha_f ? fecha_f = getLastDayOfMonth(fecha_f) : null;
            $.ajax({
                url: "{{ route('search.article.st') }}",
                type: "GET",
                data: {
                    'causalidad': causalidad,
                    fecha_i,
                    fecha_f
                },
                dataType: "json",
                success: function(res) {
                    document.querySelector('.modal-body').innerHTML = res.data;
                    document.querySelector('.modal-title').innerHTML =
                        "<div class='fs-6 start-0'>Articulos bajo causal de:</div><div class='w-100 d-flex justify-content-center fs-3 align-items-center text-center'><div>" +
                        causalidad + "</div></div";
                },
                error: function(err) {
                    console.error(err);
                }
            })
        }
        filtroEstadosTiempos = (estado) => {
            var fecha_i = $('#fecha_tiempos_i').val();
            var fecha_f = $('#fecha_tiempos_f').val();
            fecha_i ? fecha_i += "-01" : null;
            fecha_f ? fecha_f = getLastDayOfMonth(fecha_f) : null;
            var datos = $.ajax({
                url: "{{ route('search.analytics.estado') }}",
                type: "POST",
                dataType: "json",
                data: {
                    fecha_i,
                    fecha_f,
                    estado
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                document.getElementById('graficaTiemposRespuesta').innerHTML = res.tiempos
                loadTiemposGraph();
                // setupTable();
            });
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 1500
                })
            });
        }
    </script>
@endsection
