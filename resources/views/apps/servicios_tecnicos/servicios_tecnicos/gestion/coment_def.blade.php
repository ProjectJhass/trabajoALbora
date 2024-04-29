@if (count($data) > 0)
    <blockquote class="blockquote mb-0">
        <ul class="p-0 m-0">
            @foreach ($data as $item)
                <li class="d-flex mb-4 pb-1">
                    <div class="avatar flex-shrink-0 me-3">
                        <img src="{{ asset('icons/chart.png') }}" alt="Icon" class="rounded" />
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <small class="text-muted d-block mb-1">{{ $item['fecha_responsable'] }} </small>
                            <h6 class="mb-0">{{ $item['comentario'] }}</h6>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-1">
                            <span class="text-muted">- {{ $item['responsable'] }}</span>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </blockquote>
@endif
