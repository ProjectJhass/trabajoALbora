<table class="table table-sm table-bordered table-striped" id="infoGeneralFirmasDescansos">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Almacen</th>
            <th>Dominical</th>
            <th>Descanso</th>
            <th>Fecha firma</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach ($info as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->cedula }}</td>
                <td class="text-left">{{ $item->nombre }}</td>
                <td>{{ $item->almacen }}</td>
                <td>{{ $item->dominical_laborado }}</td>
                <td>{{ $item->dia_compensatorio }}</td>
                <td>{{ $item->created_at }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-danger dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-eye"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('detalles.firmas', ['id' => $item->id]) }}">Visualizar</a>
                            <a class="dropdown-item" target="_BLANK" href="{{ route('generar.pdf.firma', ['id' => $item->id]) }}">Imprimir</a>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
