<style>
    .form-group {
        text-align: center
    }
</style>
@php
    $bandera = 1;
@endphp
@foreach ($piezas as $item)
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title collapse-link" style="cursor: pointer">
                <h2 class="red mr-2">{{ $item->pieza }}</h2>
                <h2 class="mr-2">-</h2>
                <h2 class="red" id="estadoWood{{ $bandera }}">{{ $item->estado }}</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a>
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: none;">
                <div class="row">
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
                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                            <label for="">Cantidad requerida</label>
                            <input type="number" id="cantidadRequeridaWood{{ $bandera }}" value="{{ $item->cantidad }}" readonly
                                class="form-control" style="color: white; background-color: #248c32; text-align: center;" />
                        </div>
                    </div>
                    <div class="col-md-1 mb-3">
                        <div class="form-group">
                            <label for="">Troncos</label>
                            <button class="btn btn-block btn-danger" onclick="visualizarTroncosPlan('{{ $item->id }}')">Tronco</button>
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
                            <label for="">Tronco a utilizar</label>
                            <input type="number" name="troncoWood{{ $bandera }}" id="troncoWood{{ $bandera }}"
                                onchange="troncosUtilizadosWood(this.value,'{{ $bandera }}', '{{ $item->id }}')" class="form-control"
                                autocomplete="off" style="text-align: center;" />
                            <div id="troncos_utilizados_wood{{ $bandera }}">
                                @php
                                    $info_t = explode(',', $item->troncos_utilizados);
                                @endphp
                                @foreach ($info_t as $tronco)
                                    <span class="badge badge-pill badge-secondary" style="cursor:pointer" id="T{{ $bandera . $tronco . $item->id }}"
                                        onclick="deleteTroncoWood('{{ $bandera }}','{{ $tronco }}','{{ $item->id }}')">{{ $tronco }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 mb-3">
                        <div class="form-group">
                            <label for="">Cantidad actual</label>
                            <input type="number" value="{{ $item->cantidad_cortada }}" id="cantidadActual{{ $bandera }}" readonly
                                class="form-control" style="text-align: center;" />
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                            <label for="">Agregar piezas</label>
                            <input type="number" id="agregarPiezasNuevas{{ $bandera }}"
                                onchange="agregarSeguimientoWood(this.value, '{{ $bandera }}', '{{ $item->id }}')" autocomplete="off"
                                class="form-control" style="text-align: center;" />
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
