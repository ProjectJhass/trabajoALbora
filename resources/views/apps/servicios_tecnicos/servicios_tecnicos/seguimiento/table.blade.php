<table class="table table-striped" id="tableSeguimientoGeneralAdmin">
    <thead>
        <tr>
            <th>Id</th>
            <th>Cliente</th>
            <th>Item</th>
            <th>Co</th>
            <th>Concepto</th>
            <th>Estado</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>
                    <button type="button" class="btn btn-sm btn-danger text-nowrap" data-bs-toggle="popover" data-bs-offset="0,14" data-bs-placement="top"
                        data-bs-html="true"
                        data-bs-content="<div class='d-flex justify-content-center'><button type='button' class='btn btn-sm btn-warning' onclick='btnEliminarSTAdmin({{ $item->id_st }})' id='btnEliminarSTAdmin{{ $item->id_st }}'>Anular servicio técnico</button></div><br><p><small>{{ $item->inconveniente }}</small></p>"
                        title="<small><strong>En: </strong>{{ $item->proceso }}</small>">
                        {{ $item->id_st }}
                    </button>
                </td>
                <td>{{ $item->nombre }}</td>
                <td>{{ $item->articulo }}</td>
                <td>{{ $item->almacen }}</td>
                <td>{{ $item->respuesta_st }}</td>
                <td>{{ $item->estado }}</td>
                <td>{{ $item->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>