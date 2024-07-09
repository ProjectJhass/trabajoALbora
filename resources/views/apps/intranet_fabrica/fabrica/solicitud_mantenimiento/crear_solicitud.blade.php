@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    Solicitudes Mtto
@endsection
@section('menu-mtto')
    menu-open
@endsection
@section('active-mtto')
    bg-danger active
@endsection
@section('active-sub-mantenimiento')
    active
@endsection
@section('fabrica-body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Solicitudes Mantenimiento</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home.intranet.fabrica') }}">Fábrica</a></li>
                        <li class="breadcrumb-item active">Solicitudes mantenimiento</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <strong>Solicitud de servicio de mantenimiento</strong>
                </div>
                <div class="card-body">
                    <form class="was-validated" id="formulario-generar-solicitud-mantenimiento" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">

                                <div class="form-group">
                                    <label>Producto a trabajar</label>
                                    <select class="select2" data-placeholder="Seleccione el producto" style="width: 100%;"
                                        name="herramienta_solicitar" id="herramienta_solicitar">
                                        <option value=""></option>
                                        @foreach ($herramientas as $key => $val)
                                            <option value="{{ trim($val->referencia . '-' . $val->nombre_maquina) }}">
                                                {{ trim($val->referencia . '-' . $val->nombre_maquina) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="">Sección</label>
                                    <select name="nombre_seccion_solicitar" id="nombre_seccion_solicitar"
                                        class="form-control">
                                        <option value="">Seleccionar...</option>
                                        @foreach ($secciones as $key => $value)
                                            <option value="{{ $value->nombre_seccion }}">{{ $value->nombre_seccion }}
                                            </option>
                                        @endforeach
                                        <option value="CORTE Y COSTURA">CORTE Y COSTURA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="">Requerimiento</label>
                                    <textarea name="requerimiento_solicitud" id="requerimiento_solicitud" class="form-control" cols="30" rows="3"
                                        placeholder="Detalle el requerimiento para procesar su solicitud"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="">Responsable</label>
                                    <input type="text" class="form-control" name="responsable_solicitud"
                                        id="responsable_solicitud" placeholder="Nombre responsable de la solicitud">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger" id="ValidarSolicitudMantenimiento"
                            onclick="crearNuevaSolicitudMttoFab()">Generar
                            solicitud de mantenimiento</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(function() {
            $('.select2').select2()
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });

        BuscarInformacionCerrarSolicitudMtto = (url) => {
            var seccion = $('#nombre_seccion_consultar').val();
            if (seccion.length > 0) {
                var datos = $.ajax({
                    url: url,
                    type: "post",
                    dataType: "json",
                    data: {
                        seccion
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                datos.done((res) => {
                    if (res.status == true) {
                        document.getElementById('respuesta-cerrar-solicitud-mantenimiento').innerHTML = res
                        .data;
                    }
                });
                datos.fail(() => {
                    toastr.error('Hubo un problema al procesar la solicitud');
                });
            } else {
                toastr.error('ERROR: Selecciona una sección');
            }
        }

        ModalCerrarSolicitudMtto = (id_solicitud, url) => {
            $('#Modal-cerrar-solicitud-mantenimiento').modal('show');
            var datos = $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: {
                    id_solicitud
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    document.getElementById('respuesta-modal-solicitud-mtto').innerHTML = res.data;
                }
            });
            datos.fail(() => {
                toastr.error('Hubo un problema al procesar la solicitud');
            });
        }

        CerrarSolicitudMttoAdmin = (url) => {
            toastr.info('Cerrando solicitud...');

            var responsable = $('#responsable_cerrar').val();
            var fecha_fin = $('#fecha_cerrar_fin').val();
            var id_solicitud = $('#id_cerrar_solicit_mtto').val();

            if (fecha_fin.length > 0 && responsable.length > 0) {
                var datos = $.ajax({
                    url: url,
                    type: "post",
                    dataType: "json",
                    data: {
                        id_solicitud,
                        responsable,
                        fecha_fin
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                datos.done((res) => {
                    if (res.status == true) {
                        $('#btn-cerrar-mmto' + res.id_solicitud).prop('disabled', true);
                        $('#Modal-cerrar-solicitud-mantenimiento').modal('hide');
                        $('#btn-actualizar-mtto-fab').click();
                        toastr.success('Información actualizada');
                    }
                });
                datos.fail(() => {
                    toastr.error('Hubo un problema al procesar la solicitud');
                });
            } else {
                toastr.error('Error al procesar la solicitud');
            }
        }

        crearNuevaSolicitudMttoFab=()=>{
            toastr.info('Creando nueva solicitud de mantenimiento...');

            var formulario = new FormData(document.getElementById('formulario-generar-solicitud-mantenimiento'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('generar.solicitud.mtto') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                toastr.success('¡EXCELENTE! Solicitud de mantenimiento creada');
                $('#herramienta_solicitar').val(null).trigger('change');
                document.getElementById('formulario-generar-solicitud-mantenimiento').reset()
            })
            datos.fail(() => {
                toastr.error('Hubo un problema al procesar la solicitud');
            })
        }
    </script>
@endsection
