@extends('apps.control_madera.plantilla.app')
@section('head')
    <style>
        .ui-pnotify-fade-normal {
            top: 36px !important;
        }
    </style>
@endsection
@section('p.corte.terminado')
    active
@endsection
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="card alert-top" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header">
                    <h5>Corte de tabla</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="background-color: #f5f5f5"><strong>Cantidad</strong></span>
                                        <input type="text" value="{{ $info->cantidad }}" readonly class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="background-color: #f5f5f5"><strong>Pulgadas solicitadas</strong></span>
                                        <input type="text" value="{{ $info->pulgadas_solicitadas }}" readonly class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="background-color: #f5f5f5"><strong>Planificador</strong></span>
                                        <input type="text" value="{{ $info->planificador }}" readonly class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="background-color: #f5f5f5"><strong>Fecha creación</strong></span>
                                        <input type="text" value="{{ $info->created_at }}" readonly class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="background-color: #f5f5f5"><strong>Cantidad cortada</strong></span>
                                        <input type="text" value="{{ $info->cantidad_cortada }}" readonly class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="background-color: #f5f5f5"><strong>Pulgadas cortadas</strong></span>
                                        <input type="text" value="{{ $info->pulgadas_cortadas }}" readonly class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="background-color: #f5f5f5"><strong>Bloques utilizados</strong></span>
                                        <input type="text" value="{{ $info->bloques_utilizados }}" readonly class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="background-color: #f5f5f5"><strong>Cortador</strong></span>
                                        <input type="text" value="{{ $info->cortador }}" readonly class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="background-color: #f5f5f5"><strong>Fecha de corte</strong></span>
                                        <input type="text" value="{{ $info->updated_at }}" readonly class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
