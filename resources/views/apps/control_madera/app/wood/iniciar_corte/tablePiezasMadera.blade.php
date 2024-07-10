<table class="table table-bordered table-striped table-sm">
    <thead>
        <tr class="text-center">
            <th>Largo</th>
            <th>Ancho</th>
            <th>Grueso</th>
            <th>Cantidad</th>
            <th>Madera</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach ($info as $item)
            <tr>
                <td>{{ $item->largo }}</td>
                <td>{{ $item->ancho }}</td>
                <td>{{ $item->grueso }}</td>
                <td>{{ $item->cantidad_inicial }}</td>
                <td>{{ $item->madera }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
