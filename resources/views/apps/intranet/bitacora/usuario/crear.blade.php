@extends('apps.intranet.plantilla.app')
@section('title')
    Bitácora
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('bitacora')
    bg-danger active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Bitácora @if (Auth::user()->bitacora == '3')
                            <a href="{{ route('dev.admin.listar', ['estado' => 'progreso']) }}" type="button" class="btn btn-danger btn-sm">Administrador</a>
                        @else
                            @if (Auth::user()->bitacora == '2')
                                <a href="{{ route('dev.asignado.listar', ['estado' => 'progreso']) }}" type="button" class="btn btn-danger btn-sm">Proyectos
                                    asignados</a>
                            @endif
                        @endif
                    </h4>
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
            <div class="row bg-gradient-gray mb-4">
                <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-up"></i> 100%</span>
                        <h5 class="description-header">{{ $total }}</h5>
                        <span class="description-text">TOTAL DE PROYECTOS</span>
                    </div>
                </div>
                <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-up"></i>
                            {{ $total != 0 ? round(($pendientes * 100) / $total) : 0 }}%</span>
                        <h5 class="description-header">{{ $pendientes }}</h5>
                        <span class="description-text">PROYECTOS PENDIENTES</span>
                    </div>
                </div>
                <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-up"></i>
                            {{ $total != 0 ? round(($completados * 100) / $total) : 0 }}%</span>
                        <h5 class="description-header">{{ $completados }}</h5>
                        <span class="description-text">PROYECTOS COMPLETADOS</span>
                    </div>
                </div>
                <div class="col-sm-3 col-6">
                    <div class="description-block">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-up"></i>
                            {{ $total != 0 ? round(($atrasados * 100) / $total) : 0 }}%</span>
                        <h5 class="description-header">{{ $atrasados }}</h5>
                        <span class="description-text">PROYECTOS ATRASADOS</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <div class="card-header">
                            Proyectos
                        </div>
                        <div class="card-body">
                            <a href="{{ route('dev.bitacora', ['estado' => 'completada']) }}" type="button"
                                class="btn btn-sm btn-success btn-lg btn-block">Proyectos completados</a>
                            <a href="{{ route('dev.bitacora', ['estado' => 'progreso']) }}" type="button"
                                class="btn btn-sm btn-warning btn-lg btn-block">Proyectos en progreso</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('bitacora.crear') }}" type="button" class="btn btn-sm btn-danger btn-lg btn-block">Crear proyecto</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 mb-3">
                    <div class="card card-outline card-secondary">
                        <div class="card-body">
                            <table class="table table-striped projects">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Proyecto</th>
                                        <th>Prioridad</th>
                                        <th>Equipo</th>
                                        <th>Progreso</th>
                                        <th class="text-center">Estado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solicitudes as $item)
                                        <tr>
                                            <td>{{ $item->id_solicitud }}</td>
                                            <td>
                                                {{ $item->nombre_solicitud }} <br><small>creada
                                                    {{ str_replace('-', '.', $item->fecha_creacion) }}</small>
                                            </td>
                                            <td>{{ $item->prioridad }}</td>
                                            <td class="text-center">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        <img alt="Avatar" class="table-avatar" src="{{ asset('storage/icons/usuario.png') }}">
                                                    </li>
                                                </ul>
                                            </td>
                                            <td class="project_progress">
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{ $item->porcentaje }}"
                                                        aria-valuemin="0" aria-valuemax="100" style="width: {{ $item->porcentaje }}%">
                                                    </div>
                                                </div>
                                                <small>
                                                    {{ $item->porcentaje }}% Completado
                                                </small>
                                            </td>
                                            <td class="project-state">
                                                <span class="badge badge-{{ $item->color }}">{{ $item->estado }}</span>
                                            </td>
                                            <td class="project-actions text-right">
                                                <a class="btn btn-primary btn-sm"
                                                    href="{{ route('dev.details.bitacora', ['idSolicitud' => $item->id_solicitud]) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script></script>
@endsection
