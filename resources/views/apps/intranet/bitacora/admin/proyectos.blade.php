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
                    <h4>Crear proyecto</h4>
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
                                        {{ $item->nombre_solicitud }} <br><small>creada {{ str_replace('-', '.', $item->fecha_creacion) }}</small>
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
                                        <a class="btn btn-primary btn-sm" href="{{ route('dev.admin.ver', ['idSolicitud' => $item->id_solicitud]) }}">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
@endsection
