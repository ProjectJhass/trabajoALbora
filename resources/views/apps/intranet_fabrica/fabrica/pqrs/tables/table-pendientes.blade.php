<table class="table table-striped table-bordered table-sm" id="solicitudes-pendientes">
    <thead>
        <tr class="text-center" style="background-color: #dc3646; color: white;">
            <th>N°</th>
            <th>Consecutivo</th>
            <th>Nombre</th>
            <th>Tipo solicitud</th>
            <th>Fecha de recepción</th>
            <th>Visualizar</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach ($data as $pqrs)
            @foreach ($pqrs as $value)
                <tr>
                    <td>{{ $value['id'] }}</td>
                    <td>{{ $value['consecutivo'] }}</td>
                    <td>{{ $value['nombres'] . ' ' . $value['apellidos'] }}</td>
                    <td>{{ $value['tipo_solicitud'] }}</td>
                    <td>{{ $value['estado'] }}</td>
                    <td>
                        <a href="{{route('show.detalle.pqrs', ['id'=>$value['consecutivo']])}}">
                            <button class="btn btn-outline-info">
                                <i class="fas fa-eye"></i>
                            </button>
                        </a>
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
<style>
    td,
    th {
        height: 33px;
    }
</style>
