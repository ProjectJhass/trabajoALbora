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
        $color = $item->estado == 'Completado' ? 'green' : 'red';
    @endphp
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title collapse-link" style="cursor: pointer">
                <h2 class="red mr-2">{{ $item->pieza }}</h2>
                <h2 class="mr-2">-</h2>
                <h2 class="{{ $color }}" id="estadoWood{{ $bandera }}">{{ $item->estado }}</h2>
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
                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                            <label for="">Troncos planeados</label>
                            <button class="btn btn-block btn-warning" onclick="visualizarTroncosPlan('{{ $item->id }}')">Tronco</button>
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                            <label for="">Troncos utilizados</label>
                            <button class="btn btn-block btn-danger" onclick="visualizarTroncosUtilizados('{{ $item->id }}')">Tronco</button>
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
                            <label for="">Cantidad actual</label>
                            <input type="number" readonly value="{{ $item->cantidad_cortada }}" id="cantidadActual{{ $bandera }}" readonly
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
