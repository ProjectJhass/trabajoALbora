<div class="mt-4 table-responsive text-nowrap">
    <table class="table table-striped" id="tableStSolicitadosWeb">
        <thead>
            <tr>
                <th>Ticket</th>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>categoría</th>
                <th>Almacen</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($ost as $item)
                <tr onclick="visualizarInfoStPw('{{ $item->id_ost }}')" style="cursor: pointer" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasStart" aria-controls="offcanvasStart">
                    <td><span class="badge rounded-pill bg-warning" id="tbl-ticket{{ $item->id_ost }}">{{ $item->n_ticket }}</span></td>
                    <td id="tbl-id-cedula{{ $item->id_ost }}">{{ $item->cedula_cliente }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->articulo }}</td>
                    <td id="tbl-id-almacen{{ $item->id_ost }}">{{ $item->almacen }}</td>
                    <td>{{ $item->fecha }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
