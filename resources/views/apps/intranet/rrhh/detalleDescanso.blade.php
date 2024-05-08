@extends('apps.intranet.plantilla.app')
@section('title')
    Recursos humanos
@endsection
@section('rrhh')
    bg-danger active
@endsection
@section('head')
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Detalle de la firma</h4>
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

            <div class="card card-outline card-danger">
                <div class="card-header text-center">
                    <h5>Firma digital del documento: {{ $info->nombre }}</h5>
                    <p>Fecha de la firma: {{ $info->created_at }}</p>
                    <p>IP: {{ $info->ip }}</p>
                    <p>Sesión: {{ $info->hash_firma }}</p>
                    <div class="text-center">
                        <a href="{{ asset($info->url_firma) }}" target="_BLANK"><img src="{{ asset($info->url_firma) }}" width="10%" alt=""></a>
                    </div>
                </div>
                <div class="card-body mb-5">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="">Cédula</label>
                            <input type="text" class="form-control" value="{{ $info->cedula }}" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Nombre</label>
                            <input type="text" class="form-control" value="{{ $info->nombre }}" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Departamento</label>
                            <input type="text" class="form-control" value="{{ $info->depto }}" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Ciudad</label>
                            <input type="text" class="form-control" value="{{ $info->ciudad }}" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Almacen</label>
                            <input type="text" class="form-control" value="{{ $info->almacen }}" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Dominical</label>
                            <input type="date" readonly class="form-control" value="{{ $info->dominical_laborado }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Descanso compensatorio</label>
                            <input type="date" readonly class="form-control" value="{{ $info->dia_compensatorio }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Fecha creación</label>
                            <input type="text" readonly class="form-control" value="{{ $info->created_at }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">última actualización</label>
                            <input type="text" readonly class="form-control" value="{{ $info->updated_at }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="">Observaciones empleado</label>
                            <textarea class="form-control" readonly cols="30" rows="2">{{ $info->observaciones }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
@endsection
