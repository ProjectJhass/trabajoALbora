<table class="table table-striped" id="usuariosInfoFlayerTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Fecha</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($usuarios as $item)
            @php
                $estado = $item->id_estado == 0 ? '<span class="badge badge-pill badge-danger">'.$item->estado.'</span>' : '<span class="badge badge-pill badge-success">'.$item->estado.'</span>';
            @endphp
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->cedula }}</td>
                <td>{{ $item->nombre }}</td>
                <td>{{ $item->fecha }}</td>
                <td>@php echo $estado @endphp</td>
            </tr>
        @endforeach
    </tbody>
</table>
