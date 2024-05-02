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
                        <h2>Información planeada</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" id="infoGeneralCortesSeries">
                        {!! $series_cortes !!}                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="piezas-planificadas-corte">
            {!! $piezas_series_planeadas !!}
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
@endsection
@section('footer')
    <script src="{{ asset('plugins/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('plugins/pnotify/dist/pnotify.buttons.js') }}"></script>
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
