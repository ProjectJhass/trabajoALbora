@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    SOLICITUDES_DE_MANTENIMIENTO_MAQUINA_{{ $referencia }}
@endsection
@section('tables-bootstrap-css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hojas_de_vida.css') }}">
@endsection
@section('fabrica-body')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <div class="row text-center">
                        <div class="col-md-6 mb-3" style="border: 1px solid; border-radius: 12px;">
                            <img src="{{ asset('img/BLANCO.png') }}" width="50%" alt="">
                        </div>
                        <div class="col-md-6 mb-3" style="border: 1px solid; border-radius: 12px;">
                            <h5><strong>HOJAS DE VIDA <br> MÁQUINAS-EQUIPOS-HERRAMIENTAS</strong></h5>
                        </div>
                        <div class="col-md-4" style="border: 1px solid; border-radius: 12px;">
                            <strong>CÓDIGO: RG-MTO-05</strong>
                        </div>
                        <div class="col-md-4" style="border: 1px solid; border-radius: 12px;">
                            <strong>VERSIÓN: 04</strong>
                        </div>
                        <div class="col-md-4" style="border: 1px solid; border-radius: 12px;">
                            <strong>PÁGINA: 1</strong>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="card-body">
                    @php
                        $info_g = $historialMaquina->first();
                        $maq =
                            strpos($info_g->maquina ?? '', '-') !== false
                                ? explode('-', $info_g->maquina ?? '')
                                : $info_g->maquina ?? '';
                        $maquina_ = is_array($maq) ? trim($maq[0]) . '-' . trim($maq[1]) : $maq ?? '';
                        // $maquina_ = strpos($maquina_ ?? '', 'MAQ') !== false ? str_replace('MAQ', "MAQUINA", $maquina_) : $info_g->maquina ?? '';
                    @endphp
                    <section class="content">
                        <div class="card card-outline card-danger">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <!-- Título centrado -->
                                <div class="d-flex justify-content-center w-100">
                                    <h3 class="card-title"><strong>Maquina: {{ $maquina_ }}</strong></h3>
                                </div>
                                <!-- Contenedor de "Copia Controlada" -->
                                <div class="card-tools">
                                    <div style="padding: 5px; color: black; font-weight: bold; text-align: center;">
                                        Copia Controlada <br> S.G.C
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="display: block;">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="row">
                                            <div class="col-12" id="procedimientos_realizdos">
                                                @foreach ($historialMaquina as $historial)
                                                    <div class="post">
                                                        <div class="user-block">
                                                            <img class="img-circle img-bordered-sm"
                                                                src="{{ asset('img/mantenimiento.png') }}" alt="user image">
                                                            <span class="username">
                                                                <div><b>Descripción del requerimiento: </b> <b class="text-primary">{{ $historial->solicitud }}</b></div>
                                                            </span>
                                                            <span class="description">
                                                                <b>Responsable: </b>{{ $historial->responsable_s }} <br>
                                                                <b>Fecha: </b>{{ $historial->fecha_solicitud }}
                                                            </span>
                                                        </div>
                                                        <div class="pl-5">
                                                            <p style="margin-bottom: 0">
                                                                <b>Solución</b> <br>
                                                                {{ $historial->respuesta_solicitud }}
                                                            </p>
                                                            <span class="description mt-3" style="font-size: 13px;">
                                                                Responsable: {{ $historial->responsable_respuesta }} <br>
                                                                Fecha: {{ $historial->fecha_respuesta }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection
