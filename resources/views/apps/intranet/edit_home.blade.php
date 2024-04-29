@extends('apps.intranet.plantilla.app')
@section('title')
    Inicio
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('home')
    bg-danger active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Inicio</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            Carrucel
                        </div>
                        <div class="card-body">
                            <form id="formulario-img-carrucel" method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="form-group" hidden>
                                    <input type="text" value="img" name="img" id="img">
                                </div>
                                <div class="form-group">
                                    <label for="">Imagen</label>
                                    <input type="file" class="form-control" name="imagen_carrucel[]" id="imagen_carrucel" multiple>
                                </div>
                                <div class="form-group">
                                    <button type="button" onclick="CargarInformacionHome('formulario-img-carrucel')" class="btn btn-danger">Subir</button>
                                </div>
                            </form>
                            <hr>
                            <div class="row text-center">
                                <div class="col-md-3 mb-3">
                                    <p>Imagen</p>
                                </div>
                                <div class="col-md-3">
                                    <p>Nombre</p>
                                </div>
                                <div class="col-md-3">
                                    <p>Posicion</p>
                                </div>
                                <div class="col-md-3">
                                    <p>Accion</p>
                                </div>
                            </div>
                            @foreach ($imagenes as $item)
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <img src="{{ asset($item->url_imagen) }}" alt="" width="80%">
                                    </div>
                                    <div class="col-md-3">
                                        <p>{{ $item->nombre_imagen }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" value="{{ $item->orden }}" onchange="actualizarInformacion('{{ $item->id_carrucel }}',this.value)" class="form-control" name="posicionImg" id="posicionImg">
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-danger" onclick="EliminarInfoHome('c','{{ $item->id_carrucel }}')">Eliminar</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            Número de contacto
                        </div>
                        <div class="card-body">
                            <form id="form-numero-contact" method="post" autocomplete="off">
                                @csrf
                                <div class="form-group" hidden>
                                    <input type="text" value="cel" name="cel" id="cel">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Nombre</label>
                                            <input type="text" class="form-control" name="nombre_u" id="nombre_u">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Número</label>
                                            <input type="number" class="form-control" name="numero_cel" id="numero_cel">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" onclick="CargarInformacionHome('form-numero-contact')" class="btn btn-danger">Subir</button>
                                </div>
                            </form>
                            <hr>
                            <ul class="nav nav-pills flex-column">
                                @foreach ($numeros as $item)
                                    <li class="nav-item active">
                                        <div class="nav-link">
                                            <i class="fas fa-user"></i> {{ $item->nombre_propietario }}
                                            <span class="badge bg-danger float-right" onclick="EliminarInfoHome('n','{{ $item->id_numero }}')">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                            <span class="badge bg-primary float-right">
                                                <i class="fas fa-phone-alt"></i> {{ $item->numero_celular }}
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
@section('footer')
    <script>
        CargarInformacionHome = (form) => {
            var formulario = new FormData(document.getElementById(form));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: window.location.href + "/cargar",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                if (res.status == true) {
                    location.reload();
                }
            });
        }
        actualizarInformacion = (id, valor) => {
            var datos = $.ajax({
                url: window.location.href + "/actualizar",
                type: "post",
                dataType: "json",
                data: {
                    valor,
                    id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    window.location.reload();
                }
            });
        }
        EliminarInfoHome = (valor, id) => {
            var datos = $.ajax({
                url: window.location.href + "/eliminar",
                type: "post",
                dataType: "json",
                data: {
                    valor,
                    id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    window.location.reload();
                }
            });
        }
    </script>
@endsection
