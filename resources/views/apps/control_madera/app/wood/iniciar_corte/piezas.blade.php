@extends('apps.control_madera.plantilla.app')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/pnotify/dist/pnotify.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/pnotify/dist/pnotify.buttons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/botonFlotante.css') }}">
    <style>
        .ui-pnotify-fade-normal {
            top: 36px !important;
        }
    </style>
@endsection
@section('body')
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Información a planear</h2>
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
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3 "><strong>Mueble</strong></label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" value="{{ $planner->mueble }}" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-3 "><strong>Serie</strong></label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" value="{{ $planner->serie }}" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-3"><strong>Madera</strong></label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" value="{{ $planner->madera }}" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3"><strong>Cantidad</strong></label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" value="{{ $planner->cantidad }}" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="piezas-planificadas-corte-wood">
            {!! $piezas_corte !!}
        </div>
    </div>

    {{-- Modal para visualizar los troncos planificados en el corte de madera. --}}

    <div class="modal fade" id="modalVisualizarTroncosPlanificados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Consecutivos de troncos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="listaTroncosPlanificados"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para visualizar los comentarios realizados para el corte --}}
    <div class="modal fade" id="modalObservacionesPiezasWood" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Observaciones para el corte</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="mt-3 mr-3 ml-3 mb-3" id="observacionesWoodPieza"></h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para agregar piezas adicionales a otra serie por sobrante --}}
    <div class="modal fade" id="modalNuevasPiezasWood" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Piezas a otra serie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box">
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
                                                <select name="madera_planner" id="madera_planner" onchange="searchInfoMueble(this.value)" disabled
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
                                                    class="form-control" required disabled>
                                                    <option value="">Seleccionar...</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <form id="formPiezasAsignacionCantidadFavor"></form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="btn-flotante" onclick="$('#modalNuevasPiezasWood').modal('show')">+ Madera</a>
@endsection
@section('footer')
    <script src="{{ asset('plugins/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('plugins/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script>
        troncosUtilizadosWood = (valor, id, id_pieza) => {
            var elemento = document.querySelector(".ui-pnotify-fade-normal");
            if (elemento) {
                elemento.parentNode.removeChild(elemento);
            }
            $('#troncos_utilizados_wood' + id).append('<span class="badge badge-pill badge-secondary" style="cursor:pointer" id="T' + id + valor +
                '" onclick="deleteTroncoWood(\'' + id + '\',\'' + valor + '\',\'' + id_pieza + '\')" >' + valor + '</span>\t')
            $("#troncoWood" + id).val('')
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
                    type: 'info',
                    styling: 'bootstrap3',
                    addclass: 'dark',
                })
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
                $("#cantidadActual" + id).val(response.cantidad)
                $("#agregarPiezasNuevas" + id).val(response.resta)
                $("#estadoWood" + id).text(response.estado)
                $("#estadoWood" + id).removeClass("red")
                $("#estadoWood" + id).addClass(response.clase)
            })
        }

        deleteTroncoWood = (id, valor, id_pieza) => {
            document.getElementById("T" + id + valor).remove()
        }

        visualizarTroncosPlan = (id_pieza) => {
            $("#modalVisualizarTroncosPlanificados").modal("show")

            var datos = $.ajax({
                url: "{{ route('getDataTables') }}",
                type: "post",
                dataType: "json",
                data: {
                    id_pieza
                }
            });
            datos.done(function(response) {
                document.getElementById("listaTroncosPlanificados").innerHTML = response.table
            })
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
    </script>
@endsection
