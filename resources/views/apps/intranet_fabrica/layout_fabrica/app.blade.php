<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fábrica - @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('img/alburac.png') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/bs-stepper/css/bs-stepper.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    @yield('tables-bootstrap-css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: rgb(201, 0, 0)">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" style="color: white;" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <span class="nav-link text-white">FÁBRICA MUEBLES ALBURA S.A.S</span>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" role="button" href="{{ route('home') }}">
                        <span class="text-white">Salir</span>&nbsp;
                        <i class="fas fa-sign-out-alt" style="color: white;"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-light-dark elevation-4">
            <a href="{{ route('home.intranet.fabrica') }}" class="brand-link" style="background-color: rgb(201, 0, 0)">
                <img src="{{ asset('img/casa.png') }}" alt="Logo Albura" class="brand-image ">
                <span class="brand-text text-white">Muebles Albura</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('home.intranet.fabrica') }}" class="nav-link @yield('active-inicio')">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Inicio
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="https://app-mueblesalbura.com/Albura-Nexus/login/" target="_BLANK" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Albura Nexus
                                </p>
                            </a>
                        </li>
                        <li class="nav-item @yield('menu-prod')">
                            <a href="#" class="nav-link @yield('active')">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Producción
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('documentacion.tec.fab') }}" class="nav-link @yield('active-sub-doc')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Documentación técnica</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="http://192.168.1.84:6654/reloj-fabrica/login/" target="_BLANK" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Reloj Albura</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('cambios.serie.fab') }}" class="nav-link @yield('active-sub-cambios')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cambios en serie</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://app-mueblesalbura.com/RELOJ_BOVEL/menushornos.php" target="_BLANK" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Control de hornos</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item @yield('menu-calidad')">
                            <a href="#" class="nav-link @yield('active-calidad')">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Calidad
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon far fa-comment-dots"></i>
                                        <p>
                                            P.Q.R.S
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="https://app-mueblesalbura.com/pqrs_fabrica/formulario/" target="_BLANK" class="nav-link">
                                                <i class="fab fa-wpforms nav-icon"></i>
                                                <p>Formulario</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="https://app-mueblesalbura.com/pqrs_fabrica/login/" target="_BLANK" class="nav-link">
                                                <i class="fas fa-code-branch nav-icon"></i>
                                                <p>Responder solicitud</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('encuesta.satisfaccion.fab') }}" class="nav-link @yield('active-sub-encuesta')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Encuesta satisfacción</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('docs.sgc') }}" class="nav-link @yield('active-sub-sgc')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>SGC</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item @yield('menu-mtto')">
                            <a href="#" class="nav-link @yield('active-mtto')">
                                <i class="fas fa-tools"></i>
                                <p>
                                    Mantenimientos
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('maquinas.mantenimiento') }}" class="nav-link @yield('active-gestion-mantenimientos')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Gestion mantenimientos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('hojas.vida') }}" class="nav-link @yield('hojas-de-vida')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Hojas de vida</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('no.historial') }}" class="nav-link @yield('active-no-anexos')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Historial no anexos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('menu.solicitud') }}" class="nav-link @yield('active-sub-mantenimiento')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Solicitud Mtto</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('mtto.cerrar') }}" class="nav-link @yield('active-sub-mantenimiento-cerrar')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cerrar solicitud Mtto</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @if (Auth::user()->rol_user == 1)
                            <li class="nav-item @yield('menu-usuarios')">
                                <a href="#" class="nav-link @yield('active-usuarios')">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Usuarios
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('usuarios.fabrica') }}" class="nav-link @yield('active-sub-usuarios')">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Usuarios</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('listado.usuarios') }}" class="nav-link @yield('active-sub-user-encuesta')">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Usuarios encuesta</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('referencia.producto') }}" class="nav-link @yield('active-sub-referencias')">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Agregar referencia</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('maquinas.fab') }}" class="nav-link @yield('active-sub-maquinas')">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Maquinas</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('albura.carrucel') }}" class="nav-link @yield('active-sub-carrucel')">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Imágenes</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">
            <noscript>
                Para utilizar las funcionalidades completas de este sitio es necesario tener
                JavaScript habilitado. Aquí están las <a href="https://www.enable-javascript.com/es/">
                    instrucciones para habilitar JavaScript en tu navegador web</a>.
            </noscript>
            @yield('fabrica-body')
        </div>
    </div>
</body>
<footer>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }} "></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }} "></script>
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }} "></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }} "></script>
    <script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }} "></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }} "></script>
    <script src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }} "></script>
    <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }} "></script>
    <script src="{{ asset('plugins/bs-stepper/js/bs-stepper.min.js') }} "></script>
    <script src="{{ asset('plugins/dropzone/min/dropzone.min.js') }} "></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    @yield('scripts')
</footer>

</html>
