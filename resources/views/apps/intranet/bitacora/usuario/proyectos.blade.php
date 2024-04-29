@extends('apps.intranet.plantilla.app')
@section('title')
    Bitácora
@endsection
@section('head')
@endsection
@section('bitacora')
    bg-danger active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Detalle del proyecto</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Bitácora</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-secondary">
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                            <div class="row">
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Fecha creación</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $proyecto[0]->fecha_creacion }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Fecha posible entrega</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $proyecto[0]->fecha_posible_entrega }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Número de participantes</span>
                                            <span class="info-box-number text-center text-muted mb-0">1</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Puntos a desarrollar</h4>
                                    <hr>
                                    <div id="accordion">
                                        @foreach ($puntos as $item)
                                            <div class="card card-light">
                                                <div class="card-header">
                                                    <h4 class="card-title">
                                                        <a class="text-gray" data-toggle="collapse" href="#collapse{{ $item['id_punto'] }}">
                                                            {{ $item['punto'] }}
                                                        </a>
                                                    </h4>
                                                    <div class="card-tools">
                                                        <span class="badge badge-warning">Prioridad: {{ $item['prioridad'] }}</span>
                                                        <span class="badge badge-light">Avance: {{ $item['porcentaje'] }} %</span>
                                                        <span class="badge badge-{{ $item['color'] }}">Estado: {{ $item['estado'] }}</span>
                                                    </div>
                                                </div>
                                                <div id="collapse{{ $item['id_punto'] }}" class="collapse" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h5>Seguimiento</h5>
                                                                <hr>
                                                                @foreach ($item['seguimiento'] as $seg)
                                                                    <div class="post clearfix">
                                                                        <div class="user-block">
                                                                            <img class="img-circle img-bordered-sm" src="{{ asset('icons/usuario.png') }}" alt="User Image">
                                                                            <span class="username">
                                                                                <div class="text-blue">{{ $seg['responsable'] }}</div>
                                                                            </span>
                                                                            <span class="description">{{ date('Y-m-d', strtotime($seg['fecha'])) }}</span>
                                                                        </div>
                                                                        <p>{{ $seg['seguimiento'] }}</p>
                                                                        <p>
                                                                            @foreach ($seg['docs'] as $doc)
                                                                                <a href="{{ asset($doc->url_doc_p) }}" target="_BLANK" class="link-black text-sm mr-3"><i
                                                                                        class="fas fa-link mr-1"></i>{{ $doc->nom_doc_p }}</a>
                                                                            @endforeach
                                                                        </p>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <h4>Seguimiento general</h4>
                                    <hr>
                                    @foreach ($seguimiento as $seg)
                                        <div class="post clearfix">
                                            <div class="user-block">
                                                <img class="img-circle img-bordered-sm" src="{{ asset('icons/usuario.png') }}" alt="user image">
                                                <span class="username">
                                                    <div class="text-blue">{{ $seg['responsable'] }}</div>
                                                </span>
                                                <span class="description">{{ $seg['fecha'] }}</span>
                                            </div>
                                            <p>{{ $seg['seguimiento'] }}</p>
                                            <p>
                                                @foreach ($seg['documentos'] as $doc)
                                                    <a href="{{ asset($doc->url_doc_seg) }}" target="_BLANK" class="link-black text-sm mr-3"><i class="fas fa-link mr-1"></i>{{ $doc->nom_doc_seg }}</a>
                                                @endforeach
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                            <h3 class="text-primary"><i class="fas fa-project-diagram"></i> {{ $proyecto[0]->nombre_solicitud }}</h3>
                            <p class="text-muted">{{ $proyecto[0]->descripcion }}</p>
                            <br>
                            <div class="text-muted">
                                <p class="text-sm">Tipo de solicitud
                                    <b class="d-block">{{ $proyecto[0]->tipo_solicitud }}</b>
                                </p>
                                <p class="text-sm">Responsable de la solicitud
                                    <b class="d-block">{{ $proyecto[0]->nombre_solicitante }}</b>
                                </p>
                                <p class="text-sm">Estado
                                    <b class="d-block">{{ $proyecto[0]->estado }}</b>
                                </p>
                                <p class="text-sm">Prioridad
                                    <b class="d-block">{{ $proyecto[0]->prioridad }}</b>
                                </p>
                            </div>

                            <h5 class="mt-5 text-muted">Documentos adjuntos</h5>
                            <ul class="list-unstyled">
                                @foreach ($documentos as $doc)
                                    <li>
                                        <a href="{{ asset($doc->url_doc) }}" target="_BLANK" class="btn-link text-secondary"><i class="fas fa-link mr-1"></i> {{ $doc->nombre_documento }}.{{ $doc->tipo_doc }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
