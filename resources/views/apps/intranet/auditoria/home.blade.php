@extends('apps.intranet.plantilla.app')
@section('title')
    Auditoría
@endsection
@section('auditoria')
    bg-danger active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Auditoría</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Auditoría</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @if (session('error'))
        <div class="col-12 d-flex justify-content-center" id="hola" style="display: block;">
            <div class="alert alert-danger col-5 text-center" id="errorAlert">
                {{ session('error') }}
            </div>
        </div>
        <script>
            setTimeout(function() {
                $("#errorAlert").fadeOut("slow", function() {
                    $("#hola").hide();
                });
            }, 1000);
        </script>
    @endif

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Carpeta temporal</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.docs.tmp', ['dpto' => 'auditoria']) }}">
                                <img src="{{ asset('storage/icons/temporal.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Memorandos</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('intranet.memorandos.areas', ['seccion' => 'auditoria', 'memo' => 'memorandos-auditoria']) }}">
                                <img src="{{ asset('storage/icons/book.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <strong>Evaluaciòn</strong>
                        </div>
                        <div class="card-body text-center">
                            <a href="#" class="" data-toggle="modal" data-target="#exampleModal">
                                <img src="{{ asset('storage/icons/opinion.png') }}" width="40%" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ingreso De Evaluación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times-circle" style="color: #c82333;"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center m-2">
                        <h5>Ingrese Su Codigo Para Ingresar</h5>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <div class="row col-8">
                            <form>
                                <div class="d-flex flex-row text-center d-flex justify-content-evenly">
                                    <input type="text" class="caracter form-control col-2 text-center" id="digito1" name="digito" maxlength="1"
                                        oninput="limitarInput(this, 2)" placeholder="-">
                                    <input type="text" class="caracter form-control col-2 text-center" id="digito2" name="digito" maxlength="1"
                                        oninput="limitarInput(this, 3)" placeholder="-">
                                    <input type="text" class="caracter form-control col-2 text-center" id="digito3" name="digito" maxlength="1"
                                        oninput="limitarInput(this, 4)" placeholder="-">
                                    <input type="text" class="caracter form-control col-2 text-center" id="digito4" name="digito" maxlength="1"
                                        oninput="limitarInput(this)" placeholder="-">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <form action="{{ route('paginas.evaluacion') }}" method="GET">
                        <input type="text" id="id" name="id" value="6" hidden>
                        <input type="text" id="codigos" name="codigos" hidden>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-walking"></i> Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('js/evaluaciones_regionales.js') }}"></script>
@endsection
