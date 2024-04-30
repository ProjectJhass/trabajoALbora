@php
    $bandera = 1;
@endphp
@foreach ($data as $item)
    <div class="row">
        <div class="col-md-1 mb-3" hidden>
            <label for="">Id</label>
            <input type="text" class="form-control" value="{{ $item->id }}" name="idPieza{{ $bandera }}" id="idPieza{{ $bandera }}">
        </div>
        <div class="col-md-3 mb-3">
            <label for="">Pieza</label>
            <input type="text" class="form-control" value="{{ $item->pieza }}" readonly>
        </div>
        <div class="col-md-2 mb-3">
            <label for="">Largo <small>(cm)</small></label>
            <input type="text" class="form-control" value="{{ $item->largo }}" style="text-align: center" readonly>
        </div>
        <div class="col-md-2 mb-3">
            <label for="">Ancho <small>(cm)</small></label>
            <input type="text" value="{{ $item->ancho }}" class="form-control" style="text-align: center" readonly>
        </div>
        <div class="col-md-2 mb-3">
            <label for="">Grueso <small>(cm)</small></label>
            <input type="text" class="form-control" value="{{ $item->grueso }}" style="text-align: center" readonly>
        </div>
        <div class="col-md-3 mb-3">
            <label for="">Cant. de piezas a favor</label>
            <input type="number" class="form-control" name="piezasFavorNum{{ $bandera }}" style="text-align: center" id="piezasFavorNum{{ $bandera }}">
        </div>
    </div>
    @php
        $bandera++;
    @endphp
@endforeach

<center>
    <button type="button" name="btnPiezasFavor" id="btnPiezasFavor" onclick="savePiezasAFavorCorte()" value="{{ $bandera }}" class="btn btn-danger">Guardar Información</button>
</center>
