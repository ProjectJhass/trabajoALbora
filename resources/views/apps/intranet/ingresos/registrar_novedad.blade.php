@extends('apps.intranet.plantilla.app')
@section('title')
    Ingresos y Salidas
@endsection
@section('head')
    <style>
        .select2.select2-container .select2-selection {
            border: 1px solid #ccc;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            height: 38px;
            margin-bottom: 15px;
            outline: none !important;
            transition: all .15s ease-in-out;
        }

        .select2.select2-container .select2-selection .select2-selection__arrow {
            background: #f8f8f8;
            border-left: 1px solid #ccc;
            -webkit-border-radius: 0 3px 3px 0;
            -moz-border-radius: 0 3px 3px 0;
            border-radius: 0 3px 3px 0;
            height: 32px;
            width: 33px;
        }
    </style>
@endsection
@section('menu-ingresos')
    menu-open
@endsection
@section('section-menu')
    bg-danger active
@endsection
@section('registrar_n')
    bg-secondary active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Registrar novedades</h4>
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
            <form id="formulario-registro-nueva-novedad" class="was-validated">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-outline card-secondary">
                            <div class="card-header">
                                Información general
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Empleado</label>
                                    <select class="form-control select2" onchange="ObtenerSucursal(this.value)" name="empleado" id="empleado" style="width: 100%;" data-placeholder="Seleccionar el asesor">
                                        <option value=""></option>
                                        @foreach ($asesores as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Sucursal</label>
                                    <input type="text" name="sucursal" id="sucursal" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="">Fecha de la novedad</label>
                                    <input type="date" name="fecha" id="fecha" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-outline card-secondary">
                            <div class="card-header">
                                Observaciones
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="novedad-general">Novedad</label>
                                    <select class="form-control" name="novedad_general" id="novedad_general" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="CITA MEDICA">CITA MEDICA</option>
                                        <option value="PERMISO PERSONAL">PERMISO PERSONAL</option>
                                        <option value="LLEGADA TARDE">LLEGADA TARDE</option>
                                        <option value="TRABAJO EXTERNO">TRABAJO EXTERNO</option>
                                        <option value="URGENCIAS">URGENCIAS</option>
                                        <option value="NO REGISTRA INGRESO">NO REGISTRA INGRESO</option>
                                        <option value="OTRO">OTRO</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Comentarios</label>
                                    <textarea name="comentario" id="comentario" class="form-control" cols="30" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="button" onclick="RegistrarNovedadesUsuario('formulario-registro-nueva-novedad')" class="btn btn-danger">Registrar novedad</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('footer')
    <script src="{{ asset('js/registrar_novedad.js') }}"></script>
    <script>
        $(() => {
            $('.select2').select2()
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endsection
