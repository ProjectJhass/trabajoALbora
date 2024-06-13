<table class="table table-bordered table-hover" id="tableInfoOpCreada">
    <thead class="text-center">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Cant</th>
            <th>Tipo</th>
            <th>Planificador</th>
            <th>OP</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($info as $item)
            <tr>
                <td class="text-center">{{ $item->id }}</td>
                <td>{{ $item->nombre }}</td>
                <td class="text-center">{{ $item->pulgadas }}</td>
                <td>{{ $item->tipo }}</td>
                <td>{{ $item->planificador }}</td>
                <td class="text-center">{{ $item->consecutivo_op }}</td>
                <td>{{ date('Y-m-d', strtotime($item->created_at)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
