@php
    $tipo_ = $tipo == '1' ? 'Impreso' : 'Fallido';
@endphp
<table class="table table-bordered">
    <thead class="text-center">
        <tr>
            <th>Consecutivo</th>
            <th>Estado</th>
            <th>Re-imprimir</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach ($data as $item)
            <tr id="consecPrinted{{ $item->id }}">
                <td>{{ $item->id }}</td>
                <td>{{ $tipo_ }}</td>
                <td><button class="btn btn-sm btn-danger" onclick="reImprimirCodigoQRPrinter('{{ $item->id }}', '1')"><i
                            class="fa fa-print"></i></button></td>
            </tr>
        @endforeach
    </tbody>
</table>
