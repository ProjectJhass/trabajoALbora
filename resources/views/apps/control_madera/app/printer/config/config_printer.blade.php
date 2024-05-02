@extends('apps.control_madera.plantilla.app')
@section('head')
@endsection
@section('body')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h2>Configuración</h2>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="page-body mt-4">
            <div class="row">
                <div class="col-md-6 col-sm-6" id="table-impresoras">
                    {!! $impresoras !!}
                </div>
                <div class="col-md-6 col-sm-6 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Configuración de impresora</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-box">
                                        <form class="form-label-left input_mask" id="formConfigPrinter" autocomplete="off">
                                            @csrf
                                            <div class="form-group row" hidden>
                                                <label class="col-form-label col-md-3 col-sm-3 ">Id impresora </label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" name="id_impresora" id="id_impresora" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3 ">Tipo conexión</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <select class="form-control" name="conexion_impresora" onchange="updateFieldsForm(this.value)"
                                                        id="conexion_impresora">
                                                        <option value="">Seleccionar...</option>
                                                        <option value="red">Red</option>
                                                        <option value="cable">Cable</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3 ">Impresora</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <select class="form-control" name="tipo_impresora" id="tipo_impresora">
                                                        <option value="">Seleccionar...</option>
                                                        <option value="zebra">Zebra</option>
                                                        <option value="otro">Otro</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3 ">Nombre impresora </label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" name="nombre_impresora" id="nombre_impresora" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row" id="combIpImpresora">
                                                <label class="col-form-label col-md-3 col-sm-3 ">IP impresora</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" name="ip_impresora" id="ip_impresora" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row" id="combPuertoImpresora">
                                                <label class="col-form-label col-md-3 col-sm-3 ">Puerto impresora</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" name="puerto_impresora" id="puerto_impresora" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3 ">Estado impresora</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <select class="form-control" name="estado_impresora" id="estado_impresora">
                                                        <option value="">Seleccionar...</option>
                                                        <option value="1">En uso</option>
                                                        <option value="0">Inactivo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="ln_solid"></div>
                                            <div class="form-group text-center">
                                                <button class="btn btn-secondary" type="reset">Limpiar</button>
                                                <button type="button" onclick="updateConfigPrinter()" class="btn btn-success">Actualizar
                                                    información</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        updateFieldsForm = (valor) => {
            if (valor == 'cable') {
                document.getElementById('combIpImpresora').hidden = true
                document.getElementById('combPuertoImpresora').hidden = true
            } else {
                document.getElementById('combIpImpresora').hidden = false
                document.getElementById('combPuertoImpresora').hidden = false
            }
        }
        updateConfigPrinter = () => {
            notificacion("Actualizando información...", "info", 10000);
            var formulario = new FormData(document.getElementById('formConfigPrinter'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ route('save.config.printer') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                notificacion("¡Impresora actualizada correctamente!", "success", 3000);
                document.getElementById('formConfigPrinter').reset()
                document.getElementById('table-impresoras').innerHTML = res.table
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
            })
        }

        searchInfoPrinter = (id) => {
            var datos = $.ajax({
                url: "{{ route('search.config.printer') }}",
                type: "post",
                dataType: "json",
                data: {
                    id
                }
            });
            datos.done((res) => {
                updateFieldsForm(res.info.Conexion)
                $('#id_impresora').val(res.info.Id)
                $('#nombre_impresora').val(res.info.Nombre)
                $('#ip_impresora').val(res.info.Ip)
                $('#puerto_impresora').val(res.info.Puerto)
                $('#estado_impresora').val(res.info.Estado)
                $('#conexion_impresora').val(res.info.Conexion)
                $('#tipo_impresora').val(res.info.Impresora)
            })
            datos.fail(() => {
                notificacion("ERROR! Revisa los campos y vuelve a intentarlo", "error", 5000);
            })
        }
    </script>
@endsection
