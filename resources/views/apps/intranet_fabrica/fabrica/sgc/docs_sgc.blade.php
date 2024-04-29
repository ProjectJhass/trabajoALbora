@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    SGC
@endsection
@section('menu-calidad')
    menu-open
@endsection
@section('active-calidad')
    bg-danger active
@endsection
@section('active-sub-sgc')
    active
@endsection
@section('fabrica-body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Documentación SGC</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home.intranet.fabrica') }}">Fábrica</a></li>
                        <li class="breadcrumb-item active">Documentación SGC</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    Documentación SGC
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route('docs.sgc.niv1', ['seccion' => '1']) }}">
                                        <img src="{{ asset('icons/sistema-de-gestion-de-contenidos.png') }}" alt="" width="70px">
                                        Revisión por la dirección y gestión de calidad
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route('docs.sgc.niv1', ['seccion' => '2']) }}">
                                        <img src="{{ asset('icons/produccion.png') }}" alt="" width="70px">
                                        Producción
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route('docs.sgc.niv1', ['seccion' => '3']) }}">
                                        <img src="{{ asset('icons/talento.png') }}" alt="" width="70px">
                                        Talento humano
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route('docs.sgc.niv1', ['seccion' => '4']) }}">
                                        <img src="{{ asset('icons/almacenamiento.png') }}" alt="" width="70px">
                                        Compras y almacenamiento
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route('docs.sgc.niv1', ['seccion' => '5']) }}">
                                        <img src="{{ asset('icons/mantenimiento.png') }}" alt="" width="70px">
                                        Mantenimiento y metrología
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
@endsection
