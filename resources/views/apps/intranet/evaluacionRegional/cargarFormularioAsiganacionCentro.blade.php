<form id="asignarCentroOperacion">
    <div class="col-12 col-md-12 d-flex-justify-content-center">
        <div class="col-12 col-md-12">
            <div class="form-group col-12">
                <label for="">Seleccionar coordinador:</label>
                <select class="form-control form-control-sm" id="idCoordinador" name="idCoordinador">
                    <option value="">Seleccione el coordinador</option>
                    @foreach ($coordinadores as $coordinador)
                        <option value="{{ $coordinador->id }}">{{ $coordinador->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-12">
                <label for="">Seleccionar centro operacion:</label>
                <select class="form-control form-control-sm" id="idCentroOperacion" name="idCentroOperacion">
                    <option>Seleccione centro de Operacion</option>
                    @foreach ($centrosOperaciones as $centroOperacion)
                        <option value="{{ $centroOperacion->id }}">{{ $centroOperacion->centro_operacion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-12">
                <label for="">Seleccione quien evalua el departamento de ventas:</label>
                <select class="form-control form-control-sm" id="idEvaluador" name="idEvaluador">
                    <option>Seleccionar evaluador</option>
                    <option value="38670577">ORREGO TABARES MARIA DEL PILAR</option>
                    <option value="52444253">SANDRA GONZALEZ</option>
                </select>
            </div>
        </div>
    </div>
</form>
