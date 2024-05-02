<ul class="list-unstyled top_profiles scroll-view">
    @foreach ($cortes as $item)
        <li class="media event mb-3">
            <a href="{{ route('corte.woodmiser', ['id_corte' => $item->id]) }}" class="pull-left border-red profile_thumb">
                <i class="fab fa-steam-symbol red"></i>
            </a>
            <div class="media-body">
                <a class="title" href="{{ route('corte.woodmiser', ['id_corte' => $item->id]) }}">{{ $item->mueble . ' ' . $item->serie . ' ' . strtoupper($item->madera) }}</a>
                <p class="red"><strong>X {{ $item->cantidad }} UNIDADES</strong></p>
                <p> <small>{{ $item->created_at }}</small>
                </p>
            </div>
        </li>
    @endforeach
</ul>
