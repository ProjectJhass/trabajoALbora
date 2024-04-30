@foreach ($data as $item)
    <li>
        <div class="block">
            <div class="tags">
                <div class="tag">
                    <span>{{ date('Y-m-d', strtotime($item->created_at)) }}</span>
                </div>
            </div>
            <div class="block_content">
                <h2 class="title">
                    <a>Madera {{ $item->madera }}</a>
                    @if (Auth::user()->rol == 1 || Auth::user()->rol == 2)
                        @if (Auth::user()->rol == 1)
                            <i class="fa fa-print" style="cursor: pointer" onclick="printInfoImpresiones('{{ $item->id }}')" title="Imprimir"></i>
                        @endif
                        <i class="fa fa-edit text-danger" style="cursor: pointer" onclick="EditInformacionEtiquetas('{{ $item->id }}')"
                            title="Editar"></i>
                    @endif
                </h2>
                <div class="byline">
                    Cantidad: {{ $item->total_bloques }}
                </div>
                <p class="excerpt">{{ $item->created_at }}</a>
                </p>
            </div>
        </div>
    </li>
@endforeach
