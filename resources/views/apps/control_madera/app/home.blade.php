@extends('apps.control_madera.plantilla.app')
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="flex-wrap d-flex justify-content-between align-items-center">
                <div class="text-white">
                    <h3 class="text-white">Bienvenido(a) {{ Auth::user()->nombre }}</h3>
                    <p class="mt-4">¡Bienvenido a nuestra plataforma de control de madera! Estamos encantados de tenerte con nosotros. Aquí podrás gestionar de manera eficiente todos los aspectos relacionados con el manejo y control de la madera, asegurando una administración precisa y sostenible. ¡Comencemos a optimizar tus procesos!.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center" style="margin-top: 10rem">
        <div class="col-md-4">
            <div data-aos="fade-up" data-aos-delay="300">
                <img src="{{ asset('img/blanco.png') }}" width="100%" alt="">
            </div>
        </div>
    </div>
@endsection
