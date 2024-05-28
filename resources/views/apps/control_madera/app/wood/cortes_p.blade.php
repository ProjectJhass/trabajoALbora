@php
    $bandera = 0;
@endphp
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr class="text-center">
                <th>#</th>
                <th>Serie</th>
                <th>Cantidad</th>
                <th>Fecha</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($cortes as $item)
                @php
                    $bandera++;
                @endphp
                <tr>
                    <td>{{ $bandera }}</td>
                    <td class="text-start">{{ $item->mueble . ' ' . $item->serie . ' ' . strtoupper($item->madera) }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <a href="{{ route('corte.woodmiser', ['id_corte' => $item->id]) }}" type="button" class="btn btn-success">Empezar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
