<table class="table table-bordered table-striped table-sm  text-center"  id="evaluacionesTabla"  style="font-size: 13px">
    <thead class="bg-danger">
        <th class="text-center">Coordinador</th>
        <th class="text-center">Enero</th>
        <th class="text-center">Febrero</th>
        <th class="text-center">Marzo</th>
        <th class="text-center">Abril</th>
        <th class="text-center">Mayo</th>
        <th class="text-center">Junio</th>
        <th class="text-center">Julio</th>
        <th class="text-center">Agosto</th>
        <th class="text-center">Septiembre</th>
        <th class="text-center">Octubre</th>
        <th class="text-center">Noviembre</th>
        <th class="text-center">Diciembre</th>
        <th class="text-center">Total</th>
    </thead>
    <tbody>
        @foreach ($coordinadores as $coordinador)
            <tr>
                <td>
                    {{ $coordinador->nombre }}
                </td>
                @php
                    $total = 0;
                    $contador = 0;
                    $mesesConResultados = 0;
                @endphp
                @foreach ($datos as $dato)
                    @php
                        $valorEncontrado = false;
                        $contador++;
                    @endphp
                    @foreach ($dato as $porcentaje)
                        @if ($porcentaje->usuario_evaluado == $coordinador->id)
                            <td>
                                <a class="nav-link text-dark" data-widget="control-sidebar" data-slide="true" href="#" role="button" id="sidebar-toggle" onclick="mostrarCentrosEvaluados('{{$coordinador->id}}', {{$contador}})">
                                    <span class="badge badge-primary">{{ number_format($porcentaje->promedio_porcentaje, 1) }}</span>
                                </a>
                                @php
                                    $total += $porcentaje->promedio_porcentaje;
                                    $valorEncontrado = true;
                                    $mesesConResultados++;
                                @endphp
                            </td>
                        @endif
                    @endforeach
                    @if (!$valorEncontrado)
                        <td></td>
                    @endif
                @endforeach
                @php
                    $promedioMensual = ($mesesConResultados > 0) ? ($total / $mesesConResultados) : 0;
                @endphp
                <td>
                    <a class="nav-link text-dark">
                        <span class="badge badge-warning">{{ number_format($promedioMensual, 1) }}</span>
                    </a>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $('#evaluacionesTabla').DataTable({
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
