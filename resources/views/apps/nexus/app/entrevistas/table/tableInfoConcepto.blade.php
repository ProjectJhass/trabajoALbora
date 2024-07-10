<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Sede</th>
            <th>Nombre</th>
            <th>Edad</th>
            <th>Proceso</th>
            <th>Cargo</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($info as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->sede == 1 ? 'Fábrica' : 'Principal' }}</td>
                <td>{{ $item->nombre . ' ' . $item->apellidos }}</td>
                <td>{{ $item->edad }}</td>
                <td>{{ $item->proceso }}</td>
                <td>{{ $item->cargo_aspira }}</td>
                <td>{{ $item->estado }}</td>
                <td>{{ $item->fecha }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Acciones
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="{{ route('emitirConcepto.entrevista', ['id' => $item->id]) }}"><i
                                        class="fas fa-pencil-alt text-secondary"></i> Emitir concepto</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user-times"></i> Descartar</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-trash text-danger"></i> Eliminar</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
