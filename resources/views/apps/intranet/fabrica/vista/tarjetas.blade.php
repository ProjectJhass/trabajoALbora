@foreach ($info as $item)
    <div class="col-md-4 mb-3 mt-2">
        <div class="card card-outline shadow" id="width-card">
            <div class="card-body" id="card-color">
                <div class="post">
                    <div class="user-block " id="user-block">

                        <a href="{{ asset($item['url']) }}" target="_BLANK"><img id="border-image"
                                class="border-image card-img-top img-fluid" src="{{ asset($item['url']) }}"
                                alt="Imagen Idea"></a>

                        <div class="inf-user">
                            <span class="username ">{{ $item['nombre'] }}</span>
                            <span class="description "><small><b>publicado por:
                                    </b>{{ $item['nombre_persona'] }}</small></span>
                            <span class="description "><small><b>Fecha: </b>{{ $item['fecha'] }}</small></span>
                        </div>
                    </div>


                    <div>
                        <div class="dropdown d-flex justify-content-end">
                            <button class="btn btn-secondary" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v" title="Ver Opciones de Ideas"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left"
                                aria-labelledby="dropdownMenuButton">
                                @if ($item['self_usuario'] == $item['id_usuario'])
                                    <span class="dropdown-item d-flex " id="span-comment">
                                        <a type="button" title="Eliminar Idea"
                                            onclick="deleteIdea('{{ $item['id'] }}', '{{ url('/deleteidea') }}')"> <i
                                                class="fas fa-trash-alt" style="color: #dc143c"> </i>
                                            <small> Eliminar Idea</small> </a></span>


                                    <span class="dropdown-item d-flex " id="span-comment">
                                        <a id="cambio_{{ $item['id'] }}"
                                            onclick="puente('{{ $item['id'] }}','{{ $item['nombre'] }}')"
                                            type="button" title="Editar Idea" data-toggle="modal"
                                            data-id-idea="{{ $item['id'] }}" data-target="#modal_cambios" data-link="{{$item['link']}}"><i
                                                class="fas fa-edit" style="color: rgb(245, 181, 64)"></i>
                                            <small> Editar Idea</small> </a></span>

                                            @if (isset($item['link']))

                                            <span class="dropdown-item d-flex " id="span-comment">
                                                <a onclick="deleteLink('{{ $item['id'] }}','{{ route('delete-link') }}')"
                                                     type="button" title="Eliminar Imagen"
                                                    data-toggle="modal" data-id-idea="{{ $item['id'] }}"><i
                                                        style="color: #dc143c;" class="fas fa-eraser"></i>
                                                    <small> Eliminar Enlace</small> </a></span>

                                            @endif

                                @endif

                                <span class="dropdown-item  d-flex  ">
                                    <a id="id_ideas{{ $item['id'] }}" type="button" title="Comentarios de esta idea"
                                        onclick="validarInformacion('{{ $item['id'] }}','{{ url('/ideasid') }}')"
                                        data-widget="control-sidebar" data-slide="true" data-id="{{ $item['id'] }}">
                                        <i class="fas fa-comments  d-inline" style="color: #484441 "></i>
                                        <small>Comentarios (<b>{{ $item['conteo'] }}</b>)</small>
                                    </a>
                                </span>

                            </div>
                        </div>
                    </div>


                    @if (isset($item['link']))
                        <center class="mt-2">
                            <span id="enlace"><a href="{{ $item['link'] }}" target="_blank"><img
                                        src="{{ asset('img/www.png') }}" alt="" width="25" height="25">
                                     ir a la url de la imagén.</a></span>
                        </center>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach
