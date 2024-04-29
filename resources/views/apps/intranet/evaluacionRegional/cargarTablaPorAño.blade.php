<table class="table table-bordered table-striped table-sm  text-center"  id="HistorialPorAñosC"  style="font-size: 13px">
    <thead class="bg-danger">
        <tr>
            <th>Coordinador</th>
            @foreach ($resultadosTotales[0]['resultados'] as $ano => $resultado)
                <th>{{ $ano }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($resultadosTotales as $resultadosPorCoordinador)
            <tr>
                <td>{{ $resultadosPorCoordinador['nombre'] }}</td>
                @foreach ($resultadosPorCoordinador['resultados'] as $resultado)
                    @php
                        $porcentaje = $resultado/12;
                    @endphp

                    <td>{{ number_format($porcentaje, 1) }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $('#HistorialPorAñosC').DataTable({
        "oLanguage": {
            "sSearch": "Buscar:",
            "sInfo": "Mostrando de _START_ a _END_ de _TOTAL_ registros",
            "oPaginate": {
                "sPrevious": "Volver",
                "sNext": "Siguiente"
            },
            "sEmptyTable": "No se encontró ningún registro en la base de datos",
            "sZeroRecords": "No se encontraron resultados...",
            "sLengthMenu": "Mostrar _MENU_ registros"
        },
        "paging": true,
        "lengthChange": false, // Desactivar la opción de cambiar la cantidad de registros a mostrar
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": false,
        dom: '<"top"fB>rtip',
        buttons: [{
            extend: 'excel',
            text: '<i class="fas fa-file-excel"></i> Descargar',
            className: 'btn-sm btn-success opacity-75', // Agregamos la clase para hacer el botón más pequeño
        }],
    });
</script>
