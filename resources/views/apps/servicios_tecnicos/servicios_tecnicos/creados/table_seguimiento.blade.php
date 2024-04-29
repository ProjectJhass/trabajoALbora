{{-- <div class="card">
    <h5 class="card-header">Ordenes de servicio técnico</h5>
    <div class="card-body table-responsive text-nowrap">

    </div>
</div> --}}
<div class="mt-4 table-responsive">
    <table class="table table-striped" id="tableStSolicitados">
        <thead>
            <tr>
                <th>Ost</th>
                <th>Cliente</th>
                <th>Item</th>
                <th>Proceso</th>
                {{-- <th>Estado</th> --}}
                <th>Concepto/Estado</th>
                <th>Co</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0 text-center" style="font-size: 13px">
            @foreach ($st as $item)
                <tr onclick="visualizarInfoServicioTecnico('{{ $item->id_st }}','st')" style="cursor: pointer">
                    <td class="align-middle">
                        <strong>{{ $item->id_st }}</strong>
                        <br>
                        {{-- <small><b>Fecha:</b></small> --}}
                        <small>{{ date('Y-m-d', strtotime($item->created_at)) }}</small>
                    </td>
                    <td>
                        <button type="button" class="btn btn-icon btn-outline-danger" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
                        data-bs-html="true" data-bs-original-title="<i class='bx bx-user' ></i> <span>{{ $item->nombre }}</span>">
                            <span class="tf-icons bx bx-user"></span>
                        </button>
                    </td>
                    {{-- <td class="text-start">{{ $item->nombre }}</td> --}}
                    <td class="text-start">{{ $item->articulo }}</td>
                    <td>{{ $item->proceso }}</td>
                    {{-- <td><span class="badge bg-label-warning me-1">{{ $item->estado }}</span></td> --}}
                    <td class="align-middle">
                        <span class="badge bg-label-info me-1">{{ $item->respuesta_st }}</span><br>
                        <span class="badge bg-label-warning me-1">{{ $item->estado }}</span>
                    </td>
                    <td class="align-middle">
                        {{ $item->almacen }}
                        <br>
                        <small>{{ str_contains($item->proveedor, 'ALBURA') ? 'ALBURA' : $item->proveedor }}</small>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
