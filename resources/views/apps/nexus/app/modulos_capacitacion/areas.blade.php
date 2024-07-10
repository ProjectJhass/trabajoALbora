@extends('apps.nexus.plantilla.app')
@section('modulos')
    active
@endsection
@section('head')
    <style>
        .card {
            flex: 1 1 auto;
        }
    </style>
@endsection
@section('body')
    <div class="row mt-5 mb-5">
        <div class="col-md-12">
            <div class="flex-wrap d-flex justify-content-between align-items-center">
                <div class="text-white">
                    <h3 class="text-white">Áreas de la empresa</h3>
                </div>
            </div>
        </div>
    </div>
    {!! $info !!}
@endsection
