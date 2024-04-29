@extends('apps.automoviles.layout.app')
@section('title')
    Automoviles
@endsection
@section('head')
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined" rel="stylesheet">
@endsection
@section('active-autos')
    active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Automóviles</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('albura.autos') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Automóviles</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h6>Información general</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($autos as $item)
                            <div class="col-md-3 mb-3">
                                <div class="card card-outline card-danger">
                                    <div class="card-header text-center">
                                        <div class="ref-pic-auto" id="ref-pic-auto{{ $item->id_auto }}">
                                            <a href="{{ asset('storage/autos/' . $item->imagen) }}" target="_BLANK">
                                                <img src="{{ asset('storage/autos/' . $item->imagen) }}" width="80%" alt="Imagen Autos Albura">
                                            </a>
                                        </div>
                                        <div class="card-tools">
                                            <div class="nav-item dropdown">
                                                <a class="nav-link" data-toggle="dropdown" href="#">
                                                    <i class="fas fa-cogs" style="color: rgba(180, 180, 180, 0.637)"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                    <span class="dropdown-item dropdown-header">Acciones</span>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" data-widget="control-sidebar" onclick="ConfiguracionAuto('{{ $item->id_auto }}')"
                                                        data-slide="true" class="dropdown-item">
                                                        <i class="fas fa-camera mr-2"></i> Actualizar fotografía
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item">
                                                        <i class="fas fa-trash mr-2"></i> Eliminar auto
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Matrícula:</strong> {{ $item->placa }}</p>
                                        <p><strong>Modelo:</strong> {{ $item->modelo }}</p>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="{{ route('informacion.autos', ['id_auto' => trim($item->id_auto), 'placa' => trim($item->placa), 'row_id' => trim($item->row_id)]) }}"
                                            type="button" class="btn btn-danger">Ver Información</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <aside class="control-sidebar control-sidebar-light" style="margin-top: 30px">
        <div class="card card-outline card-danger" style="min-height: 100%">
            <div class="card-header">
                <div class="card-title">
                    <h4 class="text-center"><i class="fas fa-cogs" style="color: rgba(88, 88, 88, 0.863)"></i> Configuración</h4>
                </div>
                <div class="card-tools">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <input type="text" class="form-control" hidden name="id-automovil-edit" id="id-automovil-edit">
                <div id="actualizar-pics" class="p-3">
                    <form id="form-update-pics" enctype="multipart/form-data" method="post">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <center>
                                            <div id="img-current-auto" style="width: 70%;"></div>
                                        </center>
                                    </div>
                                    <div class="card-body">
                                        <center>
                                            <input type="file" class="form-control" onchange="mostrarNombreArchivo()" hidden name="pic_auto"
                                                id="pic_auto">
                                            <img src="{{ asset('img/upload.png') }}" style="cursor: pointer" onclick="$('#pic_auto').click()"
                                                width="30%" alt="">
                                            <p><span id="nombreArchivo">No hay archivos seleccionados</span></p>
                                        </center>
                                    </div>
                                    <div class="card-footer">
                                        <center>
                                            <button type="button" onclick="ActualizarPicAutomovil()" class="btn btn-danger btn-sm">Actualizar</button>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <script>
        ConfiguracionAuto = (id) => {
            $('#id-automovil-edit').val(id)
            ActualizarAuto();
        }

        ActualizarAuto = () => {
            var id_auto = $('#id-automovil-edit').val()

            var divOriginal = document.getElementById('ref-pic-auto' + id_auto);
            var codigoHTML = divOriginal.innerHTML;

            var divDestino = document.getElementById('img-current-auto');
            divDestino.innerHTML = codigoHTML;
        }

        function mostrarNombreArchivo() {
            var input = document.getElementById('pic_auto');
            var nombreArchivo = input.files[0].name;
            var nombreArchivoSpan = document.getElementById('nombreArchivo');
            nombreArchivoSpan.textContent = nombreArchivo;
        }

        ActualizarPicAutomovil = () => {

            var id_auto = $('#id-automovil-edit').val()
            var divAuto = document.getElementById('ref-pic-auto' + id_auto)
            var divUpdate = document.getElementById('img-current-auto')

            var formData = new FormData(document.getElementById('form-update-pics'));

            formData.append('dataId', id_auto);
            var datos = $.ajax({
                url: window.location.href,
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
            datos.done((res) => {
                if (res.status == true) {
                    toastr.success('Información actualizada');
                    divAuto.innerHTML = res.img
                    divUpdate.innerHTML = res.img
                    document.getElementById('form-update-pics').reset();
                    document.getElementById('nombreArchivo').innerHTML = "No hay archivos seleccionados";
                }
            })
            datos.fail(() => {
                toastr.error('Verifica la información y vuelve a intentar');
                document.getElementById('form-update-pics').reset();
                document.getElementById('nombreArchivo').innerHTML = "No hay archivos seleccionados";
            })
        }
    </script>
@endsection
