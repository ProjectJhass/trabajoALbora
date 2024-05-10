<table class="table table-sm table-striped" id="tableInfoCargueDigitalizacion">
    <thead>
        <tr>
            <th>#</th>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Cuenta</th>
            <th>Almacen</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>
        @php
            $bandera = 0;
        @endphp
        @foreach ($info as $item)
            @if (strtolower($item[0]) != 'cedula' && !empty($item[0]))
                @php
                    $bandera++;
                @endphp
                <tr>
                    <td>{{ $bandera }}</td>
                    <td>{{ $item[0] }}</td>
                    <td>{{ $item[1] }}</td>
                    <td>{{ $item[2] }}</td>
                    <td>{{ $item[3] }}</td>
                    <td>{{ $item[4] }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
