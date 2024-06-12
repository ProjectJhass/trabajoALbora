<table id="datatableMadera" class="table table-hover table-bordered" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>Corte</th>
            <th>Cantidad</th>
            <th>Medida</th>
            <th>Cortador</th>
            <th>Fecha</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach ($info as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>Corte de tabla</td>
                <td>{{ $item->cantidad }}</td>
                <td>{{ $item->medida_grosor }}mm</td>
                <td>{{ $item->cortador }}</td>
                <td>{{ $item->created_at }}</td>
                <td><a href="{{ route('info.table.completado', ['id_corte' => $item->id]) }}" target="_BLANK" type="button" class="btn btn-danger btn-sm">Ver</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
