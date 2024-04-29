@extends('apps.intranet.plantilla.app')
@section('title')
    Bitácora
@endsection
@section('head')
@endsection
@section('bitacora')
    bg-danger active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Detalle del proyecto</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Bitácora</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-secondary">
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Fecha creación</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $proyecto[0]->fecha_creacion }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Fecha posible entrega</span>
                                            <span class="info-box-number text-center text-muted mb-0"><input type="date" class="form-control" value="{{ $proyecto[0]->fecha_posible_entrega }}" name="fecha_entrega"
                                                    id="fecha_entrega"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Puntos a desarrollar</h4>
                                    <hr>
                                    <form id="form-punto-desarrollar" method="post">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" name="titulo_punto" id="titulo_punto" class="form-control" placeholder="Titulo">
                                            <input type="text" name="desciption_punto" id="desciption_punto" class="form-control" placeholder="Descripción">
                                            <input type="text" name="prioridad_punto" id="prioridad_punto" class="form-control" placeholder="Prioridad">
                                            <button type="button" onclick="AgregarPuntoDesarrollar('form-punto-desarrollar','agregar-puntos')" class="btn btn-secondary">Agregar</button>
                                        </div>
                                    </form>
                                    <hr>

                                    <div id="accordion">

                                        @foreach ($puntos as $item)
                                            <div class="card card-light">
                                                <div class="card-header">
                                                    <h4 class="card-title">
                                                        <a class="text-gray" data-toggle="collapse" href="#collapse{{ $item['id_punto'] }}">
                                                            {{ $item['punto'] }}
                                                        </a>
                                                    </h4>
                                                    <div class="card-tools">
                                                        <span class="badge badge-warning">Prioridad: {{ $item['prioridad'] }}</span>
                                                        <span class="badge badge-light">Avance: {{ $item['porcentaje'] }} %</span>
                                                        <span class="badge badge-{{ $item['color'] }}">{{ $item['estado'] }}</span>
                                                    </div>
                                                </div>
                                                <div id="collapse{{ $item['id_punto'] }}" class="collapse" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <div class="input-group">
                                                                    <input type="number" name="prioridad_p_p" id="prioridad_p_p" data-priori="{{ $item['prioridad'] }}" class="form-control"
                                                                        placeholder="Prioridad: {{ $item['prioridad'] }}">
                                                                    <input type="text" name="avance_p_p" id="avance_p_p" data-avance="{{ $item['porcentaje'] }}" class="form-control"
                                                                        placeholder="Avance: {{ $item['porcentaje'] }} %">
                                                                    <select class="form-control" name="estado_p_p" id="estado_p_p">
                                                                        <option value="{{ $item['estado'] }}">{{ $item['estado'] }}</option>
                                                                        <option value="Creado">Creado</option>
                                                                        <option value="En proceso">En proceso</option>
                                                                        <option value="Revisada">Revisada</option>
                                                                        <option value="Estancada">Estancada</option>
                                                                        <option value="Aplazada">Aplazada</option>
                                                                        <option value="Cancelada">Cancelada</option>
                                                                        <option value="En revision">En revision</option>
                                                                        <option value="Completada">Completada</option>
                                                                    </select>
                                                                    <button type="button" onclick="ActualizarPuntosSegInd('{{ $item['id_punto'] }}')" class="btn btn-danger">Agregar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h5>Seguimiento</h5>
                                                                <hr>
                                                                <form id="form-seguimiento-puntos" method="post">
                                                                    <div class="input-group">
                                                                        <input type="text" hidden value="{{ $item['id_punto'] }}" class="form-control" name="id_punto_seg" id="id_punto_seg">
                                                                        <input type="text" name="seguimiento_general" id="seguimiento_general" class="form-control" placeholder="Seguimiento">
                                                                        <input type="file" multiple name="documentos_general[]" id="documentos_general" class="form-control" placeholder="Documentos">
                                                                        <button type="button" onclick="AgregarPuntoDesarrollar('form-seguimiento-puntos','agregar-seg-punto')" class="btn btn-secondary">Agregar</button>
                                                                    </div>
                                                                </form>
                                                                <hr>
                                                                @foreach ($item['seguimiento'] as $seg)
                                                                    <div class="post clearfix">
                                                                        <div class="user-block">
                                                                            <img class="img-circle img-bordered-sm" src="{{ asset('icons/usuario.png') }}" alt="User Image">
                                                                            <span class="username">
                                                                                <div class="text-blue">{{ $seg['responsable'] }}</div>
                                                                            </span>
                                                                            <span class="description">{{ date('Y-m-d', strtotime($seg['fecha'])) }}</span>
                                                                        </div>
                                                                        <p>{{ $seg['seguimiento'] }}</p>
                                                                        <p>
                                                                            @foreach ($seg['docs'] as $doc)
                                                                                <a href="{{ asset($doc->url_doc_p) }}" target="_BLANK" class="link-black text-sm mr-3"><i
                                                                                        class="fas fa-link mr-1"></i>{{ $doc->nom_doc_p }}</a>
                                                                            @endforeach
                                                                        </p>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <h4>Seguimiento General</h4>
                                    <hr>
                                    <form id="form-seguimiento-general" method="post">
                                        <div class="input-group">
                                            <input type="text" name="seguimiento_general" id="seguimiento_general" class="form-control" placeholder="Seguimiento">
                                            <input type="file" multiple name="documentos_general[]" id="documentos_general" class="form-control" placeholder="Documentos">
                                            <button type="button" onclick="AgregarPuntoDesarrollar('form-seguimiento-general','agregar-seg-general')" class="btn btn-secondary">Agregar</button>
                                        </div>
                                    </form>
                                    <hr>
                                    @foreach ($seguimiento as $seg)
                                        <div class="post clearfix">
                                            <div class="user-block">
                                                <img class="img-circle img-bordered-sm" src="{{ asset('icons/usuario.png') }}" alt="user image">
                                                <span class="username">
                                                    <div class="text-blue">{{ $seg['responsable'] }}</div>
                                                </span>
                                                <span class="description">{{ $seg['fecha'] }}</span>
                                            </div>
                                            <p>{{ $seg['seguimiento'] }}</p>
                                            <p>
                                                @foreach ($seg['documentos'] as $doc)
                                                    <a href="{{ asset($doc->url_doc_seg) }}" target="_BLANK" class="link-black text-sm mr-3"><i class="fas fa-link mr-1"></i>{{ $doc->nom_doc_seg }}</a>
                                                @endforeach
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                            <h3 class="text-primary"><i class="fas fa-project-diagram"></i> <input type="text" value="{{ $proyecto[0]->nombre_solicitud }}" class="form-control" name="titulo_p" id="titulo_p">
                            </h3>
                            <p class="text-muted">
                                <textarea class="form-control" name="descripcion_p" id="descripcion_p" cols="30" rows="2">{{ $proyecto[0]->descripcion }}</textarea>
                            </p>
                            <br>
                            <div class="text-muted">
                                <p class="text-sm">Tipo de solicitud
                                    <b class="d-block">{{ $proyecto[0]->tipo_solicitud }}</b>
                                </p>
                                <p class="text-sm">Responsable de la solicitud
                                    <b class="d-block">{{ $proyecto[0]->nombre_solicitante }}</b>
                                </p>
                                <p class="text-sm">Estado
                                    <b class="d-block">
                                        <select class="form-control" name="estado_p" id="estado_p">
                                            <option value="{{ $proyecto[0]->estado }}">{{ $proyecto[0]->estado }}</option>
                                            <option value="Creada">Creada</option>
                                            <option value="En proceso">En proceso</option>
                                            <option value="Revisada">Revisada</option>
                                            <option value="Estancada">Estancada</option>
                                            <option value="Aplazada">Aplazada</option>
                                            <option value="Cancelada">Cancelada</option>
                                            <option value="En revision">En revision</option>
                                            <option value="Completada">Completada</option>
                                        </select>
                                    </b>
                                </p>
                                <p class="text-sm">Avance
                                    <b class="d-block">{{ $proyecto[0]->porcentaje }} %</b>
                                </p>
                                <p class="text-sm">Prioridad
                                    <b class="d-block"><input type="number" class="form-control" value="{{ $proyecto[0]->prioridad }}" name="prioridad_p" id="prioridad_p"></b>
                                </p>
                            </div>

                            <h5 class="mt-5 text-muted">Documentos adjuntos</h5>
                            <ul class="list-unstyled">
                                @foreach ($documentos as $doc)
                                    <li>
                                        <a href="{{ asset($doc->url_doc) }}" target="_BLANK" class="btn-link text-secondary"><i class="fas fa-link mr-1"></i> {{ $doc->nombre_documento }}.{{ $doc->tipo_doc }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <button type="button" onclick="ActualizarinfoSolicitud()" class="btn btn-danger btn-sm mt-4">Actualizar información</button>
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Participantes</span>
                                            <span class="info-box-number text-center text-muted mb-0">
                                                <form id="form-participantes-proyecto" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <select class="select2" multiple="multiple" onchange="ActualizarParticipantes()" name="participantes_pr[]" id="participantes_pr" data-placeholder="Participantes"
                                                            style="width: 100%;">
                                                            @foreach ($usuarios as $item)
                                                                <option value="{{ $item->id }}" {{ in_array($item->id, $participantes) ? 'selected' : '' }}>{{ $item->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </form>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script>
        $(() => {
            $('.select2').select2()
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });

        ActualizarinfoSolicitud = () => {
            var nombre_solicitud = $('#titulo_p').val();
            var descripcion = $('#descripcion_p').val();
            var fecha_p_entrega = $('#fecha_entrega').val();
            var estado = $('#estado_p').val();
            var prioridad = $('#prioridad_p').val();

            var datos = $.ajax({
                url: window.location.href + "/proyecto",
                type: "post",
                dataType: "json",
                data: {
                    nombre_solicitud,
                    descripcion,
                    fecha_p_entrega,
                    estado,
                    prioridad
                }
            })
            datos.done((res) => {
                if (res.status == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Solicitud exitosa',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            })
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Revisa la información y vuelve a intentar',
                    showConfirmButton: false,
                    timer: 1000
                });
            })

        }
        ActualizarPuntosSegInd = (id_punto) => {
            var prioridad = $('#prioridad_p_p').val();
            var avance = $('#avance_p_p').val();
            var estado = $('#estado_p_p').val();

            if (prioridad.length < 1) {
                prioridad = $('#prioridad_p_p').data('priori')
            }
            if (avance.length < 1) {
                avance = $('#avance_p_p').data('avance')
            }
            var datos = $.ajax({
                url: window.location.href + "/actualizar-avance",
                type: "post",
                dataType: "json",
                data: {
                    id_punto,
                    prioridad,
                    avance,
                    estado
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Solicitud exitosa',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            })
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Revisa la información y vuelve a intentar',
                    showConfirmButton: false,
                    timer: 1000
                });
            })
        }
        AgregarPuntoDesarrollar = (form, dest) => {
            var formulario = new FormData(document.getElementById(form));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: window.location.href + "/" + dest,
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                if (res.status == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Solicitud exitosa',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            });
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Revisa la información y vuelve a intentar',
                    showConfirmButton: false,
                    timer: 1000
                });
            });
        }
        ActualizarParticipantes = () => {
            var formulario = new FormData(document.getElementById('form-participantes-proyecto'));
            formulario.append('proyecto', $('#titulo_p').val());
            formulario.append('tipo', '{{ $proyecto[0]->tipo_solicitud }}');

            var datos = $.ajax({
                url: window.location.href + "/actualizar-participantes",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Recarga la página',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        }
    </script>
@endsection
