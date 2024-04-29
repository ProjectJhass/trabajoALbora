@if (count($data) > 0)
    @foreach ($data as $item)
        <div class="col-md-4 mb-3">
            <a href="{{ route('st.find.ost.card', ['id_st' => $item->id_st]) }}">
                <div class="card">
                    <h5 class="card-header">OST {{ $item->id_st }}</h5>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p>{{ $item->articulo }}</p>
                            <footer class="blockquote-footer">{{ $item->nombre }}</footer>
                            <footer class="blockquote-footer">{{ date('Y-m-d', strtotime($item->created_at)) }}</footer>
                            <footer class="blockquote-footer">{{ $item->almacen }}</footer>
                            <footer class="blockquote-footer">{{ $item->estado }}</footer>
                        </blockquote>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@else
    <p>No hay información en la base de datos para esta orden de servicio</p>
@endif
