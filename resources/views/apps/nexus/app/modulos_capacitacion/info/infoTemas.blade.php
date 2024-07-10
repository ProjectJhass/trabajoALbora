{{-- <div class="row mt-5 mb-4">
    <div class="col-md-12">
        <div class="flex-wrap d-flex justify-content-between align-items-center">
            <div class="text-white">
                <h3 class="text-white">{{ $item->nombre_tema }}</h3>
                <p class="mt-3">{{ $item->objetivo }}</p>
            </div>
            <div>
                @if (count($item->evaluacionesCreadas) > 0)
                    <a href="#" class="btn btn-gray rounded-pill ">
                        <i class="fas fa-book"></i>
                        Realizar evaluación
                    </a>
                @else
                    <a href="#" class="btn btn-gray rounded-pill ">
                        <i class="fas fa-book"></i>
                        Marcar como realizado
                    </a>
                @endif

            </div>
        </div>
    </div>
</div> --}}
<div class="row">
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-outline-gray mb-2" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-expand"></i>
                    Ampliar</button>
                @switch($item->tipo)
                    @case('pdf')
                        <iframe src="{{ asset('storage/nexus/temas/' . $item->doc) }}" width="100%" height="620px" frameborder="0"></iframe>
                    @break

                    @case('mp4')
                        <video width="100%" controls>
                            <source src="{{ asset('storage/nexus/temas/' . $item->doc) }}" type="video/mp4">
                            Tu navegador no soporta la etiqueta de video.
                        </video>
                    @break

                    @case('youtube')
                        <iframe width="100%" height="380px" src="{{ $item->doc }}" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    @break

                    @case('presentacion')
                        @php
                            $presentacion = explode('view?', $item->doc);
                        @endphp
                        <iframe src="{{ $presentacion[0] }}view?embed" width="100%" height="380px" frameborder="0"></iframe>
                    @break

                    @case('img')
                        <img src="{{ asset('storage/nexus/temas/' . $item->doc) }}" width="100%" alt="">
                    @break

                    @default
                        <p>No hay información disponible para este tema de capacitación</p>
                @endswitch
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-body">
                @switch($item->tipo)
                    @case('pdf')
                        <iframe src="{{ asset('storage/nexus/temas/' . $item->doc) }}" width="100%" height="680px" frameborder="0"></iframe>
                    @break

                    @case('mp4')
                        <video width="100%" height="680px" controls>
                            <source src="{{ asset('storage/nexus/temas/' . $item->doc) }}" type="video/mp4">
                            Tu navegador no soporta la etiqueta de video.
                        </video>
                    @break

                    @case('youtube')
                        <iframe width="100%" height="680px" src="{{ $item->doc }}" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    @break

                    @case('presentacion')
                        @php
                            $presentacion = explode('view?', $item->doc);
                        @endphp
                        <iframe src="{{ $presentacion[0] }}view?embed" width="100%" height="680px" frameborder="0"></iframe>
                    @break

                    @case('img')
                        <img src="{{ asset('storage/nexus/temas/' . $item->doc) }}" width="100%" height="680px" alt="">
                    @break

                    @default
                        <p>No hay información disponible para este tema de capacitación</p>
                @endswitch
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
