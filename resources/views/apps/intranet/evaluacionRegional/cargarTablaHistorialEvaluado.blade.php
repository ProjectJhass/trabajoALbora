<table class="table table-bordered table-sm  text-center"  id="evaluacionesTabla"  style="font-size: 13px">
    <thead class="bg-danger">
        <th class="text-center">Coordinador</th>
        <th class="text-center">CO</th>
        <th class="text-center">Enero</th>
        <th class="text-center">Febrero</th>
        <th class="text-center">Marzo</th>
        <th class="text-center">Abril</th>
        <th class="text-center">Mayo</th>
        <th class="text-center">Junio</th>
        <th class="text-center">Julio</th>
        <th class="text-center">Agosto</th>
        <th class="text-center">Septiembre</th>
        <th class="text-center">Octubre</th>
        <th class="text-center">Noviembre</th>
        <th class="text-center">Diciembre</th>
    </thead>
    <tbody>
        @foreach ($datos as $item)
            @foreach ($item['centros'] as $index => $centro)
                <tr>
                    @if ($index === 0)
                        <td rowspan="{{ count($item['centros']) }}" class="coordinador-cell">
                            {{ $item['coordinador'] }}
                        </td>
                    @endif
                    <td>
                        {{ $centro->centro_operacion }}
                    </td>
                    @foreach ($centro->resultado as $resultado)
                    <td>
                        @if ($resultado['resultado'])
                            <i class="fas fa-check"></i>
                        @endif
                    </td>
                    @endforeach
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

<style>
    td.coordinador-cell {
        text-align: center;
        vertical-align: middle;
    }
</style>
