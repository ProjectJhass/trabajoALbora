<table class="table table-bordered table-striped table-sm  text-center" id="HistorialPorAñosC" style="font-size: 13px">
    <thead class="bg-danger">
        <tr>
            <th>#</th>
            <th>Centro Operacion</th>
            <th>Estado</th>
            <th><i class="fas fa-cogs"></i></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($centrosOperaciones as $index => $centroOperacion)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $centroOperacion->centro_operacion }}</td>
                <td> <span id="estado{{ $centroOperacion->idCoAsignado }}">{{ $centroOperacion->estado }} </span></td>
                <td>
                    <div class="form-group">
                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox" class="custom-control-input"
                                id="customSwitch{{ $centroOperacion->idCoAsignado }}"
                                @if ($centroOperacion->estado == 'Activo') checked value="true" @else value="false" @endif
                                onclick="cambiarEstadoCentroAsignado('customSwitch{{ $centroOperacion->idCoAsignado }}', '{{ $centroOperacion->idCoAsignado }}', '{{ $centroOperacion->idCoordinador }}', '{{ $centroOperacion->idCentroOperacion }}')">
                            <label class="custom-control-label"
                                for="customSwitch{{ $centroOperacion->idCoAsignado }}"></label>
                        </div>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">No hay centros de operación disponibles</td>
            </tr>
        @endforelse
    </tbody>
</table>

