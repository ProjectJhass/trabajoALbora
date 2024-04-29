<div class="mt-4 table-responsive text-nowrap">
    <table class="table table-striped" id="tableInfoConductores">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Celular</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($info as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->celular }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
