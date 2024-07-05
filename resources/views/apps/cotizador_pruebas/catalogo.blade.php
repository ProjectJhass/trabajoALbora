@extends('apps.cotizador_pruebas.plantilla.app')
@section('title')
    Catálogo
@endsection
@section('body')
    <div class="card">
        <div class="card-body">
            <h4>Catálogo de productos</h4>
            <div class="row mt-4">
                <div class="col-5 col-sm-3">
                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home" aria-selected="true">COMEDORES</a>
                        <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile" aria-selected="false">SALAS</a>
                        <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#vert-tabs-messages" role="tab" aria-controls="vert-tabs-messages" aria-selected="false">ALCOBAS</a>
                    </div>
                </div>
                <div class="col-7 col-sm-9">
                    <div class="tab-content" id="vert-tabs-tabContent">
                        <div class="tab-pane text-left fade show active" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                            <a href="{{ asset('storage/catalogo/COMEDORES.pdf') }}" target="_BLANK"><i class="fas fa-expand"></i></a>
                            <embed src="{{ asset('storage/catalogo/COMEDORES.pdf') }}" type="application/pdf" width="100%" height="900px" />
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                            <a href="{{ asset('storage/catalogo/SALAS.pdf') }}" target="_BLANK"><i class="fas fa-expand"></i></a>
                            <embed src="{{ asset('storage/catalogo/SALAS.pdf') }}" type="application/pdf" width="100%" height="900px" />
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel" aria-labelledby="vert-tabs-messages-tab">
                            <a href="{{ asset('storage/catalogo/ALCOBAS.pdf') }}" target="_BLANK"><i class="fas fa-expand"></i></a>
                            <embed src="{{ asset('storage/catalogo/ALCOBAS.pdf') }}" type="application/pdf" width="100%" height="900px" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
