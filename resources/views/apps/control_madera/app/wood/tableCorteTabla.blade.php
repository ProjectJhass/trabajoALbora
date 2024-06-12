@if (count($info) > 0)
    <div class="card alert-top" data-aos="fade-up" data-aos-delay="100">
        <div class="card-header">
            <h5>Cortes de tablas pendientes</h5>
        </div>
        <div class="card-body">
            <div id="info-general-cortes-wood">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Corte</th>
                            <th>Cantidad</th>
                            <th>Medida</th>
                            <th>Planificador</th>
                            <th>Fecha</th>
                            <th>Cortar</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($info as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>Corte de tabla</td>
                                <td>{{ $item->cantidad }}</td>
                                <td>{{ $item->medida_grosor }}mm</td>
                                <td>{{ $item->planificador }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td><a href="{{ route('get.planner.tabla', ['id' => $item->id]) }}" type="button" class="btn btn-danger">Empezar</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
