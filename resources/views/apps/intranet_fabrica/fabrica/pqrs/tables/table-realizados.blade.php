<table class="table table-striped table-bordered table-sm" id="solicitudes-realizadas">
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
            <tr>
                <td>{{ $pqrs['id'] }}</td>
                <td>{{ $pqrs['consecutivo'] }}</td>
                <td>{{ $pqrs['nombres'] . ' ' . $pqrs['apellidos'] }}</td>
                <td>{{ $pqrs['tipo_solicitud'] }}</td>
                <td>{{ $pqrs['estado'] }}</td>
                <td>
                    <a href="{{route('show.detalle.pqrs', ['id'=>$pqrs['consecutivo']])}}">
                        <button class="btn btn-outline-info">
                            <i class="fas fa-eye"></i>
                        </button>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<style>
    td,
    th {
        height: 33px;
    }
</style>
