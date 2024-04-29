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
                    <h4>Nuevas solicitudes</h4>
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
            <form method="post" id="formulario-bitacora-solicitud" enctype="multipart/form-data" class="was-validated">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-outline card-secondary">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Tipo de solicitud</label>
                                    <select name="tipo_proyecto" id="tipo_proyecto" class="form-control" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="ACTUALIZACION">Actualización</option>
                                        <option value="CREACION">Creación</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Nombre del proyecto</label>
                                    <input type="text" class="form-control" name="nombre_proyecto" id="nombre_proyecto" placeholder="Titulo del proyecto" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Descripción del proyecto</label>
                                    <textarea name="descripcion_p" id="descripcion_p" class="form-control" cols="30" rows="5" placeholder="Descripción" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Responsable</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->nombre }}" name="responsable_p" id="responsable_p" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-outline card-secondary">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Documentos</label>
                                    <input type="file" class="form-control" multiple onclick="CrearSolicitudProyecto()" name="documentos_proyecto[]" id="documentos_proyecto" required>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-danger" onclick="CrearSolicitudBitacora('formulario-bitacora-solicitud')">Crear solicitud</button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <p><strong>Nota:</strong> Debes diligenciar el documento correspondiente dependiendo el tipo de solicitud y cargalo en formato PDF.</p>
                                <p><a href="{{ asset('storage/bitacora/formatos/DOCUMENTO REQUERIMIENTOS - ACTUALIZACION.docx') }}">FORMATO DE ACTUALIZACIÓN DE PROYECTOS</a></p>
                                <p><a href="{{ asset('storage/bitacora/formatos/DOCUMENTO REQUERIMIENTOS - CREACION.docx') }}">FORMATO DE CREACIÓN DE PROYECTOS</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('footer')
    <script src="{{ asset('js/bitacora/proyectos.js') }}"></script>
@endsection
