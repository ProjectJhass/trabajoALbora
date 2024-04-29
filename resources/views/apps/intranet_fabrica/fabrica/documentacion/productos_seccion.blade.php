@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    Documentación
@endsection
@section('menu-prod')
    menu-open
@endsection
@section('active')
    bg-danger active
@endsection
@section('active-sub-doc')
    active
@endsection
@section('fabrica-body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Documentación técnica</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home.intranet.fabrica') }}">Fábrica</a></li>
                        <li class="breadcrumb-item active">Documentación</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h6>{{ strtoupper($seccion . ' / ' . $referencia) }}</h6>
                </div>
                <div class="card-body">
                    @if (Auth::user()->rol_user == 1)
                        <div class="callout callout-danger shadow-lg">
                            <form id="formulario-registro-titulo" method="post" class="was-validated" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <input type="text" name="id_seccion" id="id_seccion" value="{{ $id_seccion }}" hidden>
                                            <input type="text" name="id_referencia" id="id_referencia" value="{{ $id_referencia }}" hidden>
                                            <input type="text" class="form-control" onkeyup="this.value=this.value.toUpperCase()"
                                                name="titulo_seccion_prod" id="titulo_seccion_prod" placeholder="Nombre de la carpeta">
                                        </div>

                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success btn-block btn-sm"
                                            onclick="CrearTituloSeccion('formulario-registro-titulo','{{ route('crear.title') }}')" type="button">Crear
                                            carpeta</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif

                    <div class="row">
                        @foreach ($informacion as $key => $value)
                            <div class="col-md-6 mb-3">
                                <div class="container-fluid h-100">
                                    <div class="card card-row card-secondary shadow-lg">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                {{ $value['titulo'] }}
                                            </h3>
                                            @if (Auth::user()->rol_user == 1)
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool"
                                                        onclick="CargarNuevaDocumentacion('{{ $value['id_titulo'] }}','formulario-nuevo-doc', '{{ route('new.doc') }}')">
                                                        <i class="fas fa-upload"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-tool"
                                                        onclick="EliminarCarpetaDocumentacion('{{ $value['id_titulo'] }}','{{ route('eliminar.carp.fab') }}')"><i
                                                            class="fas fa-trash"></i></button>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            @if (Auth::user()->rol_user == 1)
                                                <form id="formulario-nuevo-doc{{ $value['id_titulo'] }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    name="DocumentoSeccion{{ $value['id_titulo'] }}"
                                                                    id="DocumentoSeccion{{ $value['id_titulo'] }}">
                                                                <label class="custom-file-label" for="DocumentoSeccion{{ $value['id_titulo'] }}">Nuevo
                                                                    archivo</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            @endif
                                            @foreach ($value['documentos'] as $key => $val)
                                                <?php $cadena = explode('_', $val->nombre_documento); ?>
                                                <div class="card card-primary card-outline">
                                                    <div class="card-header">
                                                        <p class="card-title" style="font-size: 14px">{{ str_replace('.pdf', '', $cadena[1]) }}</p>
                                                        <div class="card-tools">
                                                            @if (Auth::user()->rol_user == 1)
                                                                <button type="button" class="btn btn-tool"
                                                                    onclick="EliminarDocumentacionFab('{{ $val->id_documento }}','{{ $val->nombre_documento }}','{{ route('eliminar.documento') }}')"><i
                                                                        class="fas fa-trash"></i></button>
                                                            @endif
                                                            <a href="{{ asset('storage/documentacion-tecnica/' . $val->nombre_documento) }}"
                                                                type="button" class="btn btn-tool" target="_BLANK"><i class="fas fa-expand"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
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
@section('scripts')
    <script>
        $(function() {
            bsCustomFileInput.init();
        });

        VisualizarPdfDocs = (id_doc) => {
            if ($('#body-documentacion' + id_doc).is(':visible')) {
                document.getElementById('body-documentacion' + id_doc).hidden = true;
            } else {
                setTimeout(() => {
                    document.getElementById('body-documentacion' + id_doc).hidden = false;
                }, 500);
            }
        }

        CrearTituloSeccion = (id_form, url) => {
            var formulario = document.getElementById(id_form);
            var info = new FormData(formulario);
            info.append('valor', 'valor');
            var datos = $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: info,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                if (res.status == true) {
                    toastr.success('BIEN: Información creada');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            });
            datos.fail(() => {
                toastr.error('ERROR: Revisa la información y vuelve a intentar');
            });
        }

        CargarNuevaDocumentacion = (id_titulo, form, url) => {
            var formulario = document.getElementById(form + id_titulo);
            var info = new FormData(formulario);
            info.append('id_titulo', id_titulo);
            var datos = $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: info,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                if (res.status == true) {
                    toastr.success('BIEN: Información creada');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            });
            datos.fail(() => {
                toastr.error('ERROR: Revisa la información y vuelve a intentar');
            });
        }

        EliminarDocumentacionFab = (id_documento, nombre_documento, url) => {
            Swal.fire({
                title: 'Estas seguro de eliminar?',
                text: "No podrás reversar esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var response = ConfirmarEliminacionDocumento(id_documento, nombre_documento, url);
                    response.done((res) => {
                        if (res.status == true) {
                            Swal.fire(
                                'BIEN!',
                                'El documento se eliminó correctamente',
                                'success'
                            )
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    });
                    response.fail(() => {
                        Swal.fire(
                            'ERROR!',
                            'Hubo un problema al procesar la solicitud',
                            'error'
                        )
                    });
                }
            })
        }

        ConfirmarEliminacionDocumento = (id_documento, nombre_documento, url) => {
            var datos = $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: {
                    id_documento,
                    nombre_documento
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            return datos;
        }

        EliminarCarpetaDocumentacion = (id_carpeta, url) => {
            Swal.fire({
                title: 'Estas seguro de eliminar?',
                text: "No podrás reversar esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var response = ConfirmEliminacionCarpeta(id_carpeta, url);
                    response.done((res) => {
                        if (res.status == true) {
                            Swal.fire(
                                'BIEN!',
                                'La carpeta se eliminó correctamente',
                                'success'
                            )
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    });
                    response.fail(() => {
                        Swal.fire(
                            'ERROR!',
                            'Hubo un problema al procesar la solicitud',
                            'error'
                        )
                    });
                }
            })
        }

        ConfirmEliminacionCarpeta = (id_carpeta, url) => {
            var datos = $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: {
                    id_carpeta
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            return datos;
        }
    </script>
@endsection
