<table class="table card-body">
    <thead>
        <th>SKU</th>
        <th>articulo</th>
        <th>cantidad</th>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>{{ $item['id_item'] }}</td>
                <td>{{ $item['articulo'] }}</td>
                <td>{{ $item['total_cantidad'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
