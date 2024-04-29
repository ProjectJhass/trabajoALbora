@extends('apps.servicios_tecnicos.plantilla.app')
@section('head')
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
                        <select name="" id="" class="btn btn-sm btn-outline-primary" onchange="actualizarInfoGrafica('1', this.value)"
                            type="button">
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
                                        <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-cart-alt"></i></span>
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
                        <select name="" id="" class="btn btn-sm btn-outline-primary" onchange="actualizarInfoGrafica('2', this.value)"
                            type="button">
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
                                    <img src="../assets/img/icons/unicons/wallet.png" alt="User" />
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
    </div>
@endsection
@section('footer')
    <script>
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
                        categories: ['', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
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
    </script>
@endsection
