<style>
    .form-group {
        text-align: center
    }
</style>
@php
    $bandera = 1;
@endphp
@foreach ($piezas as $item)
    <div class="bd-example mb-4">
        <div class="accordion" id="accordionWood{{ $bandera }}">
            <div class="accordion-item">
                <h4 class="accordion-header" id="headingWood{{ $bandera }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWood{{ $bandera }}"
                        aria-expanded="true" aria-controls="collapseWood{{ $bandera }}">
                        {{ $item->pieza }} - <span class="text-danger" id="estadoWood{{ $bandera }}">{{ $item->estado }}</span>
                    </button>
                </h4>
                <div id="collapseWood{{ $bandera }}" class="accordion-collapse collapse" aria-labelledby="headingWood{{ $bandera }}"
                    data-bs-parent="#accordionWood{{ $bandera }}">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-1 mb-3">
                                <div class="form-group">
                                    <label for="">Calidad</label>
                                    <input type="text" value="{{ $item->calidad }}" readonly class="form-control"
                                        style="text-align: center; background-color: #ffee00;" />
                                </div>
                            </div>
                            <div class="col-md-1 mb-3">
                                <div class="form-group">
                                    <label for="">Largo <small>(cm)</small></label>
                                    <input type="text" value="{{ $item->largo }}" readonly class="form-control" style="text-align: center;" />
                                </div>
                            </div>
                            <div class="col-md-1 mb-3">
                                <div class="form-group">
                                    <label for="">Ancho <small>(cm)</small></label>
                                    <input type="text" value="{{ $item->ancho }}" readonly class="form-control" style="text-align: center;" />
                                </div>
                            </div>
                            <div class="col-md-1 mb-3">
                                <div class="form-group">
                                    <label for="">Grueso <small>(cm)</small></label>
                                    <input type="text" value="{{ $item->grueso }}" readonly class="form-control" style="text-align: center;" />
                                </div>
                            </div>
                            <div class="col-md-1 mb-3">
                                <div class="form-group">
                                    <label for="">Cantidad</label>
                                    <input type="number" id="cantidadRequeridaWood{{ $bandera }}" value="{{ $item->cantidad }}" readonly
                                        class="form-control" style="color: white !important; background-color: #248c32; text-align: center;" />
                                </div>
                            </div>
                            <div class="col-md-1 mb-3">
                                <div class="form-group">
                                    <label for="">Bloques</label>
                                    <button class="btn btn-block btn-danger"
                                        onclick="visualizarTroncosPlan('{{ $item->id }}', '{{ $bandera }}')">Tronco</button>
                                </div>
                            </div>
                            <div class="col-md-1 mb-3">
                                <div class="form-group">
                                    <label for="">Observaciones</label>
                                    <button class="btn btn-block btn-info" onclick="visualizarComentariosPorPieza('{{ $item->id }}')"><i
                                            class="fa fa-comments"></i></button>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label for="">Bloque a utilizar</label>
                                    <input type="number" name="troncoWood{{ $bandera }}" id="troncoWood{{ $bandera }}"
                                        onchange="troncosUtilizadosWood(this.value,'{{ $bandera }}', '{{ $item->id }}')"
                                        class="form-control" autocomplete="off" style="text-align: center;" />
                                    <div id="troncos_utilizados_wood{{ $bandera }}">
                                        @php
                                            $info_t = explode(',', $item->troncos_utilizados);
                                        @endphp
                                        @foreach ($info_t as $tronco)
                                            <span class="badge badge-pill bg-secondary" style="cursor:pointer" id="T{{ $bandera . $tronco }}"
                                                onclick="deleteTroncoWood('{{ $bandera }}','{{ $tronco }}','{{ $item->id }}')">{{ $tronco }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 mb-3">
                                <div class="form-group">
                                    <label for="">Cant. Actual</label>
                                    <input type="number" value="{{ $item->cantidad_cortada }}" id="cantidadActual{{ $bandera }}" readonly
                                        class="form-control" style="text-align: center;" />
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label for="">Agregar piezas</label>
                                    <input type="number" id="agregarPiezasNuevas{{ $bandera }}"
                                        onchange="agregarSeguimientoWood(this.value, '{{ $bandera }}', '{{ $item->id }}')"
                                        autocomplete="off" class="form-control" style="text-align: center;" />
                                </div>
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
