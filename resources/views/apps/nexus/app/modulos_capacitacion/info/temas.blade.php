<div class="row mt-4">
    @foreach ($info as $item)
        <div class="col-md-4 d-flex">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="">
                            <h4>{{ $item->cantidad_evaluaciones }}</h4>
                            <h6>Evaluaciones</h6>
                        </div>
                        @php
                            $smile =
                                $item->cantidad_evaluaciones != 0
                                    ? '<div class="badge bg-success p-2"><i class="far fa-smile" style="font-size: 25px"></i></div>'
                                    : '<div class="badge bg-danger p-2"><i class="far fa-frown" style="font-size: 25px"></i></div>';
                        @endphp
                        <div class="">
                            {!! $smile !!}
                        </div>
                    </div>
                    <div class="d-flex  justify-content-start align-items-center mb-3">
                        <div>
                            <h5 class="">{{ $item->nombre_tema }}</h5>
                        </div>
                    </div>
                    <div>
                        <small>{{ $item->objetivo }}</small>
                    </div>
                    <div class="pt-4">
                        <center>

                        </center>
                    </div>
                </div>
                <a href="{{ route('contenido.tema.nexus', ['id_tema'=>$item->id_tema]) }}" class="btn btn-danger btn-sm">Visualizar tema</a>
            </div>
        </div>

        {{-- <div class="col-md-12 mb-3">
            <div class="card">
                <div class="p-3 flex-wrap d-flex justify-content-between align-items-center">
                    <a href="#" class="header-title">
                        <p><span class="badge bg-success rounded-pill">{{ $item->estado }}</span></p>
                        <h4 class="card-title">{{ $item->nombre_tema }}</h4>
                        <p class="mb-0">{{ $item->objetivo }}</p>
                    </a>
                    <i class="fas fa-chevron-circle-right fa-lg"></i>
                </div>
            </div>
        </div> --}}
    @endforeach
</div>
