@extends('apps.intranet.plantilla.app')
@section('title')
    Recursos humanos
@endsection
@section('rrhh')
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
                    <h4>Recursos humanos</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">RRHH</li>
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
                @if (Auth::user()->dpto_user != '8')
                    <div class="col-md-3 mb-3">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <strong>Carpeta temporal</strong>
                            </div>
                            <div class="card-body text-center">
                                <a href="{{ route('intranet.docs.tmp', ['dpto' => 'rrhh']) }}">
                                    <img src="{{ asset('storage/icons/temporal.png') }}" width="40%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <strong>Memorandos</strong>
                            </div>
                            <div class="card-body text-center">
                                <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'rrhh', 'memo' => 'memorandos-rrhh']) }}">
                                    <img src="{{ asset('storage/icons/memorando.png') }}" width="40%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <strong>Políticas de seguridad</strong>
                            </div>
                            <div class="card-body text-center">
                                <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'rrhh', 'memo' => 'politicas-de-seguridad']) }}">
                                    <img src="{{ asset('storage/icons/seguridad.png') }}" width="40%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <strong>Documentos varios</strong>
                            </div>
                            <div class="card-body text-center">
                                <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'rrhh', 'memo' => 'documentos-varios-rrhh']) }}">
                                    <img src="{{ asset('storage/icons/memorando1.png') }}" width="40%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <strong>Reglamento interno de trabajo</strong>
                            </div>
                            <div class="card-body text-center">
                                <a href="{{ route('reglamento.interno') }}">
                                    <img src="{{ asset('storage/icons/reglamento.png') }}" width="40%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->dpto_user == '4' || Auth::user()->id == '6401505' || (Auth::user()->dpto_user == '2' && Auth::user()->permiso_dpto == '1'))
                        @if (Auth::user()->dpto_user != '2')
                            <div class="col-md-3 mb-3">
                                <div class="card card-outline card-danger">
                                    <div class="card-header">
                                        <strong>Retirados</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <a href="{{ $baseUrl }}/retirados/php/login.php?txt_user_rrhh={{ base64_encode('pruebas') }}&&txt_pass_rrhh={{ base64_encode('pruebas') }}"
                                                target="_BLANK">
                                                <img src="{{ asset('storage/icons/retirados.png') }}" width="40%" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="card card-outline card-danger">
                                    <div class="card-header">
                                        <strong>Hojas de vida</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <a href="{{ $baseUrl }}/hojas-de-vida/login/aut/login.php?txt_user_rrhh={{ base64_encode('pruebas') }}&&txt_pass_rrhh={{ base64_encode('pruebas') }}"
                                                target="_BLANK">
                                                <img src="{{ asset('storage/icons/cv.png') }}" width="40%" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card card-outline card-danger">
                                    <div class="card-header">
                                        <strong>Registro</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <a href="{{ $baseUrl }}/registro/" target="_BLANK">
                                                <img src="{{ asset('storage/icons/registro.png') }}" width="40%" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card card-outline card-danger">
                                    <div class="card-header">
                                        <strong>Cumpleaños</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center" style="cursor: pointer;" onclick="CargarInformacionRRHH('cumple.php');">
                                            <img src="{{ asset('storage/icons/cumple.png') }}" width="40%" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card card-outline card-danger">
                                    <div class="card-header">
                                        <strong>Reloj fábrica</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <a href="{{ Route('reloj.rrhh') }}"><img src="{{ asset('storage/icons/clock.png') }}" width="40%"
                                                    alt=""></a>
                                            {{-- <a href="{{ $baseUrl }}/reloj-fabrica/login/" target="_BLANK">
                                            <img src="{{ asset('storage/icons/clock.png') }}" width="40%" alt="">
                                        </a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card card-outline card-danger">
                                    <div class="card-header">
                                        <strong>Evaluaciòn</strong>
                                    </div>
                                    <div class="card-body text-center">
                                        <a href="#" class="" data-toggle="modal" data-target="#exampleModal">
                                            <img src="{{ asset('storage/icons/opinion.png') }}" width="40%" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-3 mb-3">
                            <div class="card card-outline card-danger">
                                <div class="card-header">
                                    <strong>Historial Evaluación</strong>
                                </div>
                                <div class="card-body text-center">
                                    <a href="{{ route('paginas.historialEvaluacion') }}">
                                        <img src="{{ asset('storage/icons/chequeo.png') }}" width="40%" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card card-outline card-danger">
                                <div class="card-header">
                                    <strong>Flayer - SAGRILAFT/PTEE</strong>
                                </div>
                                <div class="card-body text-center">
                                    <a href="{{ route('flayer') }}">
                                        <img src="{{ asset('icons/actualizar-datos.png') }}" width="40%" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-3 mb-3">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <strong>SST</strong>
                            </div>
                            <div class="card-body text-center">
                                <a href="{{ route('sst') }}">
                                    <img src="{{ asset('storage/icons/sst.png') }}" width="40%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Fábrica</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'rrhh', 'memo' => 'comunicados-fabrica-rrhh']) }}">
                                <img src="{{ asset('storage/icons/fabrica.png') }}" width="40%" alt="">
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
                        <input type="text" id="id" name="id" value="2" hidden>
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
