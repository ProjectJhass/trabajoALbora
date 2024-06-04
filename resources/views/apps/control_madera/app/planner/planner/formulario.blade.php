@php
    $ban = 1;
@endphp
@foreach ($data_piezas as $key => $value)
    @php

        $largo = str_replace(',', '.', $value->largo) + 1;
        $ancho = str_replace(',', '.', $value->ancho) + 1;
        $grueso = str_replace(',', '.', $value->grueso) + 1;

        $cantidad_p = $value->cantidad_pieza;
        $cantidad_requerida = round($cantidad_p * $cantidad);
        $cantidad_requerida_r = round($cantidad_p * $cantidad);

        $cantidad_fav = 0;

        $id_pieza = $value->id;
        $cantidad_favor = ModelCantidadesFavor::where('id_pieza', $id_pieza)->where('estado', 'Pendiente')->first();
        if ($cantidad_favor) {
            $cantidad_fav = $cantidad_favor->cantidad;
            if ($cantidad_fav >= $cantidad_requerida) {
                $cantidad_requerida = 0;
            } else {
                $cantidad_requerida = $cantidad_requerida - $cantidad_fav;
            }
        } else {
            $cantidad_requerida = $cantidad_requerida;
        }

        $troncos = ModelConsecutivosMadera::where('estado', 'Activo')->where('id_info_madera', $id_madera)->get();
    @endphp
    <div class="bd-example mb-4">
        <div class="accordion" id="accordionPlanner{{ $ban }}">
            <div class="accordion-item">
                <h4 class="accordion-header" id="headingPlanner{{ $ban }}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePlanner{{ $ban }}"
                        aria-expanded="true" aria-controls="collapsePlanner{{ $ban }}">
                        ' . $value->pieza . '
                    </button>
                    <input hidden type="text" value="' . $value->pieza . '" name="name_pieza_planner{{ $ban }}"
                        id="name_pieza_planner{{ $ban }}">
                    <input hidden type="text" value="' . $value->id . '" name="id_pieza_planner{{ $ban }}"
                        id="id_pieza_planner{{ $ban }}">
                </h4>
                <div id="collapsePlanner{{ $ban }}" class="accordion-collapse collapse show"
                    aria-labelledby="headingPlanner{{ $ban }}" data-bs-parent="#accordionPlanner{{ $ban }}">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-1 mb-3">
                                <div class="form-group">
                                    <label class="text-danger">Calidad</label>
                                    <select class="form-control" name="calidad_corte{{ $ban }}" id="calidad_corte{{ $ban }}">
                                        <option value=""></option>
                                        <option value="Excelente">Excelente</option>
                                        <option value="Buena">Buena</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1 mb-3">
                                <div class="form-group">
                                    <label for="">Largo</label>
                                    <input type="text" class="form-control" style="background-color: #e3e3e3; text-align: center;"
                                        value="{{ $largo }}" name="largo_pieza{{ $ban }}" id="largo_pieza{{ $ban }}">
                                </div>
                            </div>
                            <div class="col-md-1 mb-3">
                                <div class="form-group">
                                    <label for="">Ancho</label>
                                    <input type="text" class="form-control" style="background-color: #e3e3e3; text-align: center;"
                                        value="{{ $ancho }}" name="ancho_pieza{{ $ban }}" id="ancho_pieza{{ $ban }}">
                                </div>
                            </div>
                            <div class="col-md-1 mb-3">
                                <div class="form-group">
                                    <label for="">Grueso</label>
                                    <input type="text" class="form-control" style="background-color: #e3e3e3; text-align: center;"
                                        value="{{ $grueso }}" name="grueso_pieza{{ $ban }}" id="grueso_pieza{{ $ban }}">
                                </div>
                            </div>
                            <div class="col-md-1 mb-3">
                                <div class="form-group">
                                    <label for="">Cant requerida</label>
                                    <input type="text" hidden class="form-control" value="{{ $cantidad_requerida_r }}"
                                        name="cantidad_pieza_r{{ $ban }}"
                                        style="color: white; background-color: #248c32; text-align: center;"
                                        id="cantidad_pieza_r{{ $ban }}">
                                    <input type="text" class="form-control" value="{{ $cantidad_requerida }}"
                                        name="cantidad_pieza{{ $ban }}" style="color: white; background-color: #248c32; text-align: center;"
                                        id="cantidad_pieza{{ $ban }}">
                                    <span>A favor: {{ $cantidad_fav }}</span>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label class="text-danger">Largo del bloque<small></small></label>
                                    <select class="form-control" onchange="consultarPulgadasRequeridas('{{ $ban }}',this.value)"
                                        name="largo_bloque{{ $ban }}" id="largo_bloque{{ $ban }}">
                                        <option value=""></option>
                                        @foreach ($arrayRango as $key => $value)
                                            <option value="{{ $value['clave'] }}">{{ $value['valor'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1 mb-3">
                                <div class="form-group">
                                    <label for="">Pulgadas total</label>
                                    <input type="text" class="form-control" onchange="buscarTroncosObjetivos('{{ $ban }}',this.value)"
                                        style="background-color: #e3e3e3; text-align: center;" name="pulgadas_utilizadas{{ $ban }}"
                                        id="pulgadas_utilizadas{{ $ban }}">
                                    <span>Suma: <span class="badge badge-pill bg-danger" id="sumPulg{{ $ban }}">0</span></span>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label class="text-danger">Bloque</label>
                                    <select id="troncos{{ $ban }}" name="troncos{{ $ban }}"
                                        onchange="troncoSeleccionado('{{ $ban }}', this.value)" class="form-control">
                                        <option value=""></option>
                                        @foreach ($troncos as $key => $value)
                                            <option
                                                value="{{ $value->id }} - {{ number_format($value->pulgadas) }}″ {{ $value->tipo_madera }}">
                                                {{ $value->id }} - {{ number_format($value->pulgadas) }}″ {{ $value->tipo_madera }}</option>;
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control" hidden name="troncoNum{{ $ban }}"
                                        id="troncoNum{{ $ban }}">
                                    <div id="troncos_selected{{ $ban }}"></div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label class="text-danger">Observaciones</label>
                                    <textarea class="form-control" name="obs_plan_generado{{ $ban }}" id="obs_plan_generado{{ $ban }}" cols="30"
                                        rows="1"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $ban++;
    @endphp
@endforeach
<center><button type="button" onclick="CrearPlanCorteMadera()" name="btnCantTotal" id="btnCantTotal" value="{{ $ban }}"
        class="btn btn-danger">Guardar Planificación</button></center>
