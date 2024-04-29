@extends('apps.intranet.plantilla.app')
@section('title')
    Cartera
@endsection
@section('cartera')
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
                    <h4>Cartera</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Cartera</li>
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
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Carpeta temporal</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.docs.tmp', ['dpto' => 'cartera']) }}">
                                <img src="{{ asset('storage/icons/temporal.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Cartas generales</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'cartera', 'memo' => 'cartas-generales']) }}">
                                <img src="{{ asset('storage/icons/cartas.png') }}" width="40%" alt="">
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
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'cartera', 'memo' => 'memorandos-cartera']) }}">
                                <img src="{{ asset('storage/icons/memorando.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Actas de visita</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'cartera', 'memo' => 'actas-de-visita']) }}">
                                <img src="{{ asset('storage/icons/contrato.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Politicas y leyes</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'cartera', 'memo' => 'politicas-y-leyes']) }}">
                                <img src="{{ asset('storage/icons/leyes.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Liq. Intereses y Descuentos</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('liquidador.intereses') }}">
                                <img src="{{ asset('storage/icons/interes.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Digitalización</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ $baseUrl }}/digitalizacion/login/" target="_BLANK">
                                <img src="{{ asset('storage/icons/digital.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>OnCredit</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="https://albura.coxti.com/auth" target="_BLANK">
                                <img src="{{ asset('storage/icons/credit.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Bext trámites</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="https://credidescuentos.bextramites.com/login.php?empresa=credidescuentos" target="_BLANK">
                                <img src="{{ asset('storage/icons/bext.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Páginas para referenciar</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('paginas.referenciar') }}">
                                <img src="{{ asset('storage/icons/link.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Evaluaciòn</strong>
                        </div>
                        <div class="col-12 row d-flex justify-content-between">
                            <div class="card-body text-center col-6 p-0 mt-2 mb-3">
                                <small><b>Cartera</b></small><br>
                                <a onclick="abrir(7)">
                                    <img src="{{ asset('storage/icons/opinion.png') }}" width="65%" alt="">
                                </a>
                            </div>
                            <div class="card-body text-center col-6 p-0 mt-2 mb-3">
                                <small><b>Oncredit</b></small><br>
                                <a onclick="abrir(8)">
                                    <img src="{{ asset('storage/icons/credit.png') }}" width="65%" alt="">
                                </a>
                            </div>

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
                        <input type="text" id="id" name="id" value="" hidden>
                        <input type="text" id="codigos" name="codigos" hidden>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-walking"></i> Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        function abrir(id) {
            $('#exampleModal').modal('show');
            $('#id').val(id)
        }
    </script>
    <script src="{{ asset('js/logistica.js') }}"></script>
    <script src="{{ asset('js/evaluaciones_regionales.js') }}"></script>
@endsection
