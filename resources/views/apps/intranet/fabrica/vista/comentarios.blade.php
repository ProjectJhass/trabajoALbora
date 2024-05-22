<div>
    <div data-spy="scroll" data-target="#navbar-example2" data-offset="0" id="scroll">
        @foreach ($info as $item)
            <div class="card card-outline d-flex justify-content-center mt-3" id="target_comment">


                <div class="card-header" id="">
                    <div class="d-flex justify-content-end " id="basuras">
                        @if ($item['self_usuario'] == $item['id_usuario'])
                            <button type="button" class="btn btn-sm "
                                onclick="borrarComentario('{{ $item['id_comentario'] }}','{{ route('delete.comment.prototipo') }}')"
                                title="Eliminar Comentario">
                                <i class="fas fa-trash-alt" style="color: red"></i>
                            </button>
                        @endif
                    </div>


                    <div class="post">
                        <div class="user-block ">
                            <img class="img-circle img-bordered-sm" id="img-comment" src="{{ asset('storage/img/profile.png') }}" alt="user image">
                            <span class="username ">
                                <small><b>{{ $item['nombre'] }}</b></small>
                            </span>
                            <span class="description "><b>Fecha: </b>{{ $item['fecha_comentario'] }} <b>Hora:
                                </b>{{ $item['hora_comentario'] }}</span>
                            <div class="mt-1" id="chat">
                                <span><small>{{ $item['comentarios'] }}</small></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
