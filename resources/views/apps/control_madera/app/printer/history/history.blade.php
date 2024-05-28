<table id="datatable" class="table table-bordered table-hover dataTable" aria-describedby="datatable_info">
    <thead class="text-center">
        <tr>
            <th>#</th>
            <th>Tipo de madera</th>
            <th>Cantidad bloques</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach ($data as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->madera }}</td>
                <td>{{ $item->total_bloques }}</td>
                <td>{{ $item->usuario_creacion }}</td>
                <td>{{ $item->created_at }}</td>
                <td>
                    @if (Auth::user()->rol == 1 || Auth::user()->rol == 2)
                        @if (Auth::user()->rol == 1)
                            <i class="fa fa-print" style="cursor: pointer" onclick="printInfoImpresiones('{{ $item->id }}')" title="Imprimir"></i>
                        @endif
                        <i class="fa fa-edit text-danger" style="cursor: pointer" onclick="EditInformacionEtiquetas('{{ $item->id }}')"
                            title="Editar"></i>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
