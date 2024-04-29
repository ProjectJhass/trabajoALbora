@extends('apps.intranet.plantilla.app')
@section('title')
    Reglamento Interno de Trabajo
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('storage/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('storage/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('rrhh')
    bg-danger active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Reglamento Interno de Trabajo</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Reglamento</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @php
        $validar_r = false;
    @endphp
    @if (Auth::user()->dpto_user == '4' || Auth::user()->id == '6401505')
        @php
            $validar_r = true;
        @endphp
    @endif

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-<?php echo $validar_r==true ? '6' : '12'; ?> mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            Autenticarse
                        </div>
                        <div class="card-body">
                            <form id="informacion-cedula-reglamento" method="post">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Número de cédula</span>
                                        </div>
                                        <input type="text" class="form-control" name="cedula_empleado" id="cedula_empleado"
                                            placeholder="Número de cédula" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger"
                                    onclick="ValidarExistenciaCedulaReglamento('informacion-cedula-reglamento')">Consultar información</button>
                            </form>
                        </div>
                    </div>
                </div>
                @if ($validar_r)
                    <div class="col-md-6 mb-3">
                        <div class="card card-outline card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Visualizaciones</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table" id="informacion-general-reglamento">
                                    <thead>
                                        <tr>
                                            <th>Usuarios</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($documentos as $item)
                                            <tr>
                                                <td>
                                                    <ul class="nav nav-pills flex-column">
                                                        <li class="nav-item active">
                                                            <a href="{{ asset('storage/RRHH/fotos_reglamento/' . $item->update_foto) }}" target="_BLANK"
                                                                class="nav-link">
                                                                <i class="far fa-file-alt"></i> {{ $item->nombre }}
                                                                <span class="badge bg-success float-right">{{ $item->fecha }}</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>



        <div class="modal fade" id="tomar-fotografia-reglamento">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tomar fotografía</h4>
                        <button type="button" class="close" data-dismiss="modal" onclick="location.reload()" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <label for="">Dispositivo</label>
                                <select name="listaDeDispositivos" id="listaDeDispositivos" class="form-control"></select>
                            </div>
                            <div class="card-body text-center">
                                <video muted="muted" id="video" style="width: 70%;"></video>
                                <canvas id="canvas" style="display: none;"></canvas>
                            </div>
                            <div class="card-footer text-center">
                                <button type="button" id="boton" class="btn btn-danger">Consultar información</button>
                                <p id="estado"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-visualizacion-reglamento-interno-trabajo">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Reglamento interno de trabajo</h4>
                        <button type="button" class="close" data-dismiss="modal" onclick="location.reload()" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="documento-encontrado-reglamento"></div>
                    </div>
                    <div class="modal-footer left-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar información</button>
                    </div>
                </div>
            </div>
        </div>


    </section>
@endsection
@section('footer')
    <script src="{{ asset('storage/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('storage/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('storage/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('storage/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/reglamento_interno.js') }}"></script>
@endsection
