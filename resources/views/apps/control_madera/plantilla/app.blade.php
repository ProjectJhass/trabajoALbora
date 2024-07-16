<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control de madera</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/alburac.png') }} " />
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('estilos/assets/css/core/libs.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('estilos/assets/vendor/aos/dist/aos.css') }}" />
    <link rel="stylesheet" href="{{ asset('estilos/assets/css/hope-ui.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('estilos/assets/css/custom.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('estilos/assets/css/dark.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('estilos/assets/css/customizer.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('estilos/assets/css/rtl.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/pnotify/dist/pnotify.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/pnotify/dist/pnotify.buttons.css') }}">
    <style>
        .right_col {
            min-height: 50rem !important;
        }

        label {
            font-size: 14px !important;
            color: rgb(0, 0, 0);
        }

        .accordion-button {
            color: rgb(0, 0, 0) !important;
        }

        .sidebar .sidebar-toggle {
            right: -30px !important;
        }

        input {
            color: rgb(0, 0, 0) !important;
        }

        select {
            color: rgb(0, 0, 0) !important;
        }

        textarea {
            color: rgb(0, 0, 0) !important;
        }

        @media (max-width: 768px) {
            .sidebar .sidebar-header {
                justify-content: flex-end !important;
            }
        }
    </style>
    @yield('head')
</head>

<body class="theme-color-red loaded">
    <aside class="sidebar sidebar-default sidebar-base navs-pill sidebar-dark sidebar-mini">
        <div class="sidebar-header d-flex align-items-center justify-content-start">
            <div class="navbar-brand">
                <div class="logo-main">
                    <div class="logo-normal">
                        <img src="{{ asset('img/alburac.png') }}" width="50px" alt="Muebles Albura SAS">
                    </div>
                    <div class="logo-mini">
                        <img src="{{ asset('img/alburac.png') }}" width="20px" alt="Muebles Albura SAS">
                    </div>
                </div>
                <h6 class="logo-title">Muebles Albura SAS</h6>
            </div>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                        <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg>
                </i>
            </div>
        </div>
        <div class="sidebar-body pt-0 data-scrollbar">
            <div class="sidebar-list">
                <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">Control de madera</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                    @if (Auth::user()->permisos == '4' ||
                            Auth::user()->permiso_madera == '1' ||
                            Auth::user()->permiso_madera == '2' ||
                            Auth::user()->permiso_madera == '4')
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#estacion-etiquetado" role="button" aria-expanded="false"
                                aria-controls="horizontal-menu">
                                <i class="fas fa-tags"></i>
                                <span class="item-name">Etiquetas</span>
                                <i class="right-icon">
                                    <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <ul class="sub-nav collapse" id="estacion-etiquetado" data-bs-parent="#sidebar-menu">
                                <li class="nav-item">
                                    <a class="nav-link @yield('printer')" href="{{ route('printer') }}">
                                        <i class="fas fa-circle" style="font-size: 9px"></i>
                                        <span class="item-name">Impresora</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @yield('h.printer')" href="{{ route('history.printer') }}">
                                        <i class="fas fa-circle" style="font-size: 9px"></i>
                                        <span class="item-name">Historial impresiones</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @yield('custodia')" href="{{ route('etiquetas.custodia') }}">
                                        <i class="fas fa-circle" style="font-size: 9px"></i>
                                        <span class="item-name">QR's en custodia</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->permisos == '4' ||
                            Auth::user()->permiso_madera == '1' ||
                            Auth::user()->permiso_madera == '2' ||
                            Auth::user()->permiso_madera == '5')
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#planificador-madera" role="button" aria-expanded="false"
                                aria-controls="horizontal-menu">
                                <i class="fas fa-pencil-ruler"></i>
                                <span class="item-name">Planificación</span>
                                <i class="right-icon">
                                    <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <ul class="sub-nav collapse" id="planificador-madera" data-bs-parent="#sidebar-menu">
                                <li class="nav-item">
                                    <a class="nav-link @yield('p.corte')" href="{{ route('new.planner.day') }}">
                                        <i class="fas fa-circle" style="font-size: 9px"></i>
                                        <span class="item-name">Planificar corte</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @yield('p.corte.proceso')" href="{{ route('cortes.madera.planner') }}">
                                        <i class="fas fa-circle" style="font-size: 9px"></i>
                                        <span class="item-name">Planificación en proceso</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @yield('p.corte.terminado')" href="{{ route('cortes.madera.completado') }}">
                                        <i class="fas fa-circle" style="font-size: 9px"></i>
                                        <span class="item-name">Planificación terminada</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @yield('p.bloques')" href="{{ route('madera.disponible.cortes') }}">
                                        <i class="fas fa-circle" style="font-size: 9px"></i>
                                        <span class="item-name">Bloques disponibles</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @yield('p.edit.serie')" href="{{ route('create.series') }}">
                                        <i class="fas fa-circle" style="font-size: 9px"></i>
                                        <span class="item-name">Editar serie</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->permisos == '4' || Auth::user()->permiso_madera == '1')
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#crear-op-siesa" role="button" aria-expanded="false"
                                aria-controls="horizontal-menu">
                                <i class="fas fa-tv"></i>
                                <span class="item-name">SIESA</span>
                                <i class="right-icon">
                                    <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <ul class="sub-nav collapse" id="crear-op-siesa" data-bs-parent="#sidebar-menu">
                                <li class="nav-item">
                                    <a class="nav-link @yield('op.siesa')" href="{{ route('index.op.siesa') }}">
                                        <i class="fas fa-circle" style="font-size: 9px"></i>
                                        <span class="item-name">Crear OP</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @yield('ops.siesa')" href="{{ route('historial.op.siesa') }}">
                                        <i class="fas fa-circle" style="font-size: 9px"></i>
                                        <span class="item-name">OPs creadas</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @yield('codigos.siesa')" href="{{ route('c.codigos.siesa') }}">
                                        <i class="fas fa-circle" style="font-size: 9px"></i>
                                        <span class="item-name">Códigos Siesa</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->permisos == '4' || Auth::user()->permiso_madera == '1' || Auth::user()->permiso_madera == '4')
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#config-app" role="button" aria-expanded="false"
                                aria-controls="horizontal-menu">
                                <i class="fas fa-cogs"></i>
                                <span class="item-name">Configuración</span>
                                <i class="right-icon">
                                    <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <ul class="sub-nav collapse" id="config-app" data-bs-parent="#sidebar-menu">
                                <li class="nav-item">
                                    <a class="nav-link @yield('p.config')" href="{{ route('config.printer') }}">
                                        <i class="fas fa-circle" style="font-size: 9px"></i>
                                        <span class="item-name">Impresora</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @yield('p.movil')" href="{{ route('token.acceso.movil') }}">
                                        <i class="fas fa-circle" style="font-size: 9px"></i>
                                        <span class="item-name">Registrar móvil</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->permisos == '4' ||
                            Auth::user()->permiso_madera == '1' ||
                            Auth::user()->permiso_madera == '2' ||
                            Auth::user()->permiso_madera == '3')
                        <li class="nav-item">
                            <a class="nav-link @yield('wood')" aria-current="page" href="{{ route('index.wood') }}">
                                <i class="fas fa-shapes"></i>
                                <span class="item-name">Cortes pendientes</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </aside>
    <main class="main-content">
        <div class="position-relative iq-banner">
            <nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
                <div class="container-fluid navbar-inner">
                    <a href="../dashboard/index.html" class="navbar-brand">
                        <div class="logo-main">
                            <div class="logo-main">
                                <div class="logo-normal">
                                    <img src="{{ asset('img/alburac.png') }}" width="50px" alt="Muebles Albura SAS">
                                </div>
                                <div class="logo-mini">
                                    <img src="{{ asset('img/alburac.png') }}" width="20px" alt="Muebles Albura SAS">
                                </div>
                            </div>
                        </div>
                        <h6 class="logo-title">Muebles Albura</h6>
                    </a>
                    <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                        <i class="icon">
                            <svg width="20px" class="icon-20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                            </svg>
                        </i>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon">
                            <span class="mt-2 navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">

                            <li class="nav-item dropdown">
                                <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">

                                    @php
                                        $ruta = empty(Auth::user()->ruta_foto) ? asset('assets/img/avatars/1.png') : asset(Auth::user()->ruta_foto);
                                    @endphp
                                    <img src="{!! $ruta !!}" alt class="img-fluid avatar avatar-40 avatar-rounded" />
                                    <div class="caption ms-3 d-none d-md-block ">
                                        <h6 class="mb-0 caption-title">{{ Auth::user()->nombre }}</h6>
                                        <p class="mb-0 caption-sub-title">Marketing Administrator</p>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li>
                                        <div class="dropdown-item" onclick="updateFoto('{{ Auth::user()->id }}')" style="cursor: pointer">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">Actualizar foto</span>
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('home') }}">Salir</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="iq-navbar-header" style="height: 80px;">
                <div class="container-fluid iq-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="flex-wrap d-flex justify-content-between align-items-center">
                                {{-- <div>
                                    <h1>Hello Devs!</h1>
                                    <p>We are on a mission to help developers like you build successful projects for FREE.</p>
                                </div> --}}
                                {{-- <div>
                                    <a href="" class="btn btn-link btn-soft-light">
                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.8251 15.2171H12.1748C14.0987 15.2171 15.731 13.985 16.3054 12.2764C16.3887 12.0276 16.1979 11.7713 15.9334 11.7713H14.8562C14.5133 11.7713 14.2362 11.4977 14.2362 11.16C14.2362 10.8213 14.5133 10.5467 14.8562 10.5467H15.9005C16.2463 10.5467 16.5263 10.2703 16.5263 9.92875C16.5263 9.58722 16.2463 9.31075 15.9005 9.31075H14.8562C14.5133 9.31075 14.2362 9.03619 14.2362 8.69849C14.2362 8.35984 14.5133 8.08528 14.8562 8.08528H15.9005C16.2463 8.08528 16.5263 7.8088 16.5263 7.46728C16.5263 7.12575 16.2463 6.84928 15.9005 6.84928H14.8562C14.5133 6.84928 14.2362 6.57472 14.2362 6.23606C14.2362 5.89837 14.5133 5.62381 14.8562 5.62381H15.9886C16.2483 5.62381 16.4343 5.3789 16.3645 5.13113C15.8501 3.32401 14.1694 2 12.1748 2H11.8251C9.42172 2 7.47363 3.92287 7.47363 6.29729V10.9198C7.47363 13.2933 9.42172 15.2171 11.8251 15.2171Z"
                                                fill="currentColor"></path>
                                            <path opacity="0.4"
                                                d="M19.5313 9.82568C18.9966 9.82568 18.5626 10.2533 18.5626 10.7823C18.5626 14.3554 15.6186 17.2627 12.0005 17.2627C8.38136 17.2627 5.43743 14.3554 5.43743 10.7823C5.43743 10.2533 5.00345 9.82568 4.46872 9.82568C3.93398 9.82568 3.5 10.2533 3.5 10.7823C3.5 15.0873 6.79945 18.6413 11.0318 19.1186V21.0434C11.0318 21.5715 11.4648 22.0001 12.0005 22.0001C12.5352 22.0001 12.9692 21.5715 12.9692 21.0434V19.1186C17.2006 18.6413 20.5 15.0873 20.5 10.7823C20.5 10.2533 20.066 9.82568 19.5313 9.82568Z"
                                                fill="currentColor"></path>
                                        </svg>
                                        Announcements
                                    </a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iq-header-img">
                    <img src=" {{ asset('img/top-header3.png') }}" alt="header" class="img-fluid w-100 h-100 animated-scaleX">
                </div>
            </div>
        </div>
        <div class="conatiner-fluid content-inner mt-n5 py-0">
            @yield('body')
        </div>
    </main>

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }} "></script>
    <script src="{{ asset('estilos/assets/js/core/libs.min.js') }}"></script>
    <script src="{{ asset('estilos/assets/js/core/external.min.js') }}"></script>
    <script src="{{ asset('estilos/assets/js/charts/widgetcharts.js') }}"></script>
    <script src="{{ asset('estilos/assets/js/charts/vectore-chart.js') }}"></script>
    <script src="{{ asset('estilos/assets/js/charts/dashboard.js') }}"></script>
    <script src="{{ asset('estilos/assets/js/plugins/fslightbox.js') }}"></script>
    <script src="{{ asset('estilos/assets/js/plugins/setting.js') }}"></script>
    <script src="{{ asset('estilos/assets/js/plugins/slider-tabs.js') }}"></script>
    <script src="{{ asset('estilos/assets/js/plugins/form-wizard.js') }}"></script>
    <script src="{{ asset('estilos/assets/vendor/aos/dist/aos.js') }}"></script>
    <script src="{{ asset('estilos/assets/js/hope-ui.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('plugins/pnotify/dist/pnotify.buttons.js') }}"></script>

    @yield('footer')
    <script>
        const sidebarHover = document.querySelector('.sidebar-body');

        sidebarHover.addEventListener('mouseover', function() {
            sidebar.classList.remove('sidebar-mini');
        });

        sidebarHover.addEventListener('mouseleave', function() {
            sidebar.classList.add('sidebar-mini');
        });

        $(document).ready(() => {
            $('#menu_toggle').click()
        });

        notificacion = (txt, icon, timer) => {
            Swal.fire({
                text: txt,
                icon: icon,
                showConfirmButton: false,
                position: "top-end",
                timer: timer,
                toast: true,
                didOpen: () => {
                    const swalContainer = document.querySelector('.swal2-container');
                    if (swalContainer) {
                        swalContainer.style.zIndex = '9999';
                    }
                }
            });
        }

        searchInfoMadera = (valor) => {
            if (valor.length > 0) {
                var datos = $.ajax({
                    url: "{{ route('planner.search.madera') }}",
                    type: "post",
                    dataType: "json",
                    data: {
                        valor
                    }
                });
                datos.done((res) => {
                    if (res.status == true) {
                        $('#madera_planner').prop('disabled', false)
                        document.getElementById('madera_planner').innerHTML = res.valores
                    }
                })
                datos.fail(() => {
                    notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
                })
            } else {
                $('#btnResetPlanner').click()
            }
        }

        searchInfoMueble = (valor) => {
            if (valor.length > 0) {
                var serie = $('#serie_planner').val()
                var datos = $.ajax({
                    url: "{{ route('planner.search.mueble') }}",
                    type: "post",
                    dataType: "json",
                    data: {
                        madera: valor,
                        serie
                    }
                });
                datos.done((res) => {
                    if (res.status == true) {
                        $('#mueble_planner').prop('disabled', false)
                        document.getElementById('mueble_planner').innerHTML = res.valores
                        if (res.vlr_madera > 0) {
                            $("#txtPiezasFavConsultaMadera").val(res.vlr_madera)
                        } else {
                            $("#txtPiezasFavConsultaMadera").val("")
                        }
                    }
                })
                datos.fail(() => {
                    notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
                })
            } else {
                $('#mueble_planner').val('')
                $('#mueble_planner').prop('disabled', true)
            }
        }

        reImprimirCodigoQRPrinter = (consecutivo, panel) => {
            var datos = $.ajax({
                url: "{{ route('info.reprinted') }}",
                type: "post",
                dataType: "json",
                data: {
                    consecutivo
                }
            })
            datos.done((res) => {
                notificacion("Excelente : " + res.mensaje, "success", 5000)
                if (panel == 1) {
                    var cantidad_ac = $("#cantidad_impresiones_fallidas").text();
                    var cant_fail = parseFloat(cantidad_ac);
                    $("#cantidad_impresiones_fallidas").text(cantidad_ac - 1);
                    document.getElementById("consecPrinted" + consecutivo).remove()
                }
            })
            datos.fail(() => {
                notificacion("ERROR: revisa la configuración de la impresora", "error", 5000)
            })
        }
    </script>

</body>

</html>
