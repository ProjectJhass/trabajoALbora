@extends('apps.intranet.plantilla.app')
@section('title')
    Ingresos y Salidas
@endsection
@section('menu-ingresos')
    menu-open
@endsection
@section('section-menu')
    bg-danger active
@endsection
@section('exportar')
    bg-secondary active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Descargar informacón</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Ingresos y salidas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            Descargar Información
                        </div>
                        <div class="card-body">
                            <form method="POST" class="was-validated">
                                @csrf
                                <div class="form-group">
                                    <label for="">Fecha inicio</label>
                                    <input type="date" class="form-control" name="fecha_i" id="fecha_i" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Fecha final</label>
                                    <input type="date" class="form-control" name="fecha_f" id="fecha_f" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="dominicales" class="btn btn-success"><i class="fas fa-file-excel"></i> Dominicales</button>
                                    <button type="submit" name="novedades" class="btn btn-success"><i class="fas fa-file-excel"></i> Novedades</button>
                                    <button type="submit" name="ingresos" class="btn btn-success"><i class="fas fa-file-excel"></i> Ingresos</button>
                                    <button type="submit" name="ingresosNovedades" class="btn btn-success"><i class="fas fa-file-excel"></i> Ingresos Y Novedades</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
@endsection
