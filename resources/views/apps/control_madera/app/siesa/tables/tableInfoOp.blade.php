<table class="table table-bordered table-hover">
    <thead class="text-center">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Pulgadas a solicitar</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach ($info as $item)
            <tr style="cursor:pointer" onclick="seleccionarInfoOp('{{ $item['id'] }}','{{ $item['codigo'] }}')">
                <td>{{ $item['id'] }}</td>
                <td id="nombre{{ $item['id'] }}">{{ $item['nombre'] }}</td>
                <td id="pulgadas{{ $item['id'] }}">{{ $item['pulgadas'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
