@extends('apps.control_madera.plantilla.app')
@section('body')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h2>Crear nueva serie</h2>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="page-body mt-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    Cantidad procesados
                                </div>
                                <div class="card-body text-center">
                                    <h1 id="cantidad_impresiones_correctas">0</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    Cantidad fallidos
                                </div>
                                <div class="card-body text-center">
                                    <h1 id="cantidad_impresiones_fallidas">0</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Estructura código QR
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')

@endsection
