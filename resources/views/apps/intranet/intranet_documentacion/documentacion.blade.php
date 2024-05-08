@extends('apps.intranet.plantilla.app')
@section('title')
    {{ ucfirst(str_replace('-', ' ', $seccion)) }}
@endsection
@section($dpto)
    bg-danger active
@endsection
@section('body')
    @if (($permiso['dpto'] == Auth::user()->dpto_user && $permiso['permiso'] == Auth::user()->permiso_dpto) || Auth::user()->permisos == '4')
        <?php $permiso_edit = 1; ?>
    @else
        <?php $permiso_edit = 0; ?>
    @endif
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>{{ ucfirst(str_replace('-', ' ', $seccion)) }}</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Documentación</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @if ($permiso_edit == 1)
                    <div class="col-md-4 mb-3">
                        <div class="card card-outline card-secondary">
                            <div class="card-header">
                                Cargar información
                            </div>
                            <div class="card-body">
                                <form method="post" id="form-documentacion-intranet" enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="file" name="docs_log[]" multiple class="form-control" id="docs_log">
                                        {{-- <div class="custom-file">
                                        <label class="custom-file-label" for="docs_log">Buscar archivos</label>
                                    </div> --}}
                                    </div>
                                    <button type="button" onclick="CargarDocumentos('form-documentacion-intranet')" id="btn-cargue-docs-intranet"
                                        class="btn btn-danger">Subir archivos</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-{{ $permiso_edit == 1 ? '8' : '12' }} mb-3">
                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Documentos cargados</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="nav nav-pills flex-column">
                                @foreach ($documentos as $item)
                                    <li class="nav-item active">
                                        <div class="nav-link">
                                            <a href="{{ asset($item->url) }}" target="_BLANK" class="text-secondary">
                                                <i class="far fa-file-alt"></i> {{ $item->nombre_doc }}
                                            </a>
                                            @if ($permiso_edit == 1)
                                                <span class="badge bg-danger float-right" onclick="EliminarDocumentoDB('{{ $item->id_documento }}')"><i
                                                        class="fas fa-trash"></i></span>
                                            @endif
                                            <span class="badge bg-success float-right">{{ $item->tipo }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($permiso_edit == 1)
            <div class="modal fade" id="modal-enviar-notificacion-areas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #c22121; color: #e2e2e2;">
                            <h4 class="modal-title">Notificación - envio de email</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="notificacion-email-areas" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mt-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" hidden name="departamento" id="departamento">
                                            <input type="text" class="form-control" hidden name="seccion" id="seccion">

                                            <p><strong>Nota: </strong> Se enviará una notificación al correo electronico a las personas que seleccione en
                                                el siguiente campo, esta notificación les comunicará el cargue del
                                                archivo
                                                para que puedan ingresar y revisar su correspondiente información</p>
                                            <label>Enviar notificación a:</label>
                                            <select class="select2" multiple="multiple" data-placeholder="Seleccione los usuarios" style="width: 100%;"
                                                name="notificar_usuarios[]" id="notificar_usuarios">

                                                <option value="LOGISTICA">LOGISTICA</option>
                                                <option value="CARTERA">CARTERA</option>
                                                <option value="VENTAS">VENTAS</option>
                                                <option value="RRHH">RRHH</option>
                                                <option value="AUDITORIA">AUDITORIA</option>
                                                <option value="CONTABILIDAD">CONTABILIDAD</option>
                                                <option value="TESORERIA">TESORERIA</option>
                                                <option value="SISTEMAS">SISTEMAS</option>

                                                <option value="FABRICA">FABRICA</option>

                                                <option value="REGIONALES">REGIONALES</option>

                                                <option value="002">ALMACEN 002</option>
                                                <option value="004">ALMACEN 004</option>
                                                <option value="008">ALMACEN 008</option>
                                                <option value="010">ALMACEN 010</option>
                                                <option value="011">ALMACEN 011</option>
                                                <option value="012">ALMACEN 012</option>
                                                <option value="014">ALMACEN 014</option>
                                                <option value="017">ALMACEN 017</option>
                                                <option value="025">ALMACEN 025</option>
                                                <option value="027">ALMACEN 027</option>
                                                <option value="028">ALMACEN 028</option>
                                                <option value="036">ALMACEN 036</option>

                                                <option value="PPAL">TODOS OF PPAL</option>
                                                <option value="ALMACENES">TODOS ALMACENES</option>

                                                <option value="TODOS">TODOS PPAL Y ALMACENES</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="location.reload()">No Enviar notificación y
                                cerrar</button>
                            <button type="button" class="btn btn-success"
                                onclick="ValidarExistenciaEmails('notificacion-email-areas','{{ route('intranet.docs.general.not') }}');">Enviar
                                notificación</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </section>
@endsection
@section('footer')
    <script>
        $(function() {
            $('.select2').select2()
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });


        CargarDocumentos = (form) => {

            $('#btn-cargue-docs-intranet').prop('disabled', true);
            $('#btn-cargue-docs-intranet').removeClass('btn-danger');
            $('#btn-cargue-docs-intranet').addClass('btn-info');
            $('#btn-cargue-docs-intranet').text('Subiendo archivos...');

            var formulario = new FormData(document.getElementById(form));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: window.location.href,
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                if (res.status == true) {
                    ModalNotificacionDocumentacion(res.dpto, res.seccion)
                    $('#btn-cargue-docs-intranet').prop('disabled', false);
                    $('#btn-cargue-docs-intranet').removeClass('btn-info');
                    $('#btn-cargue-docs-intranet').addClass('btn-danger');
                    $('#btn-cargue-docs-intranet').text('Subir archivos');
                }
            });
            datos.fail(() => {
                $('#btn-cargue-docs-intranet').prop('disabled', false);
                $('#btn-cargue-docs-intranet').removeClass('btn-info');
                $('#btn-cargue-docs-intranet').addClass('btn-danger');
                $('#btn-cargue-docs-intranet').text('Subir archivos');
            });
        }

        ModalNotificacionDocumentacion = (dpto, seccion) => {
            $('#departamento').val(dpto);
            $('#seccion').val(seccion);
            $('#modal-enviar-notificacion-areas').modal('show');
        }

        ValidarExistenciaEmails = (form, url) => {
            var formulario = new FormData(document.getElementById(form));
            formulario.append('valor', 'valor');

            Swal.fire({
                position: 'top-end',
                icon: 'info',
                title: 'Enviando notificación...',
                showConfirmButton: false,
                timer: 10000
            });

            var datos = $.ajax({
                url: url,
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
                        title: 'Notificación enviada',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            });
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Se produjo un error al momento de enviar',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        }

        EliminarDocumentoDB = (id) => {
            var datos = $.ajax({
                url: window.location.href + "/eliminar",
                type: "post",
                dataType: "json",
                data: {
                    id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    location.reload();
                }
            });
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Se produjo un error al momento de enviar',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        }
    </script>
@endsection
