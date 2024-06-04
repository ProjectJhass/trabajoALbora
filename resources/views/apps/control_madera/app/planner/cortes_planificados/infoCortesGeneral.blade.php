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
@section('p.corte.proceso')
    active
@endsection
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="card" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header">
                    <h5>Series</h5>
                </div>
                <div class="card-body">
                    {!! $series_cortes !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card" data-aos="fade-up" data-aos-delay="300">
                <div class="card-header">
                    <h5>Piezas</h5>
                </div>
                <div class="card-body">
                    {!! $piezas_series_planeadas !!}
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
