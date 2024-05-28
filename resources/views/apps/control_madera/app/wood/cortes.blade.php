@extends('apps.control_madera.plantilla.app')
@section('wood')
    active
@endsection
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="card" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header">
                    <h4>Cortes planificados Woodmiser</h4>
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
