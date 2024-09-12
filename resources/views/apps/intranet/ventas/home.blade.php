@extends('apps.intranet.plantilla.app')
@section('title')
    Ventas
@endsection
@section('ventas')
    bg-danger active
@endsection
@section('body')
    @php
        $baseUrl = env('APP_BASE_URL', 'http://localhost');
    @endphp
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Ventas</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Ventas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @if (session('error'))
        <div class="col-12 d-flex justify-content-center" id="hola" style="display: block;">
            <div class="alert alert-danger col-5 text-center" id="errorAlert">
                {{ session('error') }}
            </div>
        </div>
        <script>
            setTimeout(function() {
                $("#errorAlert").fadeOut("slow", function() {
                    $("#hola").hide();
                });
            }, 1000);
        </script>
    @endif
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Memorandos</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'ventas', 'memo' => 'memorandos-ventas']) }}">
                                <img src="{{ asset('icons/book.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Cotizador Albura</strong>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <a href="{{ route('lista.precios.crexit', ['origen' => '1']) }}">
                                    <img src="{{ asset('icons/cotizador.png') }}" width="40%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>CRM - Almacenes</strong>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <a href="{{ route('inicio.crm.punto.venta') }}">
                                    <img src="{{ asset('icons/gcp.png') }}" width="40%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" hidden>
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>GCP <small>Almacenes</small></strong>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <!-- {{ $baseUrl }}/crm/php/login/autenticar.php -->
                                <a href="{{ $baseUrl }}/crm/php/autenticar.php?txt_usuario={{ base64_encode(Auth::user()->usuario) }}&txt_clave={{ base64_encode(session('pwdApp')) }}"
                                    target="_BLANK">
                                    <img src="{{ asset('icons/gcp.png') }}" width="40%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>CRM - Ecommerce</strong>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <a href="{{ $baseUrl }}/crm_ecommerce/login/aut/autenticar.php?txt_name_user={{ base64_encode(Auth::user()->usuario) }}&&txt_passwd={{ base64_encode(session('pwdApp')) }}"
                                    target="_BLANK">
                                    <img src="{{ asset('icons/crm.png') }}" width="40%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" hidden>
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Cotizador Pruebas</strong>
                        </div>
                        <div class="card-body text-center">
                            <div onclick="event.preventDefault(); document.getElementById('autenticar-cotizador-pruebas').submit();"
                                style="cursor: pointer;">
                                <img src="{{ asset('icons/pruebas.png') }}" width="40%" alt="">
                            </div>
                            <form hidden action="{{ $baseUrl }}/cotizador_pruebas/public/login" id="autenticar-cotizador-pruebas" target="_blank"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <input name="usuario" id="usuario" value="{{ Auth::user()->usuario }}" type="text" placeholder="Usuario">
                                <input name="password" id="password" value="{{ session('pwdApp') }}" type="password" placeholder="Contraseña">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Evaluación</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="#" class="" data-toggle="modal" data-target="#exampleModal">
                                <img src="{{ asset('icons/opinion.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ingreso De Evaluación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times-circle" style="color: #c82333;"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center m-2">
                        <h5>Ingrese Su Codigo Para Ingresar</h5>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <div class="row col-8">
                            <form>
                                <div class="d-flex flex-row text-center d-flex justify-content-evenly">
                                    <input type="text" class="caracter form-control col-2 text-center" id="digito1" name="digito"
                                        maxlength="1" oninput="limitarInput(this, 2)" placeholder="-">
                                    <input type="text" class="caracter form-control col-2 text-center" id="digito2" name="digito"
                                        maxlength="1" oninput="limitarInput(this, 3)" placeholder="-">
                                    <input type="text" class="caracter form-control col-2 text-center" id="digito3" name="digito"
                                        maxlength="1" oninput="limitarInput(this, 4)" placeholder="-">
                                    <input type="text" class="caracter form-control col-2 text-center" id="digito4" name="digito"
                                        maxlength="1" oninput="limitarInput(this)" placeholder="-">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <form action="{{ route('paginas.evaluacion') }}" method="GET">
                        <input type="text" id="id" name="id" value="1" hidden>
                        <input type="text" id="codigos" name="codigos" hidden>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-walking"></i> Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('js/evaluaciones_regionales.js') }}"></script>
@endsection
