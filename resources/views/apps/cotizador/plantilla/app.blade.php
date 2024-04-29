<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cotizador - @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('img/alburac.png') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
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

<body class="hold-transition layout-top-nav loaded" style="background-color: #969696">

    <div class="loader-wrapper">
        <div class="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>

    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-md navbar-white" style="background:  #be0811;">
            <div class="container">
                <div class="navbar-brand">
                    <img src="{{ asset('img/blanco2.png') }}" alt="Logo Muebles Albura SAS" class="brand-image">
                </div>
                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{ route('catalogo.cotizador') }}" class="nav-link text-white">Catálogo de productos</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('inicio.crm.punto.venta') }}" class="nav-link text-white">CRM</a>
                        </li>
                    </ul>
                </div>
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link text-white" id="idBtnGoOut" role="button">
                            <i class="fas fa-sign-out-alt"></i>
                            Salir
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="content-wrapper">
            <div class="content-header" style="padding: 0px 0px">
                <div class="card">
                    <div class="card-header">
                        <div class="">
                            <div class="row">
                                <div class="col-md-8 mb-2">
                                    <h4><i class="fas fa-tachometer-alt"></i> Panel - Lista de precios <a
                                            href="{{ route('precios.nueva.cotizacion') }}" type="button" class="btn btn-sm btn-success">Nueva
                                            cotización</a>
                                    </h4>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon3">Retomar Cotización</span>
                                        </div>
                                        <input type="number" class="form-control" id="basic-url" onchange="ValidarNumeroCedulaRetomar(this.value)"
                                            placeholder="Número de cédula" autocomplete="off" aria-describedby="basic-addon3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                @yield('body')
            </div>
            <div class="modal fade" id="modal-historial-cotizaciones">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h4 class="modal-title">Retomar cotización</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="timeline" id="id-historial-cotizaciones">
                                        <div>
                                            <i class="fas fa-clock bg-gray"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer right-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar información</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</body>
<footer>



    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            document.querySelector('body').classList.add("loaded")

            setInterval(function() {
                $.get("{{ url('check-session') }}", function(data) {
                    if (data.status == 'inactive') {
                        Swal.fire('La sesión ha expirado, genera una nueva cotización');
                    }
                });
            }, 300000);
        });

        loandingPanel = () => {
            document.querySelector('body').classList.remove("loaded")
        }

        loadedPanel = () => {
            document.querySelector('body').classList.add("loaded")
        }

        ValidarNumeroCedulaRetomar = (cedula) => {
            if (cedula.length > 0) {

                loandingPanel()

                var datos = $.ajax({
                    url: "{{ route('search.info.cliente') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        cedula
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                datos.done((res) => {

                    loadedPanel()

                    if (res.status == true) {
                        $('#modal-historial-cotizaciones').modal('show');
                        document.getElementById('id-historial-cotizaciones').innerHTML = res.historial;
                    }
                    if (res.status == false) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: res.mensaje,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                });
                datos.fail(() => {

                    loadedPanel()

                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Revisa la información y vuelve a intentar',
                        showConfirmButton: false,
                        timer: 3000
                    });
                });
            }
        }
    </script>
    @yield('footer')
</footer>

</html>
