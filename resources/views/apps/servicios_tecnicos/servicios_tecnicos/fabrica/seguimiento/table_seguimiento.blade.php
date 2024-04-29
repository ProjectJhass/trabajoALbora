<div class="mt-4 table-responsive text-nowrap">
    <table class="table table-striped" id="tableStSolicitados">
        <thead>
            <tr>
                <th>Ost</th>
                <th>Solicitante</th>
                <th>Item</th>
                <th>CO</th>
                <th>Estado</th>
                <th>Creación</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($st as $item)
                <tr onclick="visualizarInfoServicioTecnico('{{ $item->id_st }}','fabrica')" style="cursor: pointer">
                    <td class="text-center">{{ $item->id_st }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->articulo }}</td>
                    <td>{{ $item->almacen }}</td>
                    <td><span class="badge bg-label-warning me-1">{{ $item->estado }}</span></td>
                    <td>{{ date('Y-m-d', strtotime($item->created_at)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- <div class="card">
    <h5 class="card-header">Ordenes pendientes por definir</h5>
    <div class="card-body table-responsive text-nowrap">

    </div>
</div> --}}
