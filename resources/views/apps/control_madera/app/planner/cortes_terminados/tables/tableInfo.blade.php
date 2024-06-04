<table id="datatableMadera" class="table table-hover table-bordered" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>Serie</th>
            <th>Cantidad</th>
            <th>Planificador</th>
            <th>Fecha solicitada</th>
            <th>Fecha realizado</th>
            <th>Detalles</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach ($cortes as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td class="text-start">{{ $item->mueble . ' ' . $item->serie . ' ' . strtoupper($item->madera) }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>{{ $item->planificador }}</td>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->updated_at }}</td>
                <td><a href="{{ route('info.piezas.c.terminado', ['id_corte' => $item->id]) }}" class="btn btn-primary btn-sm">Ver</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
