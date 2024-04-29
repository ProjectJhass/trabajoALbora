@extends('apps.intranet.plantilla.app')
@section('title')
    Logística
@endsection
@section('logistica')
    bg-danger active
@endsection
@section('body')
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

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Promociones</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.log.memos', ['memo'=>'logistica-promociones']) }}">
                                <img src="{{ asset('storage/icons/discount.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Momorandos fábrica</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.log.memos', ['memo'=>'logistica-memorandos-fabrica']) }}">
                                <img src="{{ asset('storage/icons/trabajador.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Lista de precios</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.log.memos', ['memo'=>'lista-de-precios']) }}">
                                <img src="{{ asset('storage/icons/precio.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Empaque y arrume</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.log.memos', ['memo'=>'empaque-y-arrume']) }}">
                                <img src="{{ asset('storage/icons/boxes.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Instructivos de logística</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.log.memos', ['memo'=>'instructivos-de-logistica']) }}">
                                <img src="{{ asset('storage/icons/mandatory.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Tarifas de envíos</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.log.memos', ['memo'=>'tarifas-de-envios']) }}">
                                <img src="{{ asset('storage/icons/transportadora.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script src="{{ asset('js/logistica.js') }}"></script>
@endsection
