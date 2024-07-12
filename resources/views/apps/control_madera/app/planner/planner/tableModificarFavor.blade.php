<table class="table table-bordered table-striped table-sm">
    <thead>
        <tr class="text-center">
            <th>Largo</th>
            <th>Ancho</th>
            <th>Grueso</th>
            <th>Cantidad disponible</th>
            <th>Cantidad requerida</th>
            <th>Cantidad a utilizar</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @php
            $bandera = 1;
        @endphp
        @foreach ($info as $item)
            <tr>
                <td>{{ $item->largo }}</td>
                <td>{{ $item->ancho }}</td>
                <td>{{ $item->grueso }}</td>
                <td id="txtCantDisponibleMadera{{ $bandera }}">{{ $item->cantidad }}</td>
                <td id="txtCantidadRequeridaMadera{{ $bandera }}">{{ $cantidad_pieza }}</td>
                <td>
                    <input type="number" onkeyup="actualizarCantidadPiezaPlanear(this.value, '{{ $consecutivo }}', '{{ $bandera }}')" class="form-control"
                        name="cantidad_utilizar" id="cantidad_utilizar">
                </td>
            </tr>
            @php
                $bandera++;
            @endphp
        @endforeach
    </tbody>
</table>
