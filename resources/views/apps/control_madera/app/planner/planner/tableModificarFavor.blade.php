<form id="tbl_cantidades_a_favor">

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
                    <input hidden value="{{ $item->id }}" name="item_id_{{ $bandera }}">
                    <td>{{ $item->largo }}</td>
                    <td>{{ $item->ancho }}</td>
                    <td>{{ $item->grueso }}</td>
                    <td id="txtCantDisponibleMadera{{ $bandera }}">{{ $item->cantidad }}</td>
                    <td class="txt_cantidad_requerida" id="txtCantidadRequeridaMadera{{ $bandera }}">
                        {{ $cantidad_pieza }}</td>
                    <td>
                        <input type="number"
                            onkeyup="actualizarCantidadPiezaPlanear(this.value, '{{ $consecutivo }}', '{{ $bandera }}')"
                            class="form-control input_cantidad_requerida_{{ $consecutivo }}"
                            name="cantidad_utilizar{{ $bandera }}" id="cantidad_utilizar{{ $bandera }}">
                    </td>
                </tr>
                @php
                    $bandera++;
                @endphp
            @endforeach
            <tr hidden>
                <td id="cantidad_ciclo">{{ $bandera - 1 }}</td>
                <td> <input name="cantidad_ciclo_maderas_" value="{{ $bandera - 1 }}" /></td>
            </tr>
        </tbody>
    </table>

</form>
