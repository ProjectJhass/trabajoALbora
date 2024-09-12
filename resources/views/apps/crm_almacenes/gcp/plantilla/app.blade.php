<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRM - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('img/alburac.png') }}" type="image/x-icon">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
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
    @yield('header')
</head>

<body class="hold-transition sidebar-mini sidebar-collapse loaded">

    <div class="loader-wrapper">
        <div class="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>

    {{-- Modal para marcar la venta efectiva de clientes punto de ventas SIESA --}}

    <div class="modal fade" id="mdl_cumple_cliente_crm">
        <div class="modal-dialog modal-xl" style="max-width: 70%">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #c22121; color: white;">
                    <h5>Cumpleaños</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        onclick="() => { $('#mdl_cumple_cliente_crm').modal('toggle'); }" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="body_mdl_cumple_cliente">

                </div>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white" style="background-color: #c22121;">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    @if (Auth::user()->cargo == 'guest')
                    @else
                        <div class="nav-link text-white">{{ Auth::user()->nombre }}</div>
                    @endif
                </li>
            </ul>
            @if (Auth::user()->cargo == 'guest')
            @else
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link text-white" onclick="consultar_cumple_pendientes()" type="button">
                            <i class="fas fa-birthday-cake"></i>
                            <span id="cantidad-noti-cumple"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('home') }}">
                            {{ __('Salir') }} <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </li>
                </ul>
            @endif
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <div class="brand-link" style="background-color: #c22121;">
                <img src="{{ asset('img/ROJOc.png') }}" alt="Muebles Albura"
                    class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light">Muebles Albura</span>
            </div>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('img/asesor.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <div class="d-block text-white">CRM Punto de Venta {{ Auth::user()->cargo }}</div>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @if (Auth::user()->cargo == 'guest')
                            <li class="nav-item">
                                <a href="{{ route('liquidador.intereses') }}"
                                    class="nav-link text-white @yield('intereses')">
                                    <i class="nav-icon fas fa-money-bill-alt"></i>
                                    <p>
                                        Liq. Intereses
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('liquidador.descuentos') }}"
                                    class="nav-link text-white @yield('descuentos')">
                                    <i class="nav-icon fas fa-tags"></i>
                                    <p>
                                        Liq. Descuentos
                                    </p>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('lista.precios.crexit', ['origen' => '1']) }}"
                                    class="nav-link text-white">
                                    <i class="nav-icon fas fa-shopping-cart"></i>
                                    <p>
                                        Cotizador
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('inicio.crm.punto.venta') }}"
                                    class="nav-link text-white @yield('maestra')">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Maestra general
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('registrar.nuevo.cliente') }}"
                                    class="nav-link text-white @yield('digitar')">
                                    <i class="nav-icon fas fa-user-plus"></i>
                                    <p>
                                        Digitar contácto
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('llamadas.pendientes.crm') }}"
                                    class="nav-link text-white @yield('llamadas')">
                                    <i class="nav-icon fas fa-phone-alt"></i>
                                    <p>
                                        Realizar llamadas
                                        <span id="numero-llamadas-realizar"></span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('info.cliente.efectivo') }}"
                                    class="nav-link text-white @yield('efectivos')">
                                    <i class="nav-icon fas fa-user-check"></i>
                                    <p>
                                        Clientes Efectivos
                                    </p>
                                </a>
                            </li>
                            @if (Auth::user()->cargo == 'administrador')
                                <li class="nav-item">
                                    <a href="{{ route('estadisticas.admin.crm') }}"
                                        class="nav-link text-white @yield('ventas')">
                                        <i class="nav-icon fas fa-chart-line"></i>
                                        <p>
                                            Informe de ventas
                                        </p>
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ route('informes.asesor.crm') }}"
                                        class="nav-link text-white @yield('ventas')">
                                        <i class="nav-icon fas fa-chart-line"></i>
                                        <p>
                                            Informe de ventas
                                        </p>
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a href="{{ route('liquidador.intereses') }}"
                                    class="nav-link text-white @yield('intereses')">
                                    <i class="nav-icon fas fa-money-bill-alt"></i>
                                    <p>
                                        Liq. Intereses
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('liquidador.descuentos') }}"
                                    class="nav-link text-white @yield('descuentos')">
                                    <i class="nav-icon fas fa-tags"></i>
                                    <p>
                                        Liq. Descuentos
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->cargo == 'administrador')
                            <li class="nav-item">
                                <a href="{{ route('crm.exportar.home') }}"
                                    class="nav-link text-white @yield('exportar')">
                                    <i class="nav-icon fas fa-file-excel"></i>
                                    <p>
                                        Exportar Información
                                    </p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>

            </div>
        </aside>
        <div class="content-wrapper">
            @yield('contenido')
        </div>
    </div>
</body>
<footer>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script>
        loandingPanel = () => {
            document.querySelector('body').classList.remove("loaded")
        }

        loadedPanel = () => {
            document.querySelector('body').classList.add("loaded")
        }

        const consultar_cumple_pendientes = () => {
            $('#mdl_cumple_cliente_crm').modal('toggle')

            $.ajax({
                url: "{{ route('crm_almacenes.general.birthday') }}",
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (response) => {
                    $('#body_mdl_cumple_cliente').html(response.viewBirtdayClient);
                }
            })
        }

        $(() => {
            ConsultarCantidadLlamdasPendientes();
        });

        ConsultarCantidadLlamdasPendientes = () => {
            var datos = $.ajax({
                url: "{{ route('validar.llamadas.realizar') }}",
                type: "POST",
                dataType: "json",
                data: {
                    validar: '1'
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    if (res.cantidad > 0) {
                        var band_map = 0;
                        res.data.map((info) => {
                            if (band_map < 5) {
                                $(document).Toasts('create', {
                                    class: 'bg-warning',
                                    title: 'Llamar a:',
                                    position: 'bottomRight',
                                    body: info.nombre
                                })
                                band_map++;
                            }
                        })

                        $('#numero-llamadas-realizar').addClass('right badge badge-danger');
                        document.getElementById('numero-llamadas-realizar').innerHTML = res.cantidad;

                    } else {
                        $('#numero-llamadas-realizar').removeClass('right badge badge-danger');
                        document.getElementById('numero-llamadas-realizar').innerHTML = '';
                    }
                    if (res.cant_cumple > 0) {

                        // consultar_cumple_pendientes();

                        $(document).Toasts('create', {
                            class: 'bg-info',
                            title: 'Cumpleaños',
                            body: 'Hay ' + res.cant_cumple + ' clientes que están cumpliendo años hoy!'
                        });

                        document.getElementById('cantidad-noti-cumple').innerHTML =
                            '<span class="badge badge-success navbar-badge">' + res
                            .cant_cumple + '</span>'
                        document.getElementById('lista-de-notificaciones').innerHTML = res.cumple;
                    } else {
                        document.getElementById('cantidad-noti-cumple').innerHTML = '';
                        document.getElementById('lista-de-notificaciones').innerHTML = '';
                    }
                }
            });
        }

        ConsultarAsesoresCo = (co) => {
            var datos = $.ajax({
                url: "{{ route('search.asesor.crm') }}",
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
                    document.getElementById('asesor_co').innerHTML = res.asesores;
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

        ConsultarInformacionAsesor = (id_asesor, nombre) => {
            loandingPanel()
            var co_s = $('#almacen_co').val()
            var tipo_cliente = $("#tipo_cliente_asesor").val()

            var datos = $.ajax({
                url: "{{ route('info.general.asesor.m') }}",
                type: "POST",
                dataType: "json",
                data: {
                    id_asesor,
                    co_s,
                    nombre,
                    tipo_cliente
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                loadedPanel()
                if (res.status == true) {
                    document.getElementById('infoGeneralAsesorMaestra').innerHTML = res.table
                    tableFormmater();
                }
            });
            datos.fail(() => {
                loadedPanel()
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 1500
                })
            });
        }

        MostrarComentariosCliente = (id_usuario) => {

            var nombre = $('#cliente' + id_usuario).data('nombre');
            $('#historial-seguimiento-asesor').modal('show');
            document.getElementById('nombre-cliente-almacen').innerHTML = nombre;
            $('#id_validar_cliente_alm').val(id_usuario);

            var datos = $.ajax({
                url: "{{ route('comentarios.asesores') }}",
                type: "POST",
                dataType: "json",
                data: {
                    id_usuario
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    document.getElementById('comentarios-realizados-cliente-almacen').innerHTML = res
                        .comentarios;
                }
            });
            datos.fail(() => {
                console.log('ERROR');
            });
        }

        EliminarClienteAsesor = (form) => {
            Swal.fire({
                title: 'Estas seguro de eliminar?',
                text: "Se eliminará toda la información, no hay retorno",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (checksSelected() == true) {

                        loandingPanel();

                        var data = ElimiarUsuarioAsesor(form);
                        data.done((res) => {
                            loadedPanel();
                            if (res.status == true) {
                                var select = document.getElementById("asesor_co");
                                var event = new Event('change');
                                select.dispatchEvent(event);
                            }
                        });
                        data.fail(() => {
                            loadedPanel()
                            document.getElementById('spinner-info-maestra').style.display = 'none';
                            Swal.fire(
                                'Error!',
                                'Hubo un problema al procesar la solicitud',
                                'error'
                            )
                        })
                    } else {
                        Swal.fire(
                            'Error!',
                            'Debes seleccionar por lo menos un valor',
                            'error'
                        )
                    }

                }
            })
        }

        checksSelected = () => {
            seleccionados = [];
            $('input[type=checkbox]:checked').each(function() {
                seleccionados.push($(this).val());
            });
            if (seleccionados.length > 0) {
                return true
            }
            return false
        }

        ElimiarUsuarioAsesor = (form) => {
            var formData = new FormData(document.getElementById(form));
            formData.append('dato', 'valor');
            var datos = $.ajax({
                url: "{{ route('delete.record.clientes') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });
            return datos;
        }

        AgregarComentariosSeguimientosCliente = () => {
            var cliente = $('#id_validar_cliente_alm').val();
            var comentario = $('#new-coment-user-alm').val();

            var datos = $.ajax({
                url: "{{ route('add.coments.asesor') }}",
                type: "POST",
                dataType: "json",
                data: {
                    cliente,
                    comentario
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    document.getElementById('comentarios-realizados-cliente-almacen').innerHTML = res
                        .comentarios;
                    $('#new-coment-user-alm').val('');
                }
            });
            datos.fail(() => {
                console.log('ERROR');
            });
        }


        ObtenerInformacionCliente = (id_cliente) => {

            $('#informacion-personal-del-cliente').modal('show');
            var event = new Event("change");

            var datos = $.ajax({
                url: "{{ route('info.general.cliente') }}",
                type: "POST",
                dataType: "json",
                data: {
                    id_cliente
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    $('#id_cliente_crm').val(id_cliente);

                    $('#cedula_cliente').val(res.data.cedula_cliente)
                    $('#primer_nombre').val(res.data.nombre_1)
                    $('#segundo_nombre').val(res.data.nombre_2)
                    $('#primer_apellido').val(res.data.apellido_1)
                    $('#segundo_apellido').val(res.data.apellido_2)
                    $('#genero').val(res.data.genero)
                    $('#celular_1').val(res.data.celular_1)
                    $('#celular_2').val(res.data.celular_2)
                    $('#email').val(res.data.email)
                    $('#cumple').val(res.data.fecha_cumple)
                    $('#depto_crm').val(res.data.id_depto)
                    $('#barrio').val(res.data.barrio)
                    $('#direccion').val(res.data.direccion)
                    $('#origen').val(res.data.origen)

                    var select = document.getElementById("depto_crm");
                    select.dispatchEvent(event);

                    setTimeout(() => {
                        seleccionarOpcionPorData(res.data.id_ciudad)
                    }, 500);
                }
            });
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        }

        ActualizarInformacionCliente = (form) => {
            var formData = new FormData(document.getElementById(form));

            var ciudad = $('#ciudad').find('option:selected');
            formData.append('id_ciudad', ciudad.data('id_city'));
            formData.append('id_depto', ciudad.data('id_depto'));
            formData.append('id_pais', ciudad.data('id_pais'));

            var datos = $.ajax({
                url: "{{ route('update.info.cliente.crm') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });

            datos.done((res) => {
                if (res.status == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: res.mensaje,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                if (res.status == false) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: res.mensaje,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Revisa la información y vuelve a intentar',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        }

        AgendarLlamadaCliente = (id_cliente) => {
            $('#agendar-proxima-llamada-cliente').modal('show');
            $('#id_cliente_crm_llam').val(id_cliente);
        }

        progrmarFechaLlamadaCliente = () => {
            var fecha = $('#fecha_a_llamar_cliente').val();
            var id_cliente = $('#id_cliente_crm_llam').val();

            if (fecha.length > 0 && id_cliente.length > 0) {
                var datos = $.ajax({
                    url: "{{ route('programar.llamada.cliente') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        id_cliente,
                        fecha
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                datos.done((res) => {
                    if (res.status == true) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Llamada programada exitosamente',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#fecha_a_llamar_cliente').val('');
                        document.getElementById('llamar' + id_cliente).innerHTML = fecha
                    }
                });
                datos.fail(() => {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Hubo un problema al procesar la solicitud',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'No se aceptan campos vacios',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }

        MarcarVentaEfectivaCliente = (id_cliente, cedula) => {
            $('#modal-marcar-venta-efectiva-cliente').modal('show');
            $('#ced_user-efect-puntov').val(cedula);
            $('#id_user-efect-puntov').val(id_cliente);

            var datos = $.ajax({
                url: "{{ route('info.efectivo.cliente') }}",
                type: "POST",
                dataType: "json",
                data: {
                    id_cliente
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    document.getElementById('informacion-productos-cotizados-cliente').innerHTML = res.data;
                    $('#valor_total_pagar_user_p').val(new Intl.NumberFormat("es-CO").format(res.a_pagar));
                }
            });
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        }

        ValidarPrecioProductoC = (id_producto) => {
            var datos = $.ajax({
                url: PathUrlApp() + "obtener-precio-producto",
                type: "POST",
                dataType: "json",
                data: {
                    id_producto
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    $('#precio-uni-prod-bd').val(res.precio);
                    $('#descuento-uni-prod-bd').val(res.descuento);
                    $('#nom-uni-prod-bd').val(res.producto);
                }
            });
        }

        AgregarProductoClienteCotizado = (form) => {
            var cotizacion = $('#idSessionCotizacion').val();
            var formData = new FormData(document.getElementById(form));
            formData.append('cotizacion', cotizacion);
            var datos = $.ajax({
                url: PathUrlApp() + "agregar-producto-cliente",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });

            datos.done((res) => {
                if (res.status == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'La información se actualizó correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    $('#sku-uni-prod').val(null).trigger('change');

                    document.getElementById('informacion-productos-cotizados-cliente').innerHTML = res.data;
                    $('#valor_total_pagar_user_p').val(new Intl.NumberFormat("es-CO").format(res.a_pagar));
                }
            });
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        }

        EliminarProductoCotizadoCrm = (id_cotizacion) => {
            Swal.fire({
                title: 'Estas seguro de eliminar?',
                text: "No podrás reversar esta operación",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var data = ConfirmarEliminarProducto(id_cotizacion);

                    data.done((res) => {
                        if (res.status == true) {
                            Swal.fire(
                                'Eliminado!',
                                'El producto fue eliminado',
                                'success'
                            )
                            document.getElementById('informacion-productos-cotizados-cliente')
                                .innerHTML = res.data;
                            $('#valor_total_pagar_user_p').val(new Intl.NumberFormat("es-CO").format(res
                                .a_pagar));
                        }
                    });
                    data.fail(() => {
                        Swal.fire(
                            'Error!',
                            'Hubo un problema al procesar la solicitud',
                            'error'
                        )
                    });
                }
            })
        }

        ConfirmarEliminarProducto = (id_cotizacion) => {
            var cotizacion = $('#idSessionCotizacion').val();
            var datos = $.ajax({
                url: PathUrlApp() + "eliminar-producto",
                type: "POST",
                dataType: "json",
                data: {
                    id_producto: id_cotizacion,
                    cotizacion
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            return datos;
        }

        MarcarUsuarioVentaEfectivaAlm = (form) => {

            $('#btn-marcar-venta-ef').prop('disabled', true);

            var formData = new FormData(document.getElementById(form));
            formData.append('data', 'data');
            var datos = $.ajax({
                url: PathUrlApp() + "actualizar-cliente-efectivo",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });

            datos.done((res) => {
                if (res.status == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'La información se actualizó correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            });
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Revisa los campos en rojo y el estado y vuelve a intentar',
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btn-marcar-venta-ef').prop('disabled', false);
            });
        }

        ConfigurarColorEstrellasCRM = (id_cliente) => {
            $('.cliente_crm' + id_cliente).removeClass('text-danger');
            $('.cliente_crm' + id_cliente).removeClass('text-gray');
            $('.cliente_crm' + id_cliente).addClass('text-gray');
        }

        NotificarEliminacionClienteCrmAdmin = (id_cliente) => {
            Swal.fire({
                title: 'Estas seguro de eliminar?',
                text: "Se eliminará el registro del cliente",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, generar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    loandingPanel()
                    var data = confirmarSolicitudEliminacionClienteAdmin(id_cliente);

                    data.done((res) => {
                        loadedPanel()
                        if (res.status == true) {
                            var select = document.getElementById("asesor_co");
                            var event = new Event("change");
                            select.dispatchEvent(event);
                        }
                    });
                    data.fail(() => {
                        loadedPanel()
                        Swal.fire(
                            'Error!',
                            'Hubo un problema al procesar la solicitud',
                            'error'
                        )
                    });
                }
            })
        }

        NotificarEliminacionClienteCrm = (id_cliente) => {
            Swal.fire({
                title: 'Estas seguro de eliminar?',
                text: "Se generará una solicitud para la respectiva solicitud",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, generar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    loandingPanel()
                    var data = confirmarSolicitudEliminacionCliente(id_cliente);

                    data.done((res) => {
                        loadedPanel()
                        if (res.status == true) {
                            var select = document.getElementById("asesor_co");
                            var event = new Event("change");
                            select.dispatchEvent(event);
                        }
                    });
                    data.fail(() => {
                        loadedPanel()
                        Swal.fire(
                            'Error!',
                            'Hubo un problema al procesar la solicitud',
                            'error'
                        )
                    });
                }
            })
        }

        confirmarSolicitudEliminacionClienteAdmin = (id_cliente) => {
            var datos = $.ajax({
                url: "{{ route('delete.record.clientes') }}",
                type: "POST",
                dataType: "json",
                data: {
                    id_cliente
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            return datos;
        }

        confirmarSolicitudEliminacionCliente = (id_cliente) => {
            var datos = $.ajax({
                url: "{{ route('solicitud.eliminar.cliente') }}",
                type: "POST",
                dataType: "json",
                data: {
                    id_cliente
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            return datos;
        }

        validarEstella = (tipo, usuario) => {
            if (tipo == 3) {
                $('#ventaEfectiva' + usuario).click()
            } else {
                var datos = $.ajax({
                    url: "{{ route('update.tipoC.crm') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        tipo,
                        cliente: usuario
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                datos.done((res) => {
                    if (res.status == true) {
                        toastr.success('Cliente actualizado');

                        var cedula = $('#cedula' + usuario).text()

                        cambiarElAtributoDeBtnEfectivo(usuario, tipo, cedula)

                        $('.star' + usuario).removeClass('text-danger');
                        $('.star' + usuario).removeClass('text-gray');
                        $('.star' + usuario).addClass('text-gray');
                        for (let i = 1; i <= tipo; i++) {
                            $('#cl' + usuario + i).removeClass('text-gray');
                            $('#cl' + usuario + i).addClass('text-danger');
                        }
                    }
                });
                datos.fail(() => {
                    toastr.error('Hubo un problema al actualizar');
                });
            }
        }

        function seleccionarOpcionPorData(data) {
            var selectElement = document.getElementById("ciudad");
            var optionToSelect = Array.from(selectElement.options).find(option => option.dataset.id_city === data);
            if (optionToSelect) {
                optionToSelect.selected = true;
            }
        }

        ActualizarValoresCheck = () => {
            $('input[type=checkbox]').prop('checked', $('#checkSelectTodos').is(':checked'));
        }

        cambiarElAtributoDeBtnEfectivo = (id_user, evento, cedula) => {
            var btn = document.getElementById("ventaEfectiva" + id_user);
            cedula = cedula.replace(/\s/g, "")
            if (evento != 3) {
                btn.setAttribute("onclick", "VentaEfectivaClienteCrm('" + id_user + "', '" + cedula + "')");
            } else {
                btn.setAttribute("onclick", "MarcarVentaEfectivaCliente('" + id_user + "', '" + cedula + "')");
            }
        }

        LimpiarCamposModal = () => {
            $('#fve_efect').val('')
            $('#co_efect_soli').val('')
            $('#num_cedula_efect').val('')
            $('#nombre1_efect').val('')
            $('#nombre2_efect').val('')
            $('#apellido1_efect').val('')
            $('#apellido2_efect').val('')
            $('#forma_pago_c').val('')
            $('#valor_efect_total').val('')
            $('#productos-efect_v').html('')
        }

        obtenerCiudadesCrm = (id) => {
            var datos = $.ajax({
                url: "{{ route('consultar.ciudad') }}",
                type: "POST",
                dataType: "json",
                data: {
                    id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    $('#ciudad').html(res.ciudad);
                }
            });
        }

        ActualizarInformacionM = (id) => {
            loandingPanel()
            var datos = $.ajax({
                url: "{{ route('search.info.tipo.cliente') }}",
                type: "POST",
                dataType: "json",
                data: {
                    tipo_cliente: id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                loadedPanel()
                document.getElementById('tableInfoAsesorClientesCRM').innerHTML = res.table
                formmatTableAsesor()
            });
        }

        VentaEfectivaClienteCrm = (id_cliente) => {
            $('#forma_pago_c').prop('disabled', true)
            $('#cierre_venta').prop('disabled', true)
            $('#btn-change-efectivo').prop('disabled', true)
            $('#id_user_crm').val(id_cliente)
            $('#ModalVentaEfectivaErp').modal('show')
        }

        functionSpinner = (id1, id2, style, text) => {
            $('#text-spinner').text(text)
            var spinner = document.getElementById(id1)
            spinner.setAttribute('id', id2)
            document.getElementById(id2).style.display = style;
        }

        ValidarInfoClienteEfectivo = () => {

            var co = $('#co_efect').val()
            var fve = $('#fve_efect').val()

            if (co.length > 0 && fve.length > 0) {

                functionSpinner('spinner-antes', 'spinner-info', 'block', 'Buscando...')

                setTimeout(() => {
                    var datos = $.ajax({
                        url: "{{ route('ventas.efectivas') }}",
                        type: "POST",
                        dataType: "json",
                        data: {
                            fve,
                            co
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    datos.done((res) => {

                        functionSpinner('spinner-info', 'spinner-antes', 'none', '')

                        if (res.status == true) {
                            var m_pago = res.cliente[0].forma_pago;
                            if (m_pago.trim() == 'CO') {
                                var pago = 'CONTADO'
                            } else {
                                var pago = 'CREDITO'
                            }
                            $('#co_efect_soli').val(res.co)
                            $('#num_cedula_efect').val(res.cliente[0].cedula)
                            $('#nombre1_efect').val(res.cliente[0].nombre)
                            $('#nombre2_efect').val('')
                            $('#apellido1_efect').val(res.cliente[0].ap1)
                            $('#apellido2_efect').val(res.cliente[0].ap2)
                            $('#forma_pago_c').val(pago)
                            $('#valor_efect_total').val("$ " + new Intl.NumberFormat().format(res
                                .cliente[0].valor_ttal))
                            $('#productos-efect_v').html(res.productos)

                            $('#forma_pago_c').prop('disabled', false)
                            $('#cierre_venta').prop('disabled', false)
                            $('#btn-change-efectivo').prop('disabled', false)

                        } else {
                            toastr.error('No hay información para esta factura')
                            LimpiarCamposModal();
                        }
                    });
                    datos.fail(() => {
                        functionSpinner('spinner-info', 'spinner-antes', 'none', '')
                        toastr.error('Hubo un problema al procesar la solicitud')
                    });
                }, 1000);
            }
        }

        MarcarVentaEfectivaUsuario = () => {
            functionSpinner('spinner-antes', 'spinner-info', 'block', 'Guardando...')
            $('#btn-change-efectivo').prop('disabled', true)

            var co = $('#co_efect_soli').val()
            var id_user = $('#id_user_crm').val()

            var formData = new FormData(document.getElementById('formInfoEfectivoC'));
            formData.append('co', co)

            var datos = $.ajax({
                url: "{{ Route('marcar.efectivo') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {

                var cedula_user = res.cliente.cedula_cliente;

                $('.star' + id_user).removeClass('text-gray')
                $('.star' + id_user).removeClass('text-danger')
                $('.star' + id_user).addClass('text-danger')

                $('#cedula' + id_user).html(cedula_user)
                $('#cliente' + id_user).html(res.cliente.nombre_1 + " " + res.cliente.apellido_1 + " " + res
                    .cliente.apellido_2)
                $('#ciudad' + id_user).html(res.cliente.ciudad)
                $('#celular' + id_user).html(res.cliente.celular_1)

                var product = res.productos.map(function(val) {
                    var prods = '';
                    var products = '<div class="dropdown-item">' + val.producto +
                        '</div><div class="dropdown-divider"></div>';
                    prods += products
                    return prods
                })

                $('#products' + id_user).html(product)
                document.getElementById('formInfoEfectivoC').reset()
                $('#productos-efect_v').html('')

                functionSpinner('spinner-info', 'spinner-antes', 'none', '')
                $('#ModalVentaEfectivaErp').modal('hide')

                if (res.status == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'La información se actualizó correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }

                cambiarElAtributoDeBtnEfectivo(id_user, '3', cedula_user)
            });
            datos.fail(() => {
                functionSpinner('spinner-info', 'spinner-antes', 'none', '')
                $('#btn-change-efectivo').prop('disabled', false)
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un problema al procesar la solicitud',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        }

        CrearTerceroSiesa = () => {
            var id = $('#id_cliente_crm').val()
            var lista = $('#lista_precio').val()
            var tipo = $('#tipo_cliente_siesa').val()

            if (lista.length > 0 && tipo.length > 0) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'info',
                    title: 'Creando información en SIESA...',
                    showConfirmButton: false,
                    timer: 10000
                })

                var datos = $.ajax({
                    url: "{{ Route('crear.siesa') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        id,
                        lista,
                        tipo
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                datos.done((res) => {
                    if (res.status == true) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'El tercero se creó exitosamente en SIESA',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                })
                datos.fail(() => {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Completa todos los campos obligatorios y vuelve a intentar',
                        showConfirmButton: false,
                        timer: 2500
                    });
                })
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Revisa los campos en rojo y vuelve a intentar',
                    showConfirmButton: false,
                    timer: 2500
                });
            }
        }
        VisualizarProductosCliente = (id_cliente) => {
            $('#informacion-productos-cotizados').modal('show');
            document.getElementById('informacion-productos-cotizados-cliente').innerHTML = "";
            $('#valor_a_pagar').val('');
            Swal.fire({
                position: 'top',
                icon: 'info',
                toast: true,
                title: 'Cargando comentarios.',
                showConfirmButton: false,
                timer: 10000
            })

            var datos = $.ajax({
                url: "{{ route('items.cotizados.crm') }}",
                type: "POST",
                dataType: "json",
                data: {
                    id_cliente
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    Swal.close();
                    document.getElementById('informacion-productos-cotizados-cliente').innerHTML = res
                        .productos;
                    $('#valor_a_pagar').val("$ " + new Intl.NumberFormat("es-CO").format(res.vlr_pagar));
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

        async function copyImageToClipboard(imageUrl, id_cliente) {

            let number = $(`#cellnumber_cumple_${id_cliente}`).val();
            let text = $(`#text_cumple_${id_cliente}`).val();
            let text_cliente = $(`#text_cumple_${id_cliente}`).val();

            try {
                // Fetch the image
                const response = await fetch(imageUrl);
                const blob = await response.blob();

                // Create an offscreen canvas
                const img = await createImageBitmap(blob);
                const canvas = document.createElement('canvas');
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0);

                // Convert canvas to blob (PNG)
                canvas.toBlob(async (pngBlob) => {
                    const item = new ClipboardItem({
                        "image/png": pngBlob
                    });
                    await navigator.clipboard.write([item]);
                    window.open(
                        `https://web.whatsapp.com/send/?phone=${number}&text=${text}&type=phone_number&app_absent=0`,
                        'BLANK_');

                    $.ajax({
                        type: "POST",
                        url: "{{ route('crm_almacenes.general.create_birthday') }}",
                        data: {
                            "id_client": id_cliente,
                            "cell_client": number,
                            "text_client": text_cliente,
                            "img_client": imageUrl
                        },
                        success: function (response) {
                            console.log(response);
                        }, error: (err) => {
                            console.error(err);
                        }
                    });

                }, 'image/png');
            } catch (error) {
                console.error("Error al copiar la imagen al portapapeles:", error);
            }
        }
    </script>
    @yield('footer')
</footer>

</html>
