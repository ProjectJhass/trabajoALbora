<table id="datatable" class="table table-hover table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>IP</th>
            <th>Puerto</th>
            <th>Estado</th>
            <th>Conexión</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach ($info as $item)
            <tr style="cursor: pointer" onclick="searchInfoPrinter('{{ $item->id }}')">
                <td>{{ $item->id }}</td>
                <td class="text-left">{{ $item->nombre }} <br><small>Impresora: {{ $item->impresora }}</small></td>
                <td>{{ $item->ip }}</td>
                <td>{{ $item->puerto }}</td>
                <td>{{ $item->estado == 0 ? 'Inactivo' : 'En uso' }}</td>
                <td>{{ $item->conexion }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
