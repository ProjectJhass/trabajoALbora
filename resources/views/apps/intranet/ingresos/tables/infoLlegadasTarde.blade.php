<table class="table table-bordered table-sm" id="UsuariosLlegadasTarde">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Fecha</th>
            <th>Hora ingreso</th>
            <th>Hora salida</th>
            <th>Hora re-ingreso</th>
            <th>Hora re-salida</th>
            <th>Novedades</th>
        </tr>
    </thead>
    <tbody class="text-center" style="font-size: 14px">
        <?php $n = 0; ?>
        @foreach ($info as $item)
            <?php $n++; ?>
            <tr>
                <td>{{ $n }}</td>
                <td class="text-left">{{ $item->id }}</td>
                <td class="text-left">{{ $item->nombre }}</td>
                <td>{{ $item->fecha_registro }}</td>
                <td>{{ $item->hora_ingreso }}</td>
                <td>{{ $item->hora_salida }}</td>
                <td>{{ $item->hora_reingreso }}</td>
                <td>{{ $item->hora_salida_reingreso }}</td>
                <td>{{ $item->hora_salida_reingreso }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
