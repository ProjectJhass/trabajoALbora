@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    SGC
@endsection
@section('tables-bootstrap-css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('menu-calidad')
    menu-open
@endsection
@section('active-calidad')
    bg-danger active
@endsection
@section('active-sub-sgc')
    active
@endsection
@section('fabrica-body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">{{ $titulo }}</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home.intranet.fabrica') }}">Fábrica</a></li>
                        <li class="breadcrumb-item active">Documentación SGC</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            @if (Auth::user()->rol_user == 1)
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="callout callout-danger">
                                    <div class="row mt-3">
                                        <div class="col-md-8">
                                            <form id="formulario-nuevo-doc-sgc" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="DocumentosSGC" id="DocumentosSGC">
                                                            <label class="custom-file-label" for="DocumentosSGC">Nuevo archivo</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-danger"
                                                onclick="CargarDocuemtosSGC('{{ $seccion }}','0','{{ route('cargar.sgc') }}','formulario-nuevo-doc-sgc')">Cargar
                                                documento</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="card card-outline card-danger">
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-striped" id="table-informacion-general-docs">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Documento</th>
                                        @if (Auth::user()->rol_user == 1)
                                            <th><i class="fas fa-trash text-danger"></i></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php $n = 0; ?>
                                    @foreach ($documentos as $key => $value)
                                        <?php $n++; ?>
                                        <tr>
                                            <td>{{ $n }}</td>
                                            <td class="text-left">
                                                <a href="{{ asset('documentacion-sgc/' . $value->documento) }}"
                                                    style="text-decoration: none; color: black" target="_BLANK">
                                                    <small><img src="{{ asset('icons/pdf.png') }}" alt="" width="40px">
                                                        {{ $value->nombre_doc }}</small>
                                                </a>
                                            </td>
                                            @if (Auth::user()->rol_user == 1)
                                                <td>
                                                    <i class="fas fa-trash text-danger" style="cursor: pointer"
                                                        onclick="EliminarDocumentoSGC('{{ $value->id_documento }}','{{ $value->documento }}','{{ route('eliminar.doc.sgc') }}')"></i>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    @switch($seccion)
                        @case(1)
                            <div class="col-md-12 mb-3">
                                <div class="card card-outline card-danger">
                                    <div class="card-body">
                                        <a href="{{ route('docs.sgc.niv2', ['seccion' => '1', 'carpeta_seccion' => '1']) }}">
                                            <img src="{{ asset('icons/carpetas.png') }}" alt="" width="50px">
                                            PD - Procedimientos
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @break

                        @case(2)
                            <div class="col-md-12 mb-3">
                                <div class="card card-outline card-danger">
                                    <div class="card-body">
                                        <a href="{{ route('docs.sgc.niv2', ['seccion' => '2', 'carpeta_seccion' => '1']) }}">
                                            <img src="{{ asset('icons/carpetas.png') }}" alt="" width="50px">
                                            EP - Especificaciones
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="card card-outline card-danger">
                                    <div class="card-body">
                                        <a href="{{ route('docs.sgc.niv2', ['seccion' => '2', 'carpeta_seccion' => '2']) }}">
                                            <img src="{{ asset('icons/carpetas.png') }}" alt="" width="50px">
                                            IT - Instructivos
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="card card-outline card-danger">
                                    <div class="card-body">
                                        <a href="{{ route('docs.sgc.niv2', ['seccion' => '2', 'carpeta_seccion' => '3']) }}">
                                            <img src="{{ asset('icons/carpetas.png') }}" alt="" width="50px">
                                            PD - Procedimientos
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @break

                        @case(3)
                            <div class="col-md-12 mb-3">
                                <div class="card card-outline card-danger">
                                    <div class="card-body">
                                        <a href="{{ route('docs.sgc.niv2', ['seccion' => '3', 'carpeta_seccion' => '1']) }}">
                                            <img src="{{ asset('icons/carpetas.png') }}" alt="" width="50px">
                                            PD - Procedimientos
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @break

                        @case(4)
                            <div class="col-md-12 mb-3">
                                <div class="card card-outline card-danger">
                                    <div class="card-body">
                                        <a href="{{ route('docs.sgc.niv2', ['seccion' => '4', 'carpeta_seccion' => '1']) }}">
                                            <img src="{{ asset('icons/carpetas.png') }}" alt="" width="50px">
                                            IT - Instructivos
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="card card-outline card-danger">
                                    <div class="card-body">
                                        <a href="{{ route('docs.sgc.niv2', ['seccion' => '4', 'carpeta_seccion' => '2']) }}">
                                            <img src="{{ asset('icons/carpetas.png') }}" alt="" width="50px">
                                            PD - Procedimientos
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @break

                        @case(5)
                            <div class="col-md-12 mb-3">
                                <div class="card card-outline card-danger">
                                    <div class="card-body">
                                        <a href="{{ route('docs.sgc.niv2', ['seccion' => '5', 'carpeta_seccion' => '1']) }}">
                                            <img src="{{ asset('icons/carpetas.png') }}" alt="" width="50px">
                                            EP - Especificaciones de seguridad y mantenimiento
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="card card-outline card-danger">
                                    <div class="card-body">
                                        <a href="{{ route('docs.sgc.niv2', ['seccion' => '5', 'carpeta_seccion' => '2']) }}">
                                            <img src="{{ asset('icons/carpetas.png') }}" alt="" width="50px">
                                            IT - Instructivos
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="card card-outline card-danger">
                                    <div class="card-body">
                                        <a href="{{ route('docs.sgc.niv2', ['seccion' => '5', 'carpeta_seccion' => '3']) }}">
                                            <img src="{{ asset('icons/carpetas.png') }}" alt="" width="50px">
                                            PD - Procedimientos
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @break
                    @endswitch
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
        $(function() {
            $('#table-informacion-general-docs').DataTable({
                "oLanguage": {
                    "sSearch": "Buscar:",
                    "sInfo": "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                    "oPaginate": {
                        "sPrevious": "Volver",
                        "sNext": "Siguiente"
                    },
                    "sEmptyTable": "No se encontró ningun registro en la base de datos",
                    "sZeroRecords": "No se encontraron resultados...",
                    "sLengthMenu": "Mostrar _MENU_ registros"
                },
                "order": [
                    [0, "asc"]
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });
            $('#table-informacion-general-docs-n2').DataTable({
                "oLanguage": {
                    "sSearch": "Buscar:",
                    "sInfo": "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                    "oPaginate": {
                        "sPrevious": "Volver",
                        "sNext": "Siguiente"
                    },
                    "sEmptyTable": "No se encontró ningun registro en la base de datos",
                    "sZeroRecords": "No se encontraron resultados...",
                    "sLengthMenu": "Mostrar _MENU_ registros"
                },
                "order": [
                    [0, "asc"]
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });
        });

        CargarDocuemtosSGC = (carpeta, subcarpeta, url, form) => {
            var info = new FormData(document.getElementById(form));
            info.append('carpeta', carpeta);
            info.append('subcarpeta', subcarpeta);
            var datos = $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: info,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((response) => {
                if (response.status == true) {
                    toastr.success('Excelente, documento cargado');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            });
            datos.fail(() => {
                toastr.error('Error, hubo un problema al procesar la solicitud');
            });
        }

        EliminarDocumentoSGC = (id_documento, nombre_doc, url) => {
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
                    var response = EliminarDocumentoSGC_confirm(id_documento, nombre_doc, url);
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

        EliminarDocumentoSGC_confirm = (id_documento, nombre_doc, url) => {
            var datos = $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: {
                    id_documento,
                    nombre_doc
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            return datos;
        }
    </script>
@endsection
