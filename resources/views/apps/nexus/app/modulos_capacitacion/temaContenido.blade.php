@extends('apps.nexus.plantilla.app')
@section('modulos')
    active
@endsection
@section('head')
    <style>
        .list-group-item {
            cursor: pointer;
        }

        .list-group-item:hover {
            color: red
        }
    </style>
@endsection
@section('body')
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <img src="{{ asset('img/imgheader.jpg') }}" width="100%" alt="">
                <div class="card-header">
                    <h4 class="text-center">{{ $item->nombre_tema }}</h4>
                    <p class="mt-3">{{ $item->objetivo }}</p>
                    @php
                        $users_ = $item->infoEncargadoTema->first();
                        $nombre_ = $users_ != '' ? $users_->nombre . ' ' . $users_->apellidos : 'No hay encargado para este tema de capacitación';
                    @endphp
                    <p class="mt-3"><strong>Encargado(a):</strong> {{ $nombre_ }}</p>
                </div>
                <div class="card-body">
                    {!! $tema !!}
                </div>
                <div class="card-footer">
                    <h5>Evaluaciones</h5>
                    {!! $evaluaciones !!}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center">Configuración</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Editar nombre</li>
                        <li class="list-group-item">Editar encargado</li>
                        <li class="list-group-item">Editar objetivo</li>
                        <li class="list-group-item">Editar documento</li>
                        <li class="list-group-item">Crear evaluación</li>
                        <li class="list-group-item">Matricular masivamente</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
