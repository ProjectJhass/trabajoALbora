<div class="row">

    @foreach ($data as $item)
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="text-muted"><small>{{ $item['fecha'] }}</small></div>
                    <div class="card-text">{{ $item['seguimiento'] }}</div>
                    <div class="text-muted">- <small>{{ $item['responsable'] }}</small></div>
                    <div class="mt-2 text-muted demo-inline-spacing">
                        @foreach ($item['evidencias'] as $evidencia)
                            <a href="{{ asset($evidencia->url) }}" class="text-muted" target="_blank"><i class='bx bx-link-alt'></i><span>{{ $evidencia->nombre_img }}</span></a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach


</div>
