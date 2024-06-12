@extends('apps.control_madera.plantilla.app')
@section('wood')
    active
@endsection
@section('body')
    <div class="row">
        <div class="col-md-12" id="infoCorteTablasPendientes">
            {!! $tablas !!}
        </div>
        <div class="col-md-12">
            <div class="card alert-top" data-aos="fade-up" data-aos-delay="250">
                <div class="card-header">
                    <h5>Cortes planificados Woodmiser</h5>
                </div>
                <div class="card-body">
                    <div id="info-general-cortes-wood">
                        {!! $cortes !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
