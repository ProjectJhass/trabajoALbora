<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Servicios técnicos</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/logo/alburac.png') }} " />
    <link rel="preconnect" href="https://fonts.googleapis.com')}} " />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }} " />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css " />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }} " />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }} " />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }} " />
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    @yield('head')
</head>

<body>
    @php
        $bodegas = ['SERVICIO TECNICO', 'SERVICIO TECNICO FAB', 'FABRICA', 'HAPPYSLEEP', 'DESPACHOS']; //'BODEGA_021', 'BODEGA_022',
    @endphp

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <div class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img src="{{ asset('img/img_log_rojo.png') }}" width="7%" alt="">
                        </span>
                    </div>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <li class="menu-header small text-uppercase"><span class="menu-header-text">Acciones</span></li>
                    <li class="menu-item @yield('analytics')">
                        <a href="{{ Route('analytics') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-collection"></i>
                            <div data-i18n="Basic">Inicio</div>
                        </a>
                    </li>
                    @if (Auth::user()->almacen == 'SERVICIO TECNICO FAB' ||
                            Auth::user()->almacen == 'SERVICIO TECNICO' ||
                            Auth::user()->almacen == 'HAPPYSLEEP' ||
                            Auth::user()->almacen == 'PPAL')
                        <li class="menu-item @yield('st')">
                            <a href="{{ Route('informe.seg') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Servicios técnicos</div>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->almacen == 'SERVICIO TECNICO FAB' || Auth::user()->almacen == 'FABRICA' || Auth::user()->almacen == 'PPAL')
                        <li class="menu-item @yield('fabrica')">
                            <a href="{{ route('home.fabrica') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Fábrica</div>
                            </a>
                        </li>
                    @endif
                    @if (!in_array(Auth::user()->almacen, $bodegas))
                        <li class="menu-item @yield('almacen')">
                            <a href="{{ route('info.almacen') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Sucursal</div>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->almacen == 'DESPACHOS' || Auth::user()->almacen == 'PPAL' || (Auth::user()->almacen == 'FABRICA' && Auth::user()->rol == '1'))
                        <li class="menu-item @yield('despachos')">
                            <a href="{{ route('info.despachos') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Despachos</div>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->almacen == 'TALLER' ||
                            Auth::user()->almacen == 'DESPACHOS' ||
                            Auth::user()->almacen == 'PPAL' ||
                            (Auth::user()->almacen == 'FABRICA' && Auth::user()->rol == '1'))
                        <li class="menu-item @yield('taller')">
                            <a href="{{ route('info.taller') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Taller</div>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->almacen == 'SERVICIO TECNICO FAB' || Auth::user()->almacen == 'SERVICIO TECNICO' || Auth::user()->almacen == 'PPAL')
                        <li class="menu-item @yield('pwb')">
                            <a href="{{ route('info.pagweb') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Página web</div>
                            </a>
                        </li>
                        {{-- <li class="menu-item @yield('reportes')">
                            <a href="cards-basic.html" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Reportes</div>
                            </a>
                        </li> --}}
                        {{-- <li class="menu-item @yield('hs')">
                            <a href="cards-basic.html" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Docs Happy Sleep</div>
                            </a>
                        </li> --}}
                        <li class="menu-item @yield('admin')">
                            <a href="{{ route('admin.info') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Maestros</div>
                            </a>
                        </li>
                        @if (Auth::user()->rol == 1 && Auth::user()->almacen == 'PPAL')
                            <li class="menu-item @yield('usuarios')">
                                <a href="{{ route('users.admin') }}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-collection"></i>
                                    <div data-i18n="Basic">Usuarios</div>
                                </a>
                            </li>
                        @endif
                        {{-- <li class="menu-item @yield('rem')">
                            <a href="cards-basic.html" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Remisiones</div>
                            </a>
                        </li> --}}
                    @endif
                    @if (
                        (Auth::user()->almacen == 'SERVICIO TECNICO FAB' || Auth::user()->almacen == 'SERVICIO TECNICO' || Auth::user()->almacen == 'PPAL') &&
                            Auth::user()->rol == 1)
                        <li class="menu-item @yield('seguimiento')">
                            <a href="{{ route('info.st.seg') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Seguimiento</div>
                            </a>
                        </li>
                    @endif
                    <li class="menu-item @yield('pqrs')">
                        <a href="{{ route('pqrs.nueva') }}" target="_BLANK" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-collection"></i>
                            <div data-i18n="Basic">PQRS</div>
                        </a>
                    </li>
                    <li></li>
                    <li class="menu-item text-center">
                        <a type="button" class="btn rounded-pill btn-outline-danger" href="{{ route('home') }}">
                            {{ __('Cerrar sesión') }}
                        </a>
                    </li>
                </ul>
            </aside>

            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <i class="bx bx-search fs-4 lh-0" style="cursor: pointer" onclick="buscarInformacionGeneralSt()"></i>
                                <input type="text" autocomplete="off" class="form-control border-0 shadow-none ps-1 ps-sm-2" name="codigoST"
                                    id="codigoST" placeholder="Buscar orden de servicio..." onkeypress="verificarEnter(event)"
                                    aria-label="Buscar orden de servicio..." />
                            </div>
                        </div>
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            {{ Auth::user()->nombre }}
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        @php
                                            $ruta = empty(Auth::user()->ruta_foto)
                                                ? asset('assets/img/avatars/1.png')
                                                : asset(Auth::user()->ruta_foto);
                                        @endphp
                                        <img src="{!! $ruta !!}" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <div class="dropdown-item">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{!! $ruta !!}" class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-medium d-block">{{ Auth::user()->nombre }}</span>
                                                    <small class="text-muted">{{ Auth::user()->rol == 1 ? 'Administrador' : 'Usuario' }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <div class="dropdown-item" onclick="updateFoto('{{ Auth::user()->id }}')" style="cursor: pointer">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">Actualizar foto</span>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('body')
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>
    <!-- Modales -->

    <div class="buy-now" id="floating-btn-new-st">
        <button class="btn btn-danger btn-buy-now" onclick="dataEditNewOst()" data-bs-toggle="tooltip" data-bs-offset="0,4"
            data-bs-placement="top" data-bs-html="true" title="<i class='bx bx-bell bx-xs' ></i> <span>Nueva orden de servicio</span>"
            style="width: 60px; height: 60px; border-radius: 50%">+</button>
    </div>


    <div class="modal fade" id="ModalNewServicioTecnico" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Información básica</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-new-info-ws-ost">
                        <div class="row">
                            <div class="col-md-7">
                                <label for="cedula_new_ost" class="form-label">Número de cédula</label>
                                <input type="number" name="cedula_new_ost" onkeyup="validarinputSt(this.value)" id="cedula_new_ost"
                                    class="form-control" required placeholder="Número" />
                            </div>
                            <div class="col-md-5">
                                <label for="co_new_ost" class="form-label">Centro de experiencia</label>
                                <select class="form-control" name="co_new_ost" id="co_new_ost" required>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6 mb-3" id="facturas_new_ost"></div>
                            <div class="col-md-6 mb-3" id="productos_new_ost"></div>
                        </div>
                    </form>
                    <input type="text" name="val-ticket-pw" id="val-ticket-pw" hidden>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="buscarInfoFacturasCliente()" class="btn btn-primary">Consultar información</button>
                    <button type="button" onclick="CrearOrdenServicioVacio()" class="btn btn-secondary">Crear desde cero</button>
                    {{-- <a href="{{ Route('new.ost') }}" type="button" class="btn btn-secondary">Crear desde cero</a> --}}
                    <button type="button" onclick="formCrearInformacionNuevaOst()" class="btn btn-danger">Crear nueva OST</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalInfoGeneralSt" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Información de orden de servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" id="informacion-st-card">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModalChangeFotoUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Actualizar fotografía</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-update-foto" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="fotografia">Nueva fotografía <small>Estilo cuadrado</small></label>
                                <input type="file" class="form-control" name="fotografia" id="fotografia">
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-sm mt-3" onclick="updateFotografia()">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }} "></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }} "></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }} "></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }} "></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }} "></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }} "></script>
    <script src="{{ asset('assets/js/main.js') }} "></script>
    {{-- <script src="{{ asset('assets/js/dashboards-analytics.js') }} "></script> --}}
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
        updateFoto = (id) => {
            $('#ModalChangeFotoUser').modal('show')
        }

        updateFotografia = () => {
            notificacion("Actualizando fotografía...", "info", 10000);
            var formulario = new FormData(document.getElementById('form-update-foto'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('update.photo') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                notificacion("¡Fotografía actualizada!", "success", 5000);
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa la información y vuelve a intentarlo", "error", 5000);
            })
        }

        CrearOrdenServicioVacio = () => {
            var pw = $('#val-ticket-pw').val()
            if (pw.length > 0) {
                window.location.href = "{{ route('new.ost.pw') }}/" + pw;
            } else {
                window.location.href = "{{ Route('new.ost') }}"
            }
        }

        visualizarInfoServicioTecnico = (id_st, seccion) => {
            var url = "{{ route('st.find.ost.card', ['id_st' => 'ID_OST', 'seccion' => 'SECCION']) }}"
            var url_new = url.replace("ID_OST", id_st)
            var url_new = url_new.replace("SECCION", seccion)
            window.location.href = url_new
        }

        validarinputSt = (value) => {
            if (value.length == 0) {
                document.getElementById("facturas_new_ost").innerHTML = ''
                document.getElementById("productos_new_ost").innerHTML = ''
            }
        }

        dataEditNewOst = () => {
            $('#val-ticket-pw').val('')
            $('#ModalNewServicioTecnico').modal('show')
            buscarInfoCentroExp()
        }

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

        function verificarEnter(event) {
            if (event.keyCode === 13) {
                buscarInformacionGeneralSt()
            }
        }

        buscarInformacionGeneralSt = () => {
            var codigo = document.getElementById("codigoST").value;
            if (codigo.length > 0) {
                $('#ModalInfoGeneralSt').modal('show')
                var data = $.ajax({
                    url: "{{ route('search.ost') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        codigo
                    },

                })
                data.done((res) => {
                    document.getElementById("informacion-st-card").innerHTML = res.cards
                })
                data.fail(() => {
                    document.getElementById("informacion-st-card").innerHTML = "<p>Error interno, vuelve a buscar la OST " + codigo + "</p>";
                })
            }
        }

        buscarInfoCentroExp = () => {
            var data = $.ajax({
                url: "{{ route('search.co') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    codigo: 1
                },

            })
            data.done((res) => {
                document.getElementById("co_new_ost").innerHTML = res.options
            })
        }

        buscarInfoFacturasCliente = () => {
            var cedula = $('#cedula_new_ost').val()
            var almacen = $('#co_new_ost').val()

            if (cedula.length > 0 && almacen.length > 0) {
                document.getElementById("productos_new_ost").innerHTML = ''

                var data = $.ajax({
                    url: "{{ route('search.facturas') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        cedula,
                        almacen,
                    },

                })
                data.done((res) => {
                    document.getElementById("facturas_new_ost").innerHTML = res.data
                })
            } else {
                notificacion('Digita un número de cédula válido y escoge un centro de experiencia', 'error', 5000)
            }
        }

        $(document).ready(function() {
            $('#form-new-info-ws-ost').on('change', '#facturas_new_ost input[type="radio"]', function() {
                var id_factura = $('input[name="factura_cliente"]:checked').val();
                var data = $.ajax({
                    url: "{{ route('search.productos') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id_factura
                    },

                })
                data.done((res) => {
                    document.getElementById("productos_new_ost").innerHTML = res.data
                })

            });
        });

        formCrearInformacionNuevaOst = () => {
            var id_factura = $('input[name="factura_cliente"]:checked').val()
            var producto = $('input[name="item_cliente"]:checked').val()
            var id_ticket_web = $('#val-ticket-pw').val()

            if (id_factura === undefined && producto === undefined) {
                notificacion('Primero debes consultar la información antes de crear', 'error', 5000)
            } else {
                if (id_factura !== undefined && producto !== undefined) {
                    var formulario = new FormData(document.getElementById('form-new-info-ws-ost'));

                    var factura = $('#factura' + id_factura).data('factura')
                    var fecha_factura = $('#factura' + id_factura).data('fecha_fac')
                    var remision = $('#factura' + id_factura).data('rem')
                    var fecha_remision = $('#factura' + id_factura).data('fecha_rem')

                    var id_item = $('input[name="item_cliente"]:checked').data('id_item')
                    var ext1 = $('input[name="item_cliente"]:checked').data('ext1')
                    var ext2 = $('input[name="item_cliente"]:checked').data('ext2')

                    formulario.append('factura', factura);
                    formulario.append('fecha_factura', fecha_factura);
                    formulario.append('remision', remision);
                    formulario.append('fecha_remision', fecha_remision);
                    formulario.append('id_item', id_item);
                    formulario.append('ext1', '1');
                    formulario.append('ext2', '1');
                    formulario.append('ticket', id_ticket_web);

                    var formDataQueryString = "";
                    for (var pair of formulario.entries()) {
                        formDataQueryString += encodeURIComponent(pair[1]) + "/";
                    }
                    formDataQueryString = formDataQueryString.slice(0, -1);
                    window.location.href = "{{ route('create.solicitud') }}/" + formDataQueryString;
                } else {
                    notificacion('Selecciona una factura y un producto para continuar', 'error', 5000)
                }
            }
        }

        CrearServicioWeb = () => {
            dataEditNewOst()
            var id_web = $('#txt-web-id-user').text()
            var cedula = $('#tbl-id-cedula' + id_web).text()
            var co = $('#tbl-id-almacen' + id_web).text()
            var ticket = $('#tbl-ticket' + id_web).text()

            $('#cedula_new_ost').val(cedula)
            $('#val-ticket-pw').val(ticket)

            setTimeout(() => {
                $('#co_new_ost').val(co)
            }, 500);

            setTimeout(() => {
                buscarInfoFacturasCliente()
            }, 700);
        }
    </script>
    @yield('footer')
</footer>

</html>
