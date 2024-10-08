<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Albura Nexus</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

<body class="theme-color-red loaded" style="display:flex;">
    <aside class="sidebar sidebar-default sidebar-base  navs-pill" style=" position:fixed; height:100vh;">
        <div class="sidebar-header d-flex align-items-center justify-content-start" style=" width: 100%">
            <div class="navbar-brand" style="padding: 14px 16px;">
                <div class="logo-main">
                    <div class="logo-normal">
                        <img src="{{ asset('img/alburac.png') }}" width="50px" alt="Muebles Albura SAS">
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
        <div class="nav navbar  iq-navbar">
        <div class="container-fluid" style="padding: 0 15px;">
    <!-- Logo -->
    <!-- <a href="../dashboard/index.html" class="navbar-brand">
        <div class="logo-main">
            <div class="logo-man">
                <div class="logo-normal">
                    <img src="{{ asset('img/alburac.png') }}" width="50px" alt="Muebles Albura SAS">
                </div>
                <div class="logo-mini">
                    <img src="{{ asset('img/alburac.png') }}" width="20px" alt="Muebles Albura SAS">
                </div>
            </div>
        </div>
        <h6 class="logo-title">Muebles Albura</h6>
    </a> -->

    <div class="input-group search-input ms-auto" onclick="modalBuscarInformacion()">
        <span class="input-group-text" id="search-input">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
        <input type="search" class="form-control iq-main-menu" placeholder="Buscar..."
               style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 512 512&quot;><path d=&quot;M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z&quot;/></svg>'); 
               background-size: 20px 20px; 
               background-position: 10px center; 
               background-repeat: no-repeat; 
               padding-left: 40px;">
    </div>

    <!-- Contenido comentado -->
    <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
    </div> -->
</div>

        </div>
        <div class="sidebar-body" style="width: 100%; display:flex; justify-content:space-between; flex-direction:column; height:calc(100% - 20%);">
            <div class="sidebar-list" style="padding-top: 20px;">
                <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                    <li class="nav-item">
                        <a class="nav-link @yield('home')" aria-current="page" href="{{ route('home.nexus') }}">
                            <i class="fas fa-house"></i>
                            <span class="item-name">Inicio</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('usuarios')" aria-current="page" href="{{ route('usuarios.nexus') }}">
                            <i class="fas fa-shapes"></i>
                            <span class="item-name">Usuarios</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('modulos')" aria-current="page" href="{{ route('modulos.nexus') }}">
                            <i class="fas fa-shapes"></i>
                            <span class="item-name">Módulos capacitación</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('manual')" aria-current="page" href="{{ route('registros.manual.nexus') }}">
                            <i class="fas fa-shapes"></i>
                            <span class="item-name">Manual de funciones</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#planificador-madera" role="button" aria-expanded="false"
                            aria-controls="horizontal-menu">
                            <i class="fas fa-pencil-ruler"></i>
                            <span class="item-name">Entrevistas</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="planificador-madera" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link @yield('c.entrevista')" href="{{ route('crear.entrevista') }}">
                                    <i class="fas fa-circle" style="font-size: 9px"></i>
                                    <span class="item-name">Crear entrevista</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @yield('concepto.entrevista')" href="{{ route('concepto.entrevista') }}">
                                    <i class="fas fa-circle" style="font-size: 9px"></i>
                                    <span class="item-name">Emitir concepto</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @yield('p.corte.proceso')" href="{{ route('cortes.madera.planner') }}">
                                    <i class="fas fa-circle" style="font-size: 9px"></i>
                                    <span class="item-name">Entrevistas creadas</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @yield('p.corte.terminado')" href="{{ route('cortes.madera.completado') }}">
                                    <i class="fas fa-circle" style="font-size: 9px"></i>
                                    <span class="item-name">Entrevistas aprobadas</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @yield('p.bloques')" href="{{ route('madera.disponible.cortes') }}">
                                    <i class="fas fa-circle" style="font-size: 9px"></i>
                                    <span class="item-name">Entrevistas rechazadas</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @yield('p.edit.serie')" href="{{ route('create.series') }}">
                                    <i class="fas fa-circle" style="font-size: 9px"></i>
                                    <span class="item-name">Pre-aprobadas</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Secciones sobrantes -->

                    <!-- <li class="nav-item">
                        <a class="nav-link @yield('wood')" aria-current="page" href="{{ route('index.wood') }}">
                            <i class="fas fa-shapes"></i>
                            <span class="item-name">Cortes pendientes</span>
                        </a>
                    </li> -->
                    <!-- @if (Auth::user()->permisos == '4' ||
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
                        </ul>
                    </li>
                    @endif -->
                    <!-- @if (Auth::user()->permisos == '4' ||
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
                    @endif -->
                    <!-- @if (Auth::user()->permisos == '4' || Auth::user()->permiso_madera == '1')
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
                    @endif -->
                    <!-- @if (Auth::user()->permisos == '4' || Auth::user()->permiso_madera == '1' || Auth::user()->permiso_madera == '4')
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
                    </li> -->
                    <!-- @endif
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
                    @endif -->
                </ul>
                <!-- Contenido del usuario en la parte inferior -->
            </div>
            <div class="sidebar-footer mt-auto">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link py-0 d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @php
                            $ruta = empty(Auth::user()->ruta_foto) ? asset('assets/img/avatars/1.png') : asset(Auth::user()->ruta_foto);
                            @endphp
                            <img src="{!! $ruta !!}" alt="User Avatar" class="img-fluid avatar avatar-40 avatar-rounded" />
                            <div class="caption ms-3 d-none d-md-block">
                                <h6 class="mb-0 caption-title">{{ Auth::user()->nombre }}</h6>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="#" onclick="updateFoto('{{ Auth::user()->id }}')">
                                    <i class="bx bx-user me-2"></i> Actualizar foto
                                </a>
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
    </aside>
    <main class="main-content" style=" width: 100vw; position: relative; overflow-y: auto; height:100vh;">
        <div class="position-relative iq-banner">
            <!-- <nav class="nav navbar navbar-expand-lg bg-primary iq-navbar" style="padding: 10px;">
                <div class="container-fluid navbar-inner">
                    <a href="../dashboard/index.html" class="navbar-brand">
                        <div class="logo-main">
                            <div class="logo-man">
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
                    <div class="input-group search-input" onclick="modalBuscarInformacion()">
                        <span class="input-group-text" id="search-input">
                            <svg class="icon-18" width="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></circle>
                                <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                        </span>
                        <input type="search" class="form-control" placeholder="Realizar búsqueda">
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
            </nav> -->
            <!-- <div class="iq-navbar-header" style="height: 80px;">
                <div class="container-fluid iq-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="flex-wrap d-flex justify-content-between align-items-center">
                                <div>
                                    <h1>Hello Devs!</h1>
                                    <p>We are on a mission to help developers like you build successful projects for FREE.</p>
                                </div> 
                                <div>
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
                                    </div> 
                                </div>
                            </div>
                    </div>
                </div>
                
                
            </div> -->
            <div class="iq-header-img  d-flex justify-content-between align-items-center" style="background-color: white;">
                <div class="ezy__sheader6-content">

                </div>

                <img src="../../../../../../plataformas_web/public/img/imgArea.png" class="ezy__sheader6-overlay" alt="Descripción de la imagen">
            </div>
            <style>
                #ezy__sheader6 {
                    background-color: white;
                    color: var(--bs-body-color);
                    padding: 70px 0;
                    margin-top: 20px;
                    position: relative;
                }

                @media (min-width: 768px) {
                    #ezy__sheader6 {
                        padding: 100px 0;
                    }
                }

                /* Flexbox para alinear el contenido y la imagen */
                .iq-header-img {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                .ezy__sheader6-content {
                    flex: 1;
                    /* El contenido ocupará el espacio restante */
                }

                .ezy__sheader6-overlay {
                    width: 29%;
                    /* La imagen ocupará el 50% del contenedor */
                    padding-top: 5%;
                    padding-right: 10%;
                    height: auto;
                    max-width: 100%;
                    /* Asegura que la imagen no exceda su contenedor */
                }

                .ezy__sheader6-heading {
                    font-weight: bold;
                    font-size: 35px;
                }

                @media (min-width: 768px) {
                    .ezy__sheader6-heading {
                        font-size: 60px;
                    }
                }

                .ezy__sheader6-sub-heading {
                    font-size: 20px;
                    opacity: 0.75;
                }
            </style>
        </div>
        </div>
        <div class="conatiner-fluid content-inner mt-n5 py-0" id="bodyModuleTraining" style="background-color: #f2f2f2;">
            @yield('body')
        </div>

    </main>

    <div class="modal fade" id="infoGeneralBusquedaNexus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filtrar información</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" class="was-validated" method="post">
                        <div class="row">
                            <div class="input-group">
                                <select class="form-control" name="info_consultar" id="info_consultar" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="usuarios">Usuarios</option>
                                    <option value="areas">Áreas</option>
                                    <option value="cargos">Cargos</option>
                                    <option value="modulos">Módulos</option>
                                    <option value="temas">Temas</option>
                                </select>
                                <input type="text" class="form-control" onkeyup="consultarInformacion(this.value)" name="palabra"
                                    id="palabra" placeholder="Palabras clave">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

</body>
<footer>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @yield('footer')
    <script>
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

        modalBuscarInformacion = () => {
            $("#infoGeneralBusquedaNexus").modal("show")
        }
    </script>
</footer>

</html>