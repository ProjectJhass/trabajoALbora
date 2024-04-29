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
@section('active-sub-cambios')
    active
@endsection
@section('fabrica-body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Cambios en serie</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home.intranet.fabrica') }}">Fábrica</a></li>
                        <li class="breadcrumb-item active">Cambios en serie</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h4>Reporte y análisis de cambios en serie</h4>
                </div>
                <div class="card-body">
                    <form class="was-validated" autocomplete="off" method="POST" id="formulario-cambio-series" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="producto">PRODUCTO/SERIE</label>
                                <input type="text" class="form-control" onkeyup="this.value=this.value.toUpperCase();" id="producto" name="producto"
                                    placeholder="Producto o serie">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">PIEZA</label>
                                <input type="text" class="form-control" onkeyup="this.value=this.value.toUpperCase();" id="pieza" name="pieza"
                                    placeholder="Pieza">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">O.P</label>
                                <input type="text" class="form-control" onkeyup="this.value=this.value.toUpperCase();" id="op" name="op"
                                    placeholder="O.P">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress2">Descripción del problema / sugerencia</label>
                            <textarea class="form-control" name="problema" id="problema" cols="30" rows="10" placeholder="Descripción del problema"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress2">Descripción del cambio / mejora</label>
                            <textarea class="form-control" name="cambio" id="cambio" cols="30" rows="10" placeholder="Descripción del cambio"></textarea>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="AgregarImagenes" name="AgregarImagenes" value="1">
                                        <label class="form-check-label" for="AgregarImagenes">
                                            Agregar Imagenes
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body bg-info text-white" id="input-cargar-imagenes-formato" hidden>
                                <div class="form-group">
                                    <label for="inputAddress2">Adjuntar imagenes <small>(Máximo 4 imagenes)</small></label>
                                    <input type="file" multiple name="imagen[]" id="imagen[]" accept=".jpg, .jpeg, .png">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Análisis del cambio por sección</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr style="text-align: center;">
                                                <th scope="col">Sección</th>
                                                <th scope="col">Actividad</th>
                                                <th scope="col">Responsable</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>MÁQUINAS</td>
                                                <td>
                                                    <textarea class="form-control" name="actividad1" id="actividad1" cols="30" rows="3" placeholder="Actividad"></textarea>
                                                </td>
                                                <td><input type="text" name="responsable1" id="responsable1" class="form-control"
                                                        placeholder="Responsable"></td>
                                            </tr>
                                            <tr>
                                                <td>ENSAMBLE</td>
                                                <td>
                                                    <textarea class="form-control" name="actividad2" id="actividad2" cols="30" rows="3" placeholder="Actividad"></textarea>
                                                </td>
                                                <td><input type="text" name="responsable2" id="responsable2" class="form-control"
                                                        placeholder="Responsable"></td>
                                            </tr>
                                            <tr>
                                                <td>LIJA</td>
                                                <td>
                                                    <textarea class="form-control" name="actividad3" id="actividad3" cols="30" rows="3" placeholder="Actividad"></textarea>
                                                </td>
                                                <td><input type="text" name="responsable3" id="responsable3" class="form-control"
                                                        placeholder="Responsable"></td>
                                            </tr>
                                            <tr>
                                                <td>PINTURA</td>
                                                <td>
                                                    <textarea class="form-control" name="actividad4" id="actividad4" cols="30" rows="3" placeholder="Actividad"></textarea>
                                                </td>
                                                <td><input type="text" name="responsable4" id="responsable4" class="form-control"
                                                        placeholder="Responsable"></td>
                                            </tr>
                                            <tr>
                                                <td>EMPAQUE</td>
                                                <td>
                                                    <textarea class="form-control" name="actividad5" id="actividad5" cols="30" rows="3" placeholder="Actividad"></textarea>
                                                </td>
                                                <td><input type="text" name="responsable5" id="responsable5" class="form-control"
                                                        placeholder="Responsable"></td>
                                            </tr>
                                            <tr>
                                                <td>TAPICERIA</td>
                                                <td>
                                                    <textarea class="form-control" name="actividad6" id="actividad6" cols="30" rows="3" placeholder="Actividad"></textarea>
                                                </td>
                                                <td><input type="text" name="responsable6" id="responsable6" class="form-control"
                                                        placeholder="Responsable"></td>
                                            </tr>
                                            <tr>
                                                <td>DISEÑO</td>
                                                <td>
                                                    <textarea class="form-control" name="actividad7" id="actividad7" cols="30" rows="3" placeholder="Actividad"></textarea>
                                                </td>
                                                <td><input type="text" name="responsable7" id="responsable7" class="form-control"
                                                        placeholder="Responsable"></td>
                                            </tr>
                                            <tr>
                                                <td>PRODUCCIÓN</td>
                                                <td>
                                                    <textarea class="form-control" name="actividad8" id="actividad8" cols="30" rows="3" placeholder="Actividad"></textarea>
                                                </td>
                                                <td><input type="text" name="responsable8" id="responsable8" class="form-control"
                                                        placeholder="Responsable"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="button">
                        <button type="button" id="btn-enviar-informacion-cambios" onclick="enviarInformacionCambioSerie('formulario-cambio-series');"
                            class="btn btn-block btn-danger">Enviar Información</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $('input[type=checkbox]').on('change', function() {
            if ($(this).is(':checked')) {
                document.getElementById('input-cargar-imagenes-formato').hidden = false;
            } else {
                document.getElementById('input-cargar-imagenes-formato').hidden = true;
            }
        });

        function enviarInformacionCambioSerie(form) {
            var f = $(this);
            $('#btn-enviar-informacion-cambios').attr('disabled', true);
            var formData = new FormData(document.getElementById(form));
            formData.append('dato', 'valor');
            toastr.info('Generando documento ...');
            var datos = $.ajax({
                url: "{{ route('guardar.cambios') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                if (res.status == true) {
                    toastr.success('Email enviado correctamente');
                    document.getElementById(form).reset();
                    $('#btn-enviar-informacion-cambios').attr('disabled', false);
                }
            });
            datos.fail(() => {
                toastr.error('ERROR: Verifica la información y vuelve a intentar');
                $('#btn-enviar-informacion-cambios').attr('disabled', false);
            });
        }
    </script>
@endsection
