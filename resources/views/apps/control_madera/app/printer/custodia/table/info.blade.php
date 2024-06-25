<table class="table table-bordered table-striped" id="tableInfoEtiquetasCustodia">
    <thead>
        <tr class="text-center">
            <td>#</td>
            <td>Consecutivo impreso</td>
            <td>Usuario asignado</td>
            <td>Estado</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->id_consecutivo }}</td>
                <td>{{ $item->usuario_a_cargo }}</td>
                <td>{{ $item->estado }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
