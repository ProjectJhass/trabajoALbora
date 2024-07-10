@extends('apps.nexus.plantilla.app')
@section('concepto.entrevista')
    active
@endsection
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row text-center">
                        <div class="col-md-6 mb-3" style="border: 1px solid; border-radius: 12px;">
                            <img src="{{ asset('img/BLANCO.png') }}" width="50%" alt="">
                        </div>
                        <div class="col-md-6 mb-3" style="border: 1px solid; border-radius: 12px;">
                            <h4><strong>Entrevista y evaluación para la selección de personal</strong></h4>
                        </div>
                        <div class="col-md-4" style="border: 1px solid; border-radius: 12px;">
                            <strong>CÓDIGO: RG-TH-03</strong>
                        </div>
                        <div class="col-md-4" style="border: 1px solid; border-radius: 12px;">
                            <strong>VERSIÓN: 08</strong>
                        </div>
                        <div class="col-md-4" style="border: 1px solid; border-radius: 12px;">
                            <strong>PÁGINA: 1</strong>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mt-3 mb-4">
                        <div class="col-md-6">
                            <label for="">Proceso que solicita el personal</label>
                            <input type="text" readonly value="" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="">Fecha de creación</label>
                            <input type="date" readonly value="" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3"><label for="">Cédula</label><input type="text" readonly value="" class="form-control"></div>
                        <div class="col-md-4 mb-3"><label for="">Nombre</label><input type="text" readonly value="" class="form-control"></div>
                        <div class="col-md-4 mb-3"><label for="">Apellidos</label><input type="text" readonly value="" class="form-control"></div>
                        <div class="col-md-4 mb-3"><label for="">Fecha de nacimiento</label><input type="text" readonly value="" class="form-control"></div>
                        <div class="col-md-4 mb-3"><label for="">Edad</label><input type="text" readonly value="" class="form-control"></div>
                        <div class="col-md-4 mb-3"><label for="">Ciudad</label><input type="text" readonly value="" class="form-control"></div>
                        <div class="col-md-4 mb-3"><label for="">Barrio</label><input type="text" readonly value="" class="form-control"></div>
                        <div class="col-md-4 mb-3"><label for="">Dirección</label><input type="text" readonly value="" class="form-control"></div>
                        <div class="col-md-4 mb-3"><label for="">Cargo al que aspira</label><input type="text" readonly value="" class="form-control"></div>
                        <div class="col-md-4 mb-3"><label for="">Tipo de vivienda</label><input type="text" readonly value="" class="form-control"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
@endsection
