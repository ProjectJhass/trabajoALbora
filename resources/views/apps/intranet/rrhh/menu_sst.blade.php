@extends('apps.intranet.plantilla.app')
@section('title')
    Recursos humanos
@endsection
@section('rrhh')
    bg-danger active
@endsection
@section('body')
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

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Presentaciones SST</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'rrhh', 'memo' => 'presentaciones-sst']) }}">
                                <img src=" {{ asset('icons/presentacion.png') }} " width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Documentación SST</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'rrhh', 'memo' => 'documentacion-sst']) }}">
                                <img src=" {{ asset('icons/seguridad.png') }} " width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>PESV</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'rrhh', 'memo' => 'pesv']) }}">
                                <img src=" {{ asset('icons/choque.png') }} " width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Politicas SST</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'rrhh', 'memo' => 'politicas-sst']) }}">
                                <img src=" {{ asset('icons/reglamento.png') }} " width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Memorandos SST</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'rrhh', 'memo' => 'memorandos-sst']) }}">
                                <img src=" {{ asset('icons/memorando.png') }} " width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Brigada de emergencia</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'rrhh', 'memo' => 'brigada-de-emergencia']) }}">
                                <img src=" {{ asset('icons/bomberos.png') }} " width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>COPASST</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'rrhh', 'memo' => 'copasst']) }}">
                                <img src=" {{ asset('icons/sst_2.png') }} " width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>COCOLAB</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'rrhh', 'memo' => 'cocolab']) }}">
                                <img src=" {{ asset('icons/sst_2.png') }} " width="40%" alt="">
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
