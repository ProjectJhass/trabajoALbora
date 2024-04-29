<div class="mt-4 table-responsive text-nowrap">
    <table class="table table-striped" id="tableInfoVehiculos">
        <thead>
            <tr>
                <th>Id</th>
                <th>Placa</th>
                <th>Descripción</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($info as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->placa }}</td>
                    <td>{{ $item->modelo }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
