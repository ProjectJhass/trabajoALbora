<?php
$permisos_ingresos = ['30338591', '16357590', '1087997915', '52444253', '38670577', '1087993135', '42084244', '24581232', '31991990', '28554243', '39584824', '30314322'];
$permiso_general = ['16357590', '1087997915', '52444253', '38670577', '1087993135'];
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('img/alburac.png') }}" type="image/x-icon">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/main.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Incluir Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.css"
        integrity="sha512-ClXpwbczwauhl7XC16/EFu3grIlYTpqTYOwqwAi7rNSqxmTqCpE8VS3ovG+qi61GoxSLnuomxzFXDNcPV1hvCQ==" crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    @php
        $baseUrl = env('APP_BASE_URL', 'http://localhost');
    @endphp
    <style>
        .loader-wrapper {
            --line-width: 5px;
            --curtain-color: #f1faee;
            --outer-line-color: #ff0000;
            --middle-line-color: #7c7c7c;
            --inner-line-color: #000000;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
        }

        .loader {
            display: block;
            position: relative;
            top: 50%;
            left: 50%;
            /*   transform: translate(-50%, -50%); */
            width: 150px;
            height: 150px;
            margin: -75px 0 0 -75px;
            border: var(--line-width) solid transparent;
            border-top-color: var(--outer-line-color);
            border-radius: 100%;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            z-index: 1001;
        }

        .loader:before {
            content: "";
            position: absolute;
            top: 4px;
            left: 4px;
            right: 4px;
            bottom: 4px;
            border: var(--line-width) solid transparent;
            border-top-color: var(--inner-line-color);
            border-radius: 100%;
            -webkit-animation: spin 3s linear infinite;
            animation: spin 3s linear infinite;
        }

        .loader:after {
            content: "";
            position: absolute;
            top: 14px;
            left: 14px;
            right: 14px;
            bottom: 14px;
            border: var(--line-width) solid transparent;
            border-top-color: var(--middle-line-color);
            border-radius: 100%;
            -webkit-animation: spin 1.5s linear infinite;
            animation: spin 1.5s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        .loader-wrapper .loader-section {
            position: fixed;
            top: 0;
            background: #ffffff94;
            width: 51%;
            height: 100%;
            z-index: 1000;
        }

        .loader-wrapper .loader-section.section-left {
            left: 0
        }

        .loader-wrapper .loader-section.section-right {
            right: 0;
        }

        /* Loaded Styles */
        .loaded .loader-wrapper .loader-section.section-left {
            transform: translateX(-100%);
            transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
        }

        .loaded .loader-wrapper .loader-section.section-right {
            transform: translateX(100%);
            transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
        }

        .loaded .loader {
            opacity: 0;
            transition: all 0.3s ease-out;
        }

        .loaded .loader-wrapper {
            visibility: hidden;
            transform: translateY(-100%);
            transition: all .3s 1s ease-out;
        }
    </style>

    @yield('head')
</head>

<body class="hold-transition sidebar-mini layout-fixed loaded">

    <div class="loader-wrapper">
        <div class="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>

    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white" style="background-color: #c22121;">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <div class="nav-link text-white">Intranet Muebles Albura SAS</div>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> {{ __('Salir') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-light-light elevation-4">
            <div class="brand-link" style="background-color: #c22121;">
                <img src="{{ asset('img/ROJOc.png') }}" alt="Muebles Albura SAS" class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light text-white">Muebles Albura</span>
            </div>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link @yield('home')">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Inicio
                                </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('logistica') }}" class="nav-link @yield('logistica')">
                                <i class="nav-icon fas fa-truck"></i>
                                <p>
                                    Logística
                                </p>
                            </a>
                        </li>
                    </ul>
                    @if (Auth::user()->empresa != 'HAPPY SLEEP')
                        @if (Auth::user()->dpto_user != '8')
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <li class="nav-item">
                                    <a href="{{ route('cartera') }}" class="nav-link @yield('cartera')">
                                        <i class="nav-icon fas fa-money-check-alt"></i>
                                        <p>
                                            Cartera
                                        </p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <li class="nav-item">
                                    <a href="{{ route('ventas') }}" class="nav-link @yield('ventas')">
                                        <i class="nav-icon fas fa-shopping-cart"></i>
                                        <p>
                                            Ventas
                                        </p>
                                    </a>
                                </li>
                            </ul>

                            @if (Auth::user()->permisos == '4' || in_array(Auth::user()->id, $permisos_ingresos))
                                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                    <li class="nav-item @yield('menu-ingresos')" id="classMenuOpen" onclick="EliminarClase()">
                                        <a href="#" class="nav-link @yield('section-menu')">
                                            <i class="nav-icon fas fa-chart-pie"></i>
                                            <p>
                                                Ingresos y Salidas
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @if (Auth::user()->permisos == '4' || in_array(Auth::user()->id, $permiso_general))
                                                <li class="nav-item">
                                                    <a href="{{ route('estadisticas') }}" class="nav-link @yield('estadisticas')">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Estadísticas</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('i.diarios') }}" class="nav-link @yield('diarios')">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Ingresos diarios</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('l.tarde') }}" class="nav-link @yield('tarde')">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Llegadas tarde</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('inasistencias') }}" class="nav-link @yield('inasistencias')">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Inasistencias</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('novedades') }}" class="nav-link @yield('novedades')">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Novedades</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('dominicales') }}" class="nav-link @yield('dominicales')">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Dominicales y descansos</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('exportar') }}" class="nav-link @yield('exportar')">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Exportar información</p>
                                                    </a>
                                                </li>
                                            @endif
                                            <li class="nav-item">
                                                <a href="{{ route('r.novedad') }}" class="nav-link @yield('registrar_n')">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Registrar novedades</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            @endif
                            @if (Auth::user()->calendario == '1')
                                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                    <li class="nav-item">
                                        <a href="{{ route('calendar') }}" class="nav-link @yield('calendar')">
                                            <i class="nav-icon fas fa-calendar-alt"></i>
                                            <p>
                                                Calendario
                                            </p>
                                        </a>
                                    </li>
                                </ul>
                            @endif
                        @endif
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('rrhh') }}" class="nav-link @yield('rrhh')">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Recursos humanos
                                    </p>
                                </a>
                            </li>
                        </ul>
                        @if (Auth::user()->dpto_user != '8')
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <li class="nav-item">
                                    <a href="{{ route('auditoria') }}" class="nav-link @yield('auditoria')">
                                        <i class="nav-icon far fa-newspaper"></i>
                                        <p>
                                            Auditoría
                                        </p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <li class="nav-item">
                                    <a href="{{ route('contabilidad') }}" class="nav-link @yield('contabilidad')">
                                        <i class="nav-icon fas fa-hand-holding-usd"></i>
                                        <p>
                                            Contabilidad
                                        </p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <li class="nav-item">
                                    <a href="{{ route('sistemas') }}" class="nav-link @yield('sistemas')">
                                        <i class="nav-icon fas fa-tv"></i>
                                        <p>
                                            Sistemas
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        @endif
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('dev.bitacora', ['estado' => 'progreso']) }}" class="nav-link @yield('bitacora')">
                                    <i class="nav-icon fas fa-tasks"></i>
                                    <p>
                                        Bitacora
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('fabrica') }}" class="nav-link @yield('fabrica')">
                                    <i class="nav-icon fas fa-hotel"></i>
                                    <p>
                                        Fábrica
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ $baseUrl }}/tareas/public/login" target="_BLANK" class="nav-link">
                                    <i class="nav-icon fas fa-book"></i>
                                    <p>
                                        Tareas Albura
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ $baseUrl }}/Albura-Nexus/login/" target="_BLANK" class="nav-link">
                                    <i class="nav-icon fas fa-graduation-cap"></i>
                                    <p>
                                        Nexus
                                    </p>
                                </a>
                            </li>
                        </ul>
                        @if (Auth::user()->permisos == '4')
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <li class="nav-item">
                                    <a href="{{ route('usuarios') }}" class="nav-link @yield('usuarios')">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>
                                            Usuarios
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        @endif
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a onclick="enviarFormularioLoginAlbura()" type="button" class="nav-link">
                                    <i class="fas fa-rocket"></i>
                                    <p>Mesa de Ayuda </p>
                                    <form hidden id="autenticar-usuario-help_desk" enctype="multipart/form-data">
                                        @csrf
                                        <input name="usuario" id="usuario" value="{{ Auth::user()->usuario }}" type="text"
                                            placeholder="Usuario">
                                        <input name="password" id="password" value="{{ Auth::user()->id }}" type="password"
                                            placeholder="Contraseña">
                                    </form>
                                </a>
                            </li>
                        </ul>
                    @endif
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">@yield('body')</div>
    </div>
</body>
<footer>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    {{-- <script src="{{ asset('dist/js/demo.js') }}"></script> --}}
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar/main.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/index.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js"
        integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <script>
        loandingPanel = () => {
            document.querySelector('body').classList.remove("loaded")
        }

        loadedPanel = () => {
            document.querySelector('body').classList.add("loaded")
        }
    </script>
    @yield('footer')
</footer>

</html>
