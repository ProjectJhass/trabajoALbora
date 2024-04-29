<div class="mt-4 table-responsive text-nowrap">
    <table class="table table-striped" id="tableInfoUsuarios">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Almacen</th>
                <th>Empresa</th>
                <th>Rol</th>
                <th>Usuario</th>
                <th>Creado</th>
                <th>Actualizado</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($info as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->almacen }}</td>
                    <td>{{ $item->empresa }}</td>
                    <td>{{ $item->rol == 1 ? 'Admin' : 'General' }}</td>
                    <td>{{ $item->usuario }}</td>
                    <td>{{ date('Y-m-d', strtotime($item->created_at)) }}</td>
                    <td>{{ date('Y-m-d', strtotime($item->updated_at)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
