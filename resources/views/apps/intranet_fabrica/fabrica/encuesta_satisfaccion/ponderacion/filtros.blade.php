<form action="" id="frm_filters_ponderacion_" class="was-validated">
    @csrf
    <hr>
    <div class="row d-flex justify-content-around animate__animated animate__flash">
        <div class="col-md-3 mb-3">
            <div class="form-group">
                <label for="">Proceso</label>
                <select name="filter_proceso_ponderacion" id="filter_proceso_ponderacion" class="form-control" required>
                    <option selected disabled value="">Seleccionar...</option>
                    @foreach ($procesos as $key => $value)
                        <option value="{{ $value->nombre_proceso }}">{{ $value->nombre_proceso }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <label for="">Fecha desde</label>
            <input type="date" class="form-control" name="filters_desde_ponderacion" id="filters_desde_ponderacion" required>
        </div>
        <div class="col-md-3 mb-3">
            <label for="">Fecha hasta</label>
            <input type="date" class="form-control" name="filters_hasta_ponderacion" id="filters_hasta_ponderacion">
        </div>
        <div class="col-md-3 mb-3 d-flex align-self-center">
            <button type="button" onclick="load_ponderacion_filters('frm_filters_ponderacion_')" class="btn btn-danger">Cargar</button>
        </div>
    </div>
</form>

<div id="load_ponderacion_encuesta_satisfaccion"></div>
