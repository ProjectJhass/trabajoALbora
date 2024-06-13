<table class="table table-bordered table-hover">
    <thead class="text-center">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Código</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach ($info as $item)
            <tr>
                <td id="id{{ $item->id }}">{{ $item->id }}</td>
                <td id="nombre{{ $item->id }}" class="text-start">{{ $item->nombre }}</td>
                <td id="codigo{{ $item->id }}">{{ $item->codigo }}</td>
                <td id="estado{{ $item->id }}">{{ $item->estado }}</td>
                <td><button class="btn btn-sm btn-danger" onclick="editarInformacionCodigos('{{ $item->id }}')">Editar</button></td>
            </tr>
        @endforeach
    </tbody>
</table>
