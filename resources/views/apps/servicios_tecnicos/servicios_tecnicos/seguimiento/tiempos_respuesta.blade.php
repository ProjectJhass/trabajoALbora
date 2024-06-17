<table class="table table-striped table-bordered table-sm" id="tiempos_respuesta_st">
    <thead>
        <tr class="text-center" style="background-color: #e6e6ff; color: white;">
            <th>Id</th>
            <th>Etapa</th>
            <th>PLazo (dias)</th>
            <th>Tiempo de respuesta</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach ($data as $orden)
            @foreach ($orden as $seguimiento)
                <tr>
                    <td>{{ $seguimiento['id'] }}</td>
                    <td>{{ $seguimiento['etapa'] }}</td>
                    <td>{{ $seguimiento['dias'] }}</td>
                    <td>{{ $seguimiento['diferencia'] }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
<style>
    td, th{
        height: 33px;
    }
</style>
