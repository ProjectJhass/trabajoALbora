@extends('apps.intranet.plantilla.app')
@section('title')
    Logística
@endsection
@section('logistica')
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
                    <h4>Logística</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Logística</li>
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
                            <strong>Servicios técnicos</strong>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <a href="{{ route('analytics') }}">
                                    <img src="{{ asset('storage/icons/servicios1.png') }}" width="40%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->dpto_user != '8')
                    <div class="col-md-3 mb-3">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <strong>Carpeta temporal</strong>
                            </div>
                            <div class="card-body text-center">
                                <a href="{{ route('intranet.docs.tmp', ['dpto' => 'logistica']) }}">
                                    <img src="{{ asset('storage/icons/temporal.png') }}" width="40%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <strong>Memos Servicios técnicos</strong>
                            </div>
                            <div class="card-body text-center">
                                <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'logistica', 'memo' => 'memorandos-servicios-tecnicos']) }}">
                                    <img src="{{ asset('storage/icons/apoyo-tecnico.png') }}" width="40%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <strong>Instructivos de inventario</strong>
                            </div>
                            <div class="card-body text-center">
                                <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'logistica', 'memo' => 'instructivos-de-inventario']) }}">
                                    <img src="{{ asset('storage/icons/inventario.png') }}" width="40%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <strong>Memorandos vigentes</strong>
                            </div>
                            <div class="card-body text-center">
                                <a href="{{ route('menu.memos.log') }}">
                                    <img src="{{ asset('storage/icons/memorando1.png') }}" width="40%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <strong>Memorandos derogados</strong>
                            </div>
                            <div class="card-body text-center">
                                <a
                                    href="{{ route('intranet.memorandos.areas', ['seccion' => 'logistica', 'memo' => 'logistica-memorandos-derogados']) }}">
                                    <img src="{{ asset('storage/icons/memorando2.png') }}" width="40%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <strong>Seguimiento vehículos</strong>
                            </div>
                            <div class="card-body text-center">
                                <a href="{{ route('albura.autos') }}">
                                    <img src="{{ asset('storage/icons/automovil.png') }}" width="40%" alt="">
                                </a>
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
                        <input type="text" id="id" name="id" value="3" hidden>
                        <input type="text" id="codigos" name="codigos" hidden>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-walking"></i> Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('js/logistica.js') }}"></script>
    <script src="{{ asset('js/evaluaciones_regionales.js') }}"></script>
@endsection
