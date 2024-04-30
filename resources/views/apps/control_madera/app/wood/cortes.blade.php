@extends('apps.control_madera.plantilla.app')
@section('body')
    <div class="">
        <div class="clearfix"></div>
        <div class="page-title">
            <div class="title_left">
                <h4>Cortes planificados Woodmiser</h4>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <div>
                <div class="x_title">
                    <h2></h2>
                    <div class="clearfix"></div>
                </div>
                <div id="info-general-cortes-wood">
                    {!! $cortes !!}
                </div>
            </div>
        </div>
    </div>
@endsection
