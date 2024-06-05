<table class="table table-bordered table-sm" id="UsuariosInasistencias">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody class="text-center" style="font-size: 14px">
        <?php $n = 0; ?>
        @foreach ($info as $item)
            <?php $n++; ?>
            <tr>
                <td>{{ $n }}</td>
                <td class="text-left">{{ $item['cedula'] }}</td>
                <td class="text-left">{{ $item['nombre'] }}</td>
                <td>{{ $item['fecha'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
