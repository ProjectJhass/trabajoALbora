@if (count($data) > 0)
    @foreach ($data as $item)
        <div class="card mb-2">
            <blockquote class="blockquote mb-0">
                <ul class="p-2">
                    <li class="d-flex pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="{{ asset('icons/chart.png') }}" alt="Icon" class="rounded" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="text-muted d-block mb-1">{{ $item->fecha_responsable }} </small>
                                <h6 class="mb-0">{{ $item->comentario }}</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                                <span class="text-muted">- {{ $item->responsable }}</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </blockquote>
        </div>
    @endforeach
@endif
