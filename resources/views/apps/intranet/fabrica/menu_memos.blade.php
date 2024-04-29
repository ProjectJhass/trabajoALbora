@extends('apps.intranet.plantilla.app')
@section('title')
    Fábrica
@endsection
@section('fabrica')
    bg-danger active
@endsection
@section('body')
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
                            <strong>Empaque y arrume</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'fabrica', 'memo' => 'memorandos-empaque-y-arrume']) }}">
                                <img src="{{ asset('icons/memo_fab1.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Productos nuevos</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'fabrica', 'memo' => 'memorandos-productos-nuevos']) }}">
                                <img src="{{ asset('icons/memo_fab2.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Cambio de versión</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'fabrica', 'memo' => 'memorandos-cambio-de-version']) }}">
                                <img src="{{ asset('icons/memo_fab3.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Memorandos de telas</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'fabrica', 'memo' => 'memorandos-de-telas']) }}">
                                <img src="{{ asset('icons/memo_telas.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Otros</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'fabrica', 'memo' => 'otros-memorandos-fabrica']) }}">
                                <img src="{{ asset('icons/memo_otros.png') }}" width="40%" alt="">
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
