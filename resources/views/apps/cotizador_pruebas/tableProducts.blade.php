<table class="table table-bordered" id="productos-liquidador-albura">
    <thead>
        <tr style="font-size: 13px">
            <th>Sku</th>
            <th>Producto</th>
            <th>Cant.</th>
            <th>Precio/U</th>
            <th>Valor total</th>
            <th>Dsto</th>
            <th>Dsto adicional</th>
            <th>Vlr descontado</th>
            <th>Total a pagar</th>
            <th>Accion</th>
        </tr>
    </thead>
    <tbody class="text-center" style="font-size: 14px">
        @foreach ($productos as $value)
            <?php
            $vlr_total_p = $value->vlr_credito * $value->cantidad;
            $vlr_descontado = $value->vlr_credito * $value->cantidad * ($value->descuento / 100);
            $vlr_desc_add = ($vlr_total_p - $vlr_descontado) * ($value->dsto_adicional / 100);
            ?>
            <tr>
                <td>{{ $value->sku }}</td>
                <td class="text-left">{{ $value->producto }}</td>
                <td>
                    <input type="text" value="{{ $value->cantidad }}"
                        onchange="ActualizarProductoCotizado('{{ $value->id_cotizacion }}')"
                        style="max-width: 40px" name="cantidad{{ $value->id_cotizacion }}" id="cantidad{{ $value->id_cotizacion }}">
                </td>
                <td>$ {{ number_format($value->vlr_credito) }}</td>
                <td>$ {{ number_format($vlr_total_p) }}</td>
                <td>
                    <input type="text" value="{{ $value->descuento }}" class="dsto_n"
                        onchange="ActualizarProductoCotizado('{{ $value->id_cotizacion }}')"
                        style="max-width: 40px" name="descuento{{ $value->id_cotizacion }}" id="descuento{{ $value->id_cotizacion }}"
                        {{ $value->plan != 'CO' ? 'disabled' : '' }}>%
                </td>
                <td>
                    <input type="text" class="vlr_add_class" value="{{ $value->dsto_adicional }}"
                        onchange="ActualizarProductoCotizado('{{ $value->id_cotizacion }}')"
                        style="max-width: 40px" name="dsto_ad{{ $value->id_cotizacion }}" id="dsto_ad{{ $value->id_cotizacion }}"> %
                </td>
                <td>$ {{ number_format($vlr_descontado + $vlr_desc_add) }}</td>
                <td>$ {{ number_format($vlr_total_p - $vlr_descontado - $vlr_desc_add) }}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="EliminarProductoCotizado('{{ $value->id_cotizacion }}')"><i
                                class="fas fa-trash"></i></button>
                    </div>
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
