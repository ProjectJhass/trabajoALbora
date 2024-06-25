<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>
                <input class="form-check-input" type="radio" name="impresion_realizada" id="impresion_realizada">
                <small>Utilizar</small>
            </th>
            <th>Id</th>
            <th>Madera</th>
            <th>total_bloques</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach ($data as $item)
            <tr>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" value="{{ $item->id }}" type="radio" name="impresion_realizada"
                            id="impresion_realizada{{ $item->id }}">
                    </div>
                </td>
                <td>{{ $item->id }}</td>
                <td>{{ $item->madera }}</td>
                <td>{{ $item->total_bloques }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
