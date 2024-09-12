@extends('apps.intranet.plantilla.app')
@section('title')
    Fábrica
@endsection
@section('fabrica')
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
                    <h4>Fábrica</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Fábrica</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Carpeta temporal</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.docs.tmp', ['dpto' => 'fabrica']) }}">
                                <img src="{{ asset('icons/temporal.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Intranet fábrica</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('home.intranet.fabrica') }}">
                                <img src="{{ asset('icons/fabrica_int.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Bodega transporte</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'fabrica', 'memo' => 'bodega-transporte']) }}">
                                <img src="{{ asset('icons/camion.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Combinación de telas</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'fabrica', 'memo' => 'combinacion-de-telas']) }}">
                                <img src="{{ asset('icons/tela.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Comercializadora</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'fabrica', 'memo' => 'fabrica-comercializadora']) }}">
                                <img src="{{ asset('icons/casa.png') }}" width="40%" alt="">
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
                            <a href="{{ route('memos.fabrica') }}">
                                <img src="{{ asset('icons/memorando.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>PQRS Fábrica</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ $baseUrl }}/plataformas_web/public/formulario-registro-pqrs" target="_BLANK">
                                <img src="{{ asset('icons/pqr.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Videos armado</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'fabrica', 'memo' => 'videos-armado']) }}">
                                <img src="{{ asset('icons/video.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Evaluaciones</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ $baseUrl }}/encuestas_fabrica/tipo.php" target="_BLANK">
                                <img src="{{ asset('icons/eval.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Ideas</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ url('fabrica/docs/ideas-fabrica') }}">
                                <img src="{{ asset('icons/ideas.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div> --}}
                @if (Auth::user()->id == '1087991335' || Auth::user()->id == '42150928' || Auth::user()->permisos == '4')
                    <div class="col-md-3 mb-3">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <strong>Prototípos</strong>
                            </div>
                            <div class="card-body text-center">
                                <a href="{{ route('info.ideas') }}">
                                    <img src="{{ asset('icons/ideas.png') }}" width="40%" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Tareas Albura</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ $baseUrl }}/tareas/public/login" target="_BLANK">
                                <img src="{{ asset('icons/tareas.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Reloj ingreso</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="http://192.168.1.84:6654/reloj-fabrica/login/" target="_BLANK">
                                <img src="{{ asset('icons/clock_fab.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
@endsection
