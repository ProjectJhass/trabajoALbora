@extends('apps.nexus.plantilla.app')
@section('modulos')
    active
@endsection
@section('head')
    {{-- <link rel="stylesheet" href="{{ asset('css/all.css') }}"> --}}
@endsection
@section('body')
    {{-- <img src="{{ asset('img/fondoRojo.jpg') }}" width="100%" style="border-radius: 10px" alt=""> --}}
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="flex-wrap d-flex justify-content-between align-items-center">
                <div class="text-white">
                    <h3 class="text-white">Temas de capacitación</h3>
                    <p class="mt-3">Aquí encontrarás los diferentes temas de capacitación, para afianzar tu conocimiento</p>
                </div>
                <div>
                    <a href="#" class="btn btn-gray rounded-pill ">
                        <i class="fas fa-plus"></i>
                        Crear tema de capacitación
                    </a>
                </div>
            </div>
        </div>
    </div>

    {!! $info !!}
@endsection
