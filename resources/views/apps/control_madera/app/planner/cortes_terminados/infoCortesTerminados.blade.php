@extends('apps.control_madera.plantilla.app')
@section('head')
    <style>
        .ui-pnotify-fade-normal {
            top: 36px !important;
        }
    </style>
@endsection
@section('p.corte.terminado')
    active
@endsection
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="card alert-top" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header">
                    <h5>Series</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="background-color: #f5f5f5"><strong>Serie</strong></span>
                                        <input type="text" value="{{ $planner->mueble . ' ' . $planner->serie . ' ' . strtoupper($planner->madera) }}"
                                            readonly class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="background-color: #f5f5f5"><strong>Cantidad</strong></span>
                                        <input type="text" value="{{ $planner->cantidad }}" readonly class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="background-color: #f5f5f5"><strong>Pulgadas solicitadas</strong></span>
                                        <input type="text" value="{{ $planner->pulgadas_solicitadas }}" readonly class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="background-color: #f5f5f5"><strong>Pulgadas cortadas</strong></span>
                                        <input type="text" value="{{ $planner->pulgadas_cortadas }}" readonly class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="background-color: #f5f5f5"><strong>Pulgadas no utilizadas</strong></span>
                                        <input type="text" value="{{ $planner->pulgadas_no_utilizadas }}" readonly class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="background-color: #f5f5f5"><strong>Cantidad real a retirar</strong></span>
                                        <input type="text" value="{{ $planner->pulgadas_cortadas - $planner->pulgadas_no_utilizadas }}" readonly
                                            class="form-control">
                                    </div>
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
            <div class="card alert-top alert-danger" data-aos="fade-up" data-aos-delay="300">
                <div class="card-header">
                    <h5>Piezas</h5>
                </div>
                <div class="card-body">
                    @php
                        $bandera = 1;
                    @endphp
                    @foreach ($piezas as $item)
                        @php
                            $color = $item->estado == 'Completado' ? 'success' : 'danger';
                        @endphp
                        <div class="bd-example mb-4">
                            <div class="accordion" id="accordionPlanner{{ $bandera }}">
                                <div class="accordion-item">
                                    <h4 class="accordion-header" id="headingPlanner{{ $bandera }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#PlannerM{{ $bandera }}" aria-expanded="false"
                                            aria-controls="PlannerM{{ $bandera }}">
                                            {{ $item->pieza }} - <span class="text-{{ $color }}" id="estadoWood{{ $bandera }}">
                                                {{ $item->estado }}</span>
                                        </button>
                                    </h4>
                                    <div id="PlannerM{{ $bandera }}" class="accordion-collapse collapse"
                                        aria-labelledby="headingPlanner{{ $bandera }}" data-bs-parent="#accordionPlanner{{ $bandera }}">
                                        <div class="accordion-body">

                                            <div class="row text-center">
                                                <div class="col-md-2 mb-3">
                                                    <label for="">Calidad</label>
                                                    <input type="text" value="{{ $item->calidad }}" readonly class="form-control"
                                                        style="text-align: center; background-color: #ffee00;">
                                                </div>
                                                <div class="col-md-1 mb-3">
                                                    <label for="">Largo</label>
                                                    <input type="text" value="{{ $item->largo }}" style="text-align: center;" readonly
                                                        class="form-control">
                                                </div>
                                                <div class="col-md-1 mb-3">
                                                    <label for="">Ancho</label>
                                                    <input type="text" readonly value="{{ $item->ancho }}" style="text-align: center;"
                                                        class="form-control">
                                                </div>
                                                <div class="col-md-1 mb-3">
                                                    <label for="">Grueso</label>
                                                    <input type="text" readonly value="{{ $item->grueso }}" style="text-align: center;"
                                                        class="form-control">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="">Cant. requerida</label>
                                                    <input type="text"
                                                        style="color: white !important; background-color: #248c32; text-align: center;" readonly
                                                        value="{{ $item->cantidad }}" class="form-control">
                                                </div>
                                                <div class="col-md-1 mb-3">
                                                    <label for="">Bloques</label><br>
                                                    <button class="btn btn-danger"
                                                        onclick="visualizarTroncosUtilizados('{{ $item->id }}')">Bloques</button>
                                                </div>
                                                <div class="col-md-1 mb-3">
                                                    <label for="">Comentarios</label><br>
                                                    <button class="btn btn-info" onclick="visualizarComentariosPorPieza('{{ $item->id }}')"><i
                                                            class="fa fa-comments"></i></button>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="">Cant. cortada</label>
                                                    <input type="text" style="text-align: center;" readonly value="{{ $item->cantidad_cortada }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $bandera++;
                        @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    {{-- Modal para visualizar los troncos planificados en el corte de madera. --}}

    <div class="modal fade" id="modalVisualizarTroncosPlanificados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
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
        <div class="modal-dialog modal-xl">
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
@endsection
@section('footer')
    <script>
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

        visualizarTroncosUtilizados = (id_pieza) => {
            $("#modalVisualizarTroncosPlanificados").modal("show")

            var datos = $.ajax({
                url: "{{ route('get.info.troncos.utili') }}",
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
    </script>
@endsection
