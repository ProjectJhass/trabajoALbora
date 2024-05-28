@php
    $ban = 0;
@endphp
@foreach ($data as $item)
    @php
        $ban++;
    @endphp
    <div class="bd-example mb-4">
        <div class="accordion" id="accordionPlanner{{ $ban }}">
            <div class="accordion-item">
                <h4 class="accordion-header" id="headingPlanner{{ $ban }}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePlanner{{ $ban }}"
                        aria-expanded="true" aria-controls="collapsePlanner{{ $ban }}">
                        {{ $item->pieza }}
                    </button>
                </h4>
                <div id="collapsePlanner{{ $ban }}" class="accordion-collapse collapse show"
                    aria-labelledby="headingPlanner{{ $ban }}" data-bs-parent="#accordionPlanner{{ $ban }}">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-2 mb-3" hidden>
                                <label for="">Id</label>
                                <input type="text" name="idPieza{{ $ban }}" id="idPieza{{ $ban }}" value="{{ $item->id }}"
                                    class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Pieza</label>
                                <input type="text" name="nombre{{ $ban }}" id="nombre{{ $ban }}" value="{{ $item->pieza }}"
                                    class="form-control">
                            </div>
                            <div class="col-md-1 mb-3">
                                <label for="">Cantidad</label>
                                <input type="number" name="cantidad{{ $ban }}" id="cantidad{{ $ban }}"
                                    value="{{ $item->cantidad_pieza }}" class="form-control">
                            </div>
                            <div class="col-md-1 mb-3">
                                <label for="">Largo</label>
                                <input type="number" name="largo{{ $ban }}" id="largo{{ $ban }}" value="{{ $item->largo }}"
                                    class="form-control">
                            </div>
                            <div class="col-md-1 mb-3">
                                <label for="">Ancho</label>
                                <input type="number" name="ancho{{ $ban }}" id="ancho{{ $ban }}" value="{{ $item->ancho }}"
                                    class="form-control">
                            </div>
                            <div class="col-md-1 mb-3">
                                <label for="">Grueso</label>
                                <input type="number" name="grueso{{ $ban }}" id="grueso{{ $ban }}" value="{{ $item->grueso }}"
                                    class="form-control">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="">Estado</label>
                                <select name="estado{{ $ban }}" id="estado{{ $ban }}" class="form-control">
                                    <option value="1" {{ $item->estado == 1 ? 'selected' : '' }}>Activo</option>
                                    <option value="0" {{ $item->estado == 0 ? 'selected' : '' }}>Inactivo</option>
                                    <option value="3">Eliminar</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
<input type="number" name="cantidadV" id="cantidadV" hidden value="{{ $ban }}" class="form-control">
<center>
    <button type="button" class="btn btn-danger" onclick="UpdateInfoPiezasSeries()">Actualizar información</button>
</center>
