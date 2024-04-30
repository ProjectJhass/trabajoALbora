<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Control de madera</title>

    <!-- Bootstrap -->
    <link href="{{ asset('plugins/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- NProgress -->
    <link href="{{ asset('nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="{{ asset('malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet" />

    <!-- Custom Theme Style -->
    <link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    <style>
        .right_col {
            min-height: 50rem !important;
        }
    </style>
    @yield('head')
</head>

<body class="nav-md loaded">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col menu_fixed">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="{{ route('madera.home') }}" class="site_title"><i class="fa fa-paw"></i> <span>Muebles Albura SAS</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="#" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Bienvenido(a),</span>
                            <h2>{{ Auth::user()->nombre }}</h2>
                        </div>
                    </div>
                    <br />
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a><i class="fas fa-home"></i> Impresora <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('printer') }}">Imprimir</a></li>
                                        <li><a href="{{ route('history.printer') }}">Historial impresiones</a></li>
                                        <li><a href="{{ route('config.printer') }}">Configuración</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fas fa-edit"></i> Planificación <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('new.planner.day') }}">Planificar corte</a></li>
                                        <li><a href="{{ route('cortes.madera.planner') }}">Cortes planificados</a></li>
                                        <li><a href="{{ route('cortes.madera.completado') }}">Cortes terminados</a></li>
                                        <li><a href="{{ route('madera.disponible.cortes') }}">Madera disponible</a></li>
                                        <li><a href="{{ route('create.series') }}">Crear nueva serie</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fas fa-desktop"></i> SIESA <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="general_elements.html">Crear OP</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('index.wood') }}"><i class="fas fa-desktop"></i>Woodmiser</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
                                    data-toggle="dropdown" aria-expanded="false">
                                    <img src="#" alt="">{{ Auth::user()->nombre }}
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();"><i
                                            class="fa fa-sign-out pull-right"></i> Salir</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>

                        </ul>
                    </nav>
                </div>
            </div>

            <div class="right_col" role="main">
                @yield('body')
            </div>
        </div>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('plugins/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('plugins/nprogress/nprogress.js') }}"></script>
    <!-- jQuery custom content scroller -->
    <script src="{{ asset('plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('build/js/custom.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    @yield('footer')
    <script>
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
