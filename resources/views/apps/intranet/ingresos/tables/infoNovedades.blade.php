<table class="table table-bordered table-sm">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>Cédula</th>
            <th>Nombre</th>
        </tr>
    </thead>
    <tbody>
        <?php $ban_1 = 0; ?>
        @foreach ($info as $item)
            <?php $ban_1++; ?>
            <tr data-widget="expandable-table" aria-expanded="false">
                <td>{{ $ban_1 }}</td>
                <td>{{ $item['cedula'] }}</td>
                <td>{{ $item['nombre'] }}</td>
            </tr>
            <tr class="expandable-body">
                <td colspan="4">
                    <p>
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Novedad</th>
                                <th>Fecha</th>
                                <th>Hora Ingreso</th>
                                <th>Hora Salida</th>
                                <th>Hora re-ingreso</th>
                                <th>Hora salida</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $ban_2 = 0; ?>
                            @foreach ($item['novedades'] as $value)
                                <?php $ban_2++; ?>
                                <tr>
                                    <td>{{ $ban_2 }}</td>
                                    <td><?php echo $value['novedad_usuario']; ?></td>
                                    <td>{{ $value['fecha_novedad'] }}</td>
                                    <td>{{ $value['hora_ingreso'] }}</td>
                                    <td>{{ $value['hora_salida'] }}</td>
                                    <td>{{ $value['hora_reingreso'] }}</td>
                                    <td>{{ $value['hora_salida_reingreso'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </p>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
