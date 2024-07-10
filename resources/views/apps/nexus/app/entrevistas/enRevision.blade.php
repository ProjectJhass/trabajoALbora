@extends('apps.nexus.plantilla.app')
@section('concepto.entrevista')
    active
@endsection
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Entrevistas en revisión</h5>
                </div>
                <div class="card-body">
                    {!! $table !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
@endsection
