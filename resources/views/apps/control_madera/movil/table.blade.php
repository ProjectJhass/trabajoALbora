<table class="table table-bordered table-hover">
    <thead class="text-center">
        <tr>
            <th>#</th>
            <th>Dispositivo</th>
            <th>Token</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach ($moviles as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td id="celularEdit{{ $item->id }}" hidden>
                    <input type="text" value="{{ $item->celular }}" class="form-control" name="movil{{ $item->id }}" id="movil{{ $item->id }}">
                </td>
                <td id="celular{{ $item->id }}">{{ $item->celular }}</td>
                <td id="tokenEdit{{ $item->id }}" hidden>
                    <input type="text" value="{{ $item->clave }}" class="form-control" name="token{{ $item->id }}"
                        id="token{{ $item->id }}">
                </td>
                <td id="tokenT{{ $item->id }}">{{ $item->clave }}</td>
                <td id="buttons{{ $item->id }}" hidden>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-sm btn-danger" onclick="closeEdit('{{ $item->id }}')"><i
                                class="fas fa-times"></i></button>
                        <button type="button" class="btn btn-sm btn-success" onclick="editarInfoTokenMovil('{{ $item->id }}')"><i
                                class="fas fa-check"></i></button>
                    </div>
                </td>
                <td id="options{{ $item->id }}">
                    <div class="btn-group dropstart">
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Acciones
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><button class="dropdown-item" onclick="openEdit('{{ $item->id }}')">Editar</button></li>
                            <li><button class="dropdown-item" onclick="eliminarInfoMovil('{{ $item->id }}')">Eliminar</button></li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
