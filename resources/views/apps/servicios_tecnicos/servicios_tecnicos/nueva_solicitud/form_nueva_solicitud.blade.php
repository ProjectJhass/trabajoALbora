<style>
    .form-control {
        border-top: none;
        border-left: none;
        border-right: none;
        border-radius: 0;
    }

    .select2 {
        width: 100% !important
    }

    .select2-selection {
        border-top: none !important;
        border-left: none !important;
        border-right: none !important;
        border-radius: 0 !important;
        height: 3.6rem !important;
        background-image: none !important;
    }

    #select2-articulo_st-container {
        margin-top: 1rem;
    }
</style>
<div class="card mb-4">
    <div class="card-header">
        <h4>Solicitud - Nuevo servicio técnico</h4>
    </div>
    <div class="card-body">
        <form id="form-send-new-ost" class="was-validated" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="divider">
                <div class="divider-text">Datos generales del cliente</div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="form-floating">
                        <select name="proveedor_st" id="proveedor_st" onchange="validarProveedorForm(this.value)"
                            class="form-control" required>
                            <option value=""></option>
                            <option value="MUEBLES ALBURA">MUEBLES ALBURA SAS</option>
                            <option value="HAPPY SLEEP">HAPPY SLEEP SAS</option>
                            <option value="HOTEL ABADIA">HOTEL ABADIA</option>
                            <option value="HOTEL SONESTA">HOTEL SONESTA</option>
                            <option value="TERCEROS">TERCEROS</option>
                        </select>
                        <label for="proveedor_st">Proveedor</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    @if (!empty($co_exp))
                        <div class="form-floating">
                            <input type="text" class="form-control" value="{{ $co_exp }}" id="co_new_ost"
                                name="co_new_ost" aria-describedby="floatingInputHelp" required />
                            <label for="nombre_st">Centro de experiencia</label>
                        </div>
                    @else
                        <div class="form-floating">
                            <select class="form-control" name="co_new_ost" id="co_new_ost" required>
                            </select>
                            <label for="co_new_ost">Centro de experiencia</label>
                        </div>
                    @endif
                </div>
                <div class="col-md-4 mb-3" hidden>
                    <div class="form-floating">
                        <input type="text" class="form-control" value="{{ $info['ticket'] }}" id="ticket_pw"
                            name="ticket_pw" aria-describedby="floatingInputHelp" />
                        <label for="nombre_st">Ticket</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-floating">
                        <select name="txt_tipo_st" id="txt_tipo_st" onchange="validarTipoStForm(this.value)"
                            class="form-control" required>
                            @if (Auth::user()->id == '30314322')
                                <option value=""></option>
                                <option value="ALMACEN">ALMACEN</option>
                            @else
                                <option value=""></option>
                                <option value="CLIENTE" {{ !empty($co_exp) ? 'selected' : '' }}>CLIENTE</option>
                                <option value="ALMACEN">ALMACEN</option>
                                <option value="BODEGA">BODEGA</option>
                            @endif
                        </select>
                        <label for="proveedor_st">Tipo ST</label>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="form-floating">
                        <input type="number" class="form-control" value="{{ $info['cedula'] }}" id="cedula_st"
                            name="cedula_st" aria-describedby="floatingInputHelp" required />
                        <label for="cedula_st">Cédula</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" value="{{ $info['nombre'] }}"
                            onkeyup="this.value=this.value.toUpperCase()" id="nombre_st" name="nombre_st"
                            aria-describedby="floatingInputHelp" required />
                        <label for="nombre_st">Nombre</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" value="{{ $info['celular'] }}" id="celular_st"
                            name="celular_st" aria-describedby="floatingInputHelp" required />
                        <label for="celular_st">Número de contacto</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-floating">
                        <input type="email" class="form-control" onkeyup="this.value=this.value.toLowerCase()"
                            value="{{ $info['correo'] }}" id="email_st" name="email_st"
                            aria-describedby="floatingInputHelp" required />
                        <label for="email_st">Email</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" value="{{ $info['direccion'] }}"
                            onkeyup="this.value=this.value.toUpperCase()" id="direccion_st" name="direccion_st"
                            aria-describedby="floatingInputHelp" required />
                        <label for="direccion_st">Dirección</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" value="{{ $info['barrio'] }}"
                            onkeyup="this.value=this.value.toUpperCase()" id="barrio_st" name="barrio_st"
                            aria-describedby="floatingInputHelp" required />
                        <label for="barrio_st">Barrio</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="text" class="form-control" value="{{ $info['ciudad'] }}"
                                onkeyup="this.value=this.value.toUpperCase()" id="ciudad_st" name="ciudad_st"
                                aria-describedby="floatingInputHelp" required />
                            <label for="ciudad_st">Ciudad</label>
                        </div>
                        <div class="form-floating">
                            <select name="pago_st" id="pago_st" class="form-control">
                                <option value="{{ $info['pago'] }}">{{ $info['pago'] }}</option>
                                <option value="CONTADO">CONTADO</option>
                                <option value="CREDITO">CREDITO</option>
                            </select>
                            <label for="pago_st">Forma de pago</label>
                        </div>
                        {{-- <div class="form-floating">
                            <input type="text" class="form-control" value="{{ $info['pago'] }}" id="pago_st" name="pago_st"
                                aria-describedby="floatingInputHelp" required />
                            <label for="pago_st">Forma de pago</label>
                        </div> --}}
                    </div>
                </div>
                <div class="col-md-7 mb-3">

                    <input type="text" class="form-control" hidden value="{{ $info['id_item'] }}" name="id_item"
                        id="id_item">
                    <input type="text" class="form-control" hidden value="{{ $info['ext1'] }}" name="ext1"
                        id="ext1">
                    <input type="text" class="form-control" hidden value="{{ $info['ext2'] }}" name="ext2"
                        id="ext2">

                    @if (!empty($co_exp) && !empty($info['articulo']))
                        <div class="form-floating">
                            <input type="text" class="form-control"
                                value="{{ base64_decode($info['articulo']) }}" id="articulo_st" name="articulo_st"
                                aria-describedby="floatingInputHelp" required />
                            <label for="articulo_st">Artículo</label>
                        </div>
                    @else
                        <div class="form-floating">
                            <label for=""></label>
                            <select class="form-control articulo_st" onchange="updateInfoProduct(this)"
                                name="articulo_st" id="articulo_st" data-placeholder="Articulo" required>
                                <option value=""></option>
                                @foreach ($products as $item)
                                    @php
                                        $ext1 = isset($item['ext1']) ? $item['ext1'] : '';
                                        $ext2 = isset($item['ext2']) ? $item['ext2'] : '';
                                    @endphp
                                    <option data-id_item="{{ $item['id'] }}" data-ext1="{{ $ext1 }}"
                                        data-ext2="{{ $ext2 }}" value="{{ trim($item['producto']) }}">
                                        {{ trim($item['producto']) }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
                <div class="col-md-1 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control text-center" id="cantidad_item"
                            name="cantidad_item" aria-describedby="floatingInputHelp" />
                        <label for="barrio_st">Cantidad</label>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="text" class="form-control" value="{{ $info['factura'] }}"
                                onkeyup="this.value=this.value.toUpperCase()" id="factura_st" name="factura_st"
                                aria-describedby="floatingInputHelp" />
                            <label for="factura_st">N° Factura</label>
                        </div>
                        <div class="form-floating">
                            <input type="date" class="form-control" value="{{ $info['fecha_factura'] }}"
                                id="fecha_factura" name="fecha_factura" aria-describedby="floatingInputHelp" />
                            <label for="fecha_factura">Fecha factura</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="text" class="form-control" value="{{ $info['remision'] }}"
                                onkeyup="this.value=this.value.toUpperCase()" id="remision_st" name="remision_st"
                                aria-describedby="floatingInputHelp" />
                            <label for="remision_st">N° remisión</label>
                        </div>
                        <div class="form-floating">
                            <input type="date" class="form-control" value="{{ $info['fecha_remision'] }}"
                                id="fecha_remision" name="fecha_remision" aria-describedby="floatingInputHelp" />
                            <label for="">Fecha remisión</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="divider">
                <div class="divider-text">Detalles del servicio técnico</div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="form-floating">
                        <textarea name="obs" id="obs" class="form-control" cols="30" rows="2" required>{{ $info['obs'] }}</textarea>
                        <label for="obs">Daño reportado</label>
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <select class="form-control" id="causales_st" name="causales_st[]"
                        data-placeholder="Seleccionar causales..." multiple>
                        @foreach ($causales as $item)
                            <option value="{{ $item->descripcion }}">{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="otro_causal_st" name="otro_causal_st"
                            aria-describedby="floatingInputHelp" />
                        <label for="otro_causal_st">Otro casusal</label>
                    </div>
                </div>
            </div>
            <div class="divider">
                <div class="divider-text">Finalizar</div>
            </div>
            <center>
                <div class="demo-inline-spacing">
                    <button type="button" class="btn rounded-pill btn-danger" onclick="CrearNuevaSolicitudST()">
                        <span class="tf-icons bx bx-bell"></span>&nbsp; Crear servicio técnico
                    </button>
                    @if (empty($info['ticket']))
                        <button type="button" class="btn rounded-pill btn-secondary" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasBottom">
                            <span class="tf-icons bx bx-camera me-1"></span>Agregar evidencias
                        </button>
                    @endif
                </div>
            </center>

            <div class="col-lg-3 col-md-6" id="offcanvas-info-ev">
                <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom"
                    aria-labelledby="offcanvasBottomLabel">
                    <div class="offcanvas-header">
                        <h5 id="offcanvasBottomLabel" class="offcanvas-title">Agregar evidencias <span
                                class="tf-icons bx bx-camera me-1"></span> /
                            <span class="tf-icons bx bxs-camera-movie me-1"></span>
                        </h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <input type="file" class="form-control" multiple name="evidencias_st[]"
                            id="evidencias_st">
                        <hr>
                        <button type="button" class="btn rounded-pill btn-outline-danger"
                            onclick="$('#evidencias_st').val('')">
                            <span class="tf-icons bx bx-camera me-1"></span>Eliminar evidencias cargadas
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
