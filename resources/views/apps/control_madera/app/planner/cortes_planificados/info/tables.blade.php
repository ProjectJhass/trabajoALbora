<style>
    .form-group {
        text-align: center
    }
</style>
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
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#PlannerM{{ $bandera }}"
                        aria-expanded="false" aria-controls="PlannerM{{ $bandera }}">
                        {{ $item->pieza }} - <span class="text-{{ $color }}" id="estadoWood{{ $bandera }}"> {{ $item->estado }}</span>
                    </button>
                </h4>
                <div id="PlannerM{{ $bandera }}" class="accordion-collapse collapse" aria-labelledby="headingPlanner{{ $bandera }}"
                    data-bs-parent="#accordionPlanner{{ $bandera }}">
                    <div class="accordion-body">

                        <div class="row text-center">
                            <div class="col-md-2 mb-3">
                                <label for="">Calidad</label>
                                <input type="text" value="{{ $item->calidad }}" readonly class="form-control"
                                    style="text-align: center; background-color: #ffee00;">
                            </div>
                            <div class="col-md-1 mb-3">
                                <label for="">Largo</label>
                                <input type="text" value="{{ $item->largo }}" style="text-align: center;" readonly class="form-control">
                            </div>
                            <div class="col-md-1 mb-3">
                                <label for="">Ancho</label>
                                <input type="text" readonly value="{{ $item->ancho }}" style="text-align: center;"  class="form-control">
                            </div>
                            <div class="col-md-1 mb-3">
                                <label for="">Grueso</label>
                                <input type="text" readonly value="{{ $item->grueso }}" style="text-align: center;"  class="form-control">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="">Cant. requerida</label>
                                <input type="text" style="color: white !important; background-color: #248c32; text-align: center;" readonly
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
                                <input type="text" style="text-align: center;"  readonly value="{{ $item->cantidad_cortada }}" class="form-control">
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
