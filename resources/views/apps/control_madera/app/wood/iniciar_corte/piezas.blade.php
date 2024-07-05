@extends('apps.control_madera.plantilla.app')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/botonFlotante.css') }}">
    <style>
        .ui-pnotify-fade-normal {
            top: 36px !important;
        }
    </style>
@endsection
@section('wood')
    active
@endsection
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="card alert-top">
                <div class="card-header">
                    <h5>Serie</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group row">
                                <label class="col-form-label col-md-3 col-sm-3 "><strong>Mueble</strong></label>
                                <div class="col-md-9 col-sm-9 ">
                                    <input type="text" value="{{ $planner->mueble }}" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group row">
                                <label class="col-form-label col-sm-3 "><strong>Serie</strong></label>
                                <div class="col-md-9 col-sm-9 ">
                                    <input type="text" value="{{ $planner->serie }}" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group row">
                                <label class="col-form-label col-sm-3"><strong>Madera</strong></label>
                                <div class="col-md-9 col-sm-9 ">
                                    <input type="text" value="{{ $planner->madera }}" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group row">
                                <label class="col-form-label col-md-3 col-sm-3"><strong>Cantidad</strong></label>
                                <div class="col-md-9 col-sm-9 ">
                                    <input type="text" value="{{ $planner->cantidad }}" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card alert-top alert-danger">
                <div class="card-header">
                    <h5>Lista de piesas</h5>
                </div>
                <div class="card-body">
                    <div class="row" id="piezas-planificadas-corte-wood">
                        {!! $piezas_corte !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para visualizar los troncos planificados en el corte de madera. --}}

    <div class="modal fade" id="modalVisualizarTroncosPlanificados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Consecutivos de bloques</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="listaTroncosPlanificados"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para visualizar los comentarios realizados para el corte --}}
    <div class="modal fade" id="modalObservacionesPiezasWood" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Observaciones para el corte</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 class="mt-3 mr-3 ml-3 mb-3" id="observacionesWoodPieza"></h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para agregar piezas adicionales a otra serie por sobrante --}}
    <div class="modal fade" id="modalNuevasPiezasWood" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar piezas a otra serie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box">
                                <form class="was-validated">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3 ">Serie </label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <select name="serie_planner" id="serie_planner" onchange="searchInfoMadera(this.value)"
                                                        class="form-control" required>
                                                        <option value="">Seleccionar...</option>
                                                        @foreach ($series as $item)
                                                            <option value="{{ $item->id_serie }}">{{ $item->serie }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-3 ">Madera </label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <select name="madera_planner" id="madera_planner" onchange="searchInfoMueble(this.value)"
                                                        class="form-control" required>
                                                        <option value="">Seleccionar...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-3">Mueble </label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <select name="mueble_planner" onchange="buscarInformacionPiezasActualizar()" id="mueble_planner"
                                                        class="form-control" required>
                                                        <option value="">Seleccionar...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="ln_solid"></div>
                                <form id="formPiezasAsignacionCantidadFavor" class="was-validated"></form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para registrar las tablas que salieron del corte de la serie --}}
    <div class="modal fade" id="modalRegistroTablasWood" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar tablas de la serie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row p-5">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label><strong>Cantidad</strong></label>
                                <input type="number" class="form-control is-invalid" style="text-align: center" name="AddtablaWood"
                                    id="AddtablaWood">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label><strong>Ancho </strong>- Centímetros</label>
                                <input type="number" class="form-control is-invalid" style="text-align: center" name="AddAnchoWood"
                                    id="AddAnchoWood">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h6>Tablas agregadas: <span id="cantTablasSerie">{{ $cant_tablas }}</span></h6>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" onclick="saveTablasCortesWood()">Agregar registro tabla</button>
                </div>
            </div>
        </div>
    </div>
    @if (str_contains('Vaquera', $planner->madera))
        <a style="cursor: pointer;" class="btn-flotante text-white" onclick="$('#modalRegistroTablasWood').modal('show')">+ Madera</a>
    @else
        <a style="cursor: pointer;" class="btn-flotante text-white" onclick="$('#modalNuevasPiezasWood').modal('show')">+ Madera</a>
    @endif
@endsection
@section('footer')
    <script>
        troncosUtilizadosWood = (valor, id, id_pieza) => {
            var elemento = document.querySelector(".ui-pnotify-fade-normal");
            if (elemento) {
                elemento.parentNode.removeChild(elemento);
            }
            var datos = $.ajax({
                url: "{{ route('add.tronco.woodmiser') }}",
                type: "post",
                dataType: "json",
                data: {
                    id_pieza,
                    tronco: valor
                }
            });
            datos.done((res) => {
                new PNotify({
                    title: 'Pulgadas: ' + res.pulgadas,
                    text: 'Tronco: ' + res.tronco,
                    hide: false,
                    type: 'success',
                    styling: 'bootstrap3',
                    addclass: 'info',
                })

                $('#troncos_utilizados_wood' + id).append('<span class="badge badge-pill bg-secondary" style="cursor:pointer" id="T' + id +
                    valor +
                    '" onclick="deleteTroncoWood(\'' + id + '\',\'' + valor + '\',\'' + id_pieza + '\')" >' + valor + '</span>\t')
                $("#troncoWood" + id).val('')
            })
            datos.fail(() => {
                notificacion("¡ERROR! Este bloque ya fue utilizado, utiliza otro", "error", 6000)
            })
        }

        agregarSeguimientoWood = (valor, id, id_pieza) => {
            var datos = $.ajax({
                url: "{{ route('add.piezas.woodmiser') }}",
                type: "post",
                dataType: "json",
                data: {
                    id_pieza,
                    cantidad: valor
                }
            });
            datos.done(function(response) {
                if (response.status == true) {
                    if (response.estado == "Completado") {
                        notificacion("¡Excelente! Cantidad de la pieza completada", "success", 3000)
                    }
                    $("#cantidadActual" + id).val(response.cantidad)
                    $("#agregarPiezasNuevas" + id).val(response.resta)
                    $("#estadoWood" + id).text(response.estado)
                    $("#estadoWood" + id).removeClass("text-danger")
                    $("#estadoWood" + id).addClass(response.clase)
                }
                if (response.status == false) {
                    notificacion(response.mensaje, "error", 5000)
                }
            })
        }

        deleteTroncoWood = (id, valor, id_pieza) => {
            document.getElementById("T" + id + valor).remove()
            var datos = $.ajax({
                url: "{{ route('delete.tronco.woodmiser') }}",
                type: "post",
                dataType: "json",
                data: {
                    id_pieza,
                    tronco: valor
                }
            });
        }

        visualizarTroncosPlan = (id_pieza, bandera) => {
            $("#modalVisualizarTroncosPlanificados").modal("show")

            var datos = $.ajax({
                url: "{{ route('getDataTables') }}",
                type: "post",
                dataType: "json",
                data: {
                    id_pieza,
                    bandera
                }
            });
            datos.done(function(response) {
                document.getElementById("listaTroncosPlanificados").innerHTML = response.table
                validarTroncoUtilizado(id_pieza, bandera)
            })
        }

        validarTroncoUtilizado = (id_pieza, bandera) => {
            var spans = $('#troncos_utilizados_wood' + bandera + ' span');
            spans.each(function() {
                $('#' + id_pieza + bandera + $(this).text()).remove();
            });
        }

        utilizarTroncoPLan = (consecutivo, bandera, id_corte) => {
            $("#modalVisualizarTroncosPlanificados").modal("hide")
            troncosUtilizadosWood(consecutivo, bandera, id_corte)
        }

        visualizarComentariosPorPieza = (id_pieza) => {
            $("#modalObservacionesPiezasWood").modal("show")

            var datos = $.ajax({
                url: "{{ route('getObsWood') }}",
                type: "post",
                dataType: "json",
                data: {
                    id_pieza
                }
            });
            datos.done(function(response) {
                document.getElementById("observacionesWoodPieza").innerHTML = response.obs
            })
        }

        buscarInformacionPiezasActualizar = () => {
            var serie = $("#serie_planner").val()
            var madera = $("#madera_planner").val()
            var mueble = $("#mueble_planner").val()

            var datos = $.ajax({
                url: "{{ route('getinfoPiezasFavor') }}",
                type: "post",
                dataType: "json",
                data: {
                    serie,
                    madera,
                    mueble
                }
            });
            datos.done(function(response) {
                document.getElementById("formPiezasAsignacionCantidadFavor").innerHTML = response.view
            })
        }

        savePiezasAFavorCorte = () => {
            notificacion("Agregando piezas a favor...", "info", 10000);
            var btnVal = $("#btnPiezasFavor").val()
            var formulario = new FormData(document.getElementById('formPiezasAsignacionCantidadFavor'));
            formulario.append('valor', btnVal);
            var datos = $.ajax({
                url: "{{ route('saveinfoPiezasFavor') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                notificacion("¡Piezas agregadas éxitosamente!", "success", 5000)
                $("#serie_planner").val('')
                $("#madera_planner").val('')
                $("#mueble_planner").val('')
                document.getElementById('formPiezasAsignacionCantidadFavor').innerHTML = ''
            })
        }

        saveTablasCortesWood = () => {
            var cant_tablas = $("#AddtablaWood").val()
            var ancho = $("#AddAnchoWood").val()

            var datos = $.ajax({
                url: window.location.href,
                type: "post",
                dataType: "json",
                data: {
                    cant_tablas,
                    ancho
                }
            });
            datos.done(function(res) {
                if (res.status == true) {
                    notificacion("¡Excelente! Tabla agregada con éxito", "success", 3000)
                    document.getElementById('cantTablasSerie').innerHTML = res.tablas
                    $("#AddtablaWood").val('')
                    $("#AddAnchoWood").val('')
                }
            })
        }
    </script>
@endsection
