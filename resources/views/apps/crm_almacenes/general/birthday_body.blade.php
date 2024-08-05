<div class="container">
    @if ($count_birthday > 0 || $count_birthday_tomorrow > 0)

        @if ($count_birthday > 0)
            <div class="row">

                <div class="col-lg-12">

                    <h3 class="text-center text-danger">Hoy</h3>

                    @foreach ($data_birthday as $item)
                        <?php $icon = $item->genero == 'MUJER' ? 'women.png' : 'man.png'; ?>
                        <div class="dropdown-item" style="outline: none; user-select: none;">
                            <div class="media">
                                <img src="{{ asset('img/' . $icon) }}" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        {{ $item->nombre_1 . ' ' . $item->nombre_2 . ' ' . $item->apellido_1 . ' ' . $item->apellido_2 }}
                                        <a onclick='copyImageToClipboard("https://app-mueblesalbura.com/mesa_de_ayuda/imagenes/img/Cumplean%CC%83os%20Cliente%20Albura.jpeg", "{{ $item->id_cliente }}")'
                                            class="float-right text-sm text-success"><i class="fab fa-whatsapp"
                                                style="font-size: 28px"></i></a>
                                    </h3>
                                    <p class="text-sm">Cumpleaños</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> Hoy</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Telefono</span>
                                        <input type="text" class="form-control" placeholder="Username"
                                            aria-label="Username" value="57{{ $item->celular_1 }}"
                                            id="cellnumber_cumple_{{ $item->id_cliente }}"
                                            aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="input-group">
                                        <span class="input-group-text">Mensaje</span>
                                        <textarea rows="1" class="form-control" id="text_cumple_{{ $item->id_cliente }}" aria-label="With textarea">!Que tengas un día maravilloso, Feliz Cumpleaños le desea Muebles Albura 🎉🙌✨!</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                    @endforeach

                </div>

            </div>
        @endif

        @if ($count_birthday_tomorrow > 0)
            <div class="row">

                <div class="col-lg-12">

                    <h3 class="text-center text-danger">Mañana</h3>

                    @foreach ($data_birthday_tomorrow as $item)
                        <?php $icon = $item->genero == 'MUJER' ? 'women.png' : 'man.png'; ?>
                        <div class="dropdown-item" style="outline: none; user-select: none;">
                            <div class="media">
                                <img src="{{ asset('img/' . $icon) }}" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        {{ $item->nombre_1 . ' ' . $item->nombre_2 . ' ' . $item->apellido_1 . ' ' . $item->apellido_2 }}
                                    </h3>
                                    <p class="text-sm">Cumpleaños</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> Mañana</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                    @endforeach

                </div>

            </div>
        @endif
    @else
        <div class="text-center">
            <h3>No hay cumpleaños de algun cliente el dia de hoy o mañana.</h3>
        </div>
    @endif
</div>
