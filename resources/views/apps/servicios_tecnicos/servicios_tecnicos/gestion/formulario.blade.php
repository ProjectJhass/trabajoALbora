@php
    $info_st = $data->first();
    $info_t = $i_taller->first();
    $estados_ = ['En devolucion', 'Definido'];
@endphp
<div class="card mb-4 mb-lg-0">
    <div class="card-header">
        <div class="card-title d-flex align-items-start justify-content-between">
            <h4>Histórico del servicio técnico</h4>
            @if ($info_st->estado != 'definido')
                <div class="demo-inline-spacing">
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger btn-icon rounded-pill dropdown-toggle hide-arrow"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            {{-- <li><a class="dropdown-item" id="edit{{ $id_ost }}" href="javascript:void(0);">Editar servicio</a></li> --}}
                            <li><a class="dropdown-item" id="add{{ $id_ost }}" href="javascript:void(0);"
                                    onclick="modalAddComentariosAdicionales('{{ $id_ost }}')">Agregar comentario
                                    general</a></li>
                            <li><a class="dropdown-item" id="print{{ $id_ost }}" target="_BLANK"
                                    href="{{ route('print.form.solicitud', ['id_st' => $id_ost]) }}">Imprimir formato
                                    OST</a></li>
                            <li><a class="dropdown-item" id="update{{ $id_ost }}"
                                    {{ empty($comentarios_v) ? '' : 'hidden' }} href="javascript:void(0);"
                                    onclick="updateOrdenStVisitaEvidencias('{{ $id_ost }}')">Actualizar visita /
                                    Evidencias</a></li>
                            @if ($info_st->proceso == 'Servicio tecnico' || $info_st->proceso == 'Almacen' || $info_st->proceso == 'Cliente')
                                @if (in_array($info_st->estado, $estados_) ||
                                        ($info_st->respuesta_st == 'No garantia' || $info_st->respuesta_st == 'No garantia por tiempo'))
                                    <li><a class="dropdown-item" id="printFab{{ $id_ost }}" target="_BLANK"
                                            href="{{ route('print.carta', ['id_st' => $id_ost]) }}">Imprimir respuesta
                                            de
                                            fábrica</a>
                                    </li>
                                    @if (Auth::user()->almacen == 'HAPPYSLEEP')
                                        <li><a class="dropdown-item" id="printFab{{ $id_ost }}"
                                                href="{{ route('format.hs', ['id_st' => $id_ost]) }}">Imprimir
                                                respuesta
                                                HS</a>
                                        </li>
                                    @endif
                                @endif
                                @if (
                                    $info_st->estado == 'Por definir' &&
                                        $info_st->proceso == 'Servicio tecnico' &&
                                        ($info_st->respuesta_st == 'No garantia' || $info_st->respuesta_st == 'No garantia por tiempo'))
                                    <li><a class="dropdown-item" id="sendNotify{{ $id_ost }}"
                                            href="javascript:void(0);"
                                            onclick="sendNotificacionCarta('{{ $id_ost }}')">Enviar notificación
                                            y carta</a>
                                    </li>
                                @endif
                            @endif
                            @if ($info_st->proceso == 'Fabrica' && $info_st->estado == 'En valoracion')
                                <li><a class="dropdown-item" id="valoracion{{ $id_ost }}"
                                        href="javascript:void(0);"
                                        onclick="modalValoracionFabrica('{{ $id_ost }}')">Emitir concepto de
                                        valoración</a></li>
                            @endif
                            @if (
                                ($info_st->proceso == 'Fabrica' && $info_st->estado == 'Carta en elaboracion') ||
                                    ($info_st->respuesta_st == 'Cobrable' &&
                                        $info_st->estado == 'En devolucion' &&
                                        $info_st->tipo_servicio == 'CLIENTE'))
                                <li><a class="dropdown-item" id="rspta{{ $id_ost }}"
                                        onclick="modalRespuestaCartaStReparado('{{ $id_ost }}','{{ $info_st->respuesta_st }}')"
                                        href="javascript:void(0);">Emitir respuesta
                                        del st
                                        reparado</a></li>
                            @endif
                            @if ($info_st->proceso == 'Almacen' && $info_st->estado == 'Recoger')
                                <li><a class="dropdown-item" id="recoger{{ $id_ost }}"
                                        onclick="modalUpdateDataRecogida('{{ $id_ost }}')"
                                        href="javascript:void(0);">Actualizar recogida</a>
                                </li>
                            @endif
                            @if (
                                $info_st->respuesta_st == 'No garantia' &&
                                    $info_st->proceso == 'Servicio tecnico' &&
                                    $info_st->estado == 'Por definir')
                                <li><a class="dropdown-item" id="updateValFab{{ $id_ost }}"
                                        href="javascript:void(0);"
                                        onclick="modalUpdateValoracionGerOst('{{ $id_ost }}')">Actualizar
                                        valoración
                                        fábrica</a></li>
                            @endif
                            @if ($info_st->proceso == 'Taller' && $info_st->estado == 'Por ingresar')
                                <li><a class="dropdown-item" id="updateValFab{{ $id_ost }}"
                                        href="javascript:void(0);"
                                        onclick="modalIngresarOstTaller('{{ $id_ost }}', '1-ingreso','{{ trim($info_st->articulo) }}', '{{ $info_st->tipo_servicio }}')">Actualizar
                                        ingreso a taller</a></li>
                            @endif
                            @if ($info_st->proceso == 'Taller' && $info_st->estado == 'En reparacion')
                                <li><a class="dropdown-item" id="updateValFab{{ $id_ost }}"
                                        href="javascript:void(0);"
                                        onclick="modalSeguimientoReparacionSt('{{ $id_ost }}')">Agregar
                                        seguimiento de taller</a></li>
                                <li><a class="dropdown-item" id="updateValFab{{ $id_ost }}"
                                        href="javascript:void(0);"
                                        onclick="modalIngresarOstTaller('{{ $id_ost }}', '{{ $info_t->orden_taller }}-salida','{{ trim($info_st->articulo) }}', '{{ $info_st->tipo_servicio }}')">Actualizar
                                        salida de taller</a></li>
                            @endif
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            @if ($info_st->proceso == 'Servicio tecnico' && $info_st->estado == 'En devolucion')
                                <li><a class="dropdown-item" id="close{{ $id_ost }}" href="javascript:void(0);"
                                        onclick="modalDefinirOrdenServicio('{{ $id_ost }}')">Definir/Cerrar orden
                                        de
                                        servicio</a>
                                </li>
                            @endif
                            @php
                                $array_ = ['SERVICIO TECNICO FAB', 'SERVICIO TECNICO', 'HAPPYSLEEP', 'PPAL', 'MANIZALES_017'];
                            @endphp
                            @if (in_array(Auth::user()->almacen, $array_) && $info_st->estado != 'En devolucion')
                                <li><a class="dropdown-item" id="close{{ $id_ost }}" href="javascript:void(0);"
                                        onclick="modalDefinirOrdenServicio('{{ $id_ost }}')">Definir/Cerrar orden
                                        de
                                        servicio</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @foreach ($data as $item)
        <div class="card-body" style="font-size: 16px">
            <div class="row">

                <div class="col-md-4">
                    <p class="mb-1"><strong>Número ST: </strong><span
                            class="badge rounded-pill bg-label-primary">{{ $item->id_st }}</span></p>
                    <p class="mb-1"><strong>Cédula: </strong> {{ $item->cedula }}</p>
                    <p class="mb-1"><strong>Celular: </strong> {{ $item->celular }}</p>
                    <p class="mb-1"><strong>Almacén: </strong>{{ $item->almacen }} </p>
                    <p class="mb-1"><strong>Forma de pago: </strong>{{ $item->forma_pago }}</p>
                    <p class="mb-1"><strong>Número remisión: </strong>{{ $item->remision }}</p>
                    <p class="mb-1"><strong>Fecha remisión: </strong> {{ $item->fecha_remision }} </p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1"><strong>Estado: </strong><span
                            class="badge rounded-pill bg-label-info">{{ $item->estado }}</span></p>
                    <p class="mb-1"><strong>Nombre: </strong> {{ $item->nombre }}</p>
                    <p class="mb-1"><strong>Email: </strong> {{ $item->email }}</p>
                    <p class="mb-1"><strong>Dirección: </strong>
                        {{ $item->direccion . ' - ' . $item->barrio . ' - ' . $item->ciudad }}</p>
                    <p class="mb-1"><strong>Fecha: </strong>{{ $item->created_at }} </p>
                    <p class="mb-1"><strong>Número factura: </strong>{{ $item->factura }}</p>
                    <p class="mb-1"><strong>Fecha factura: </strong>{{ $item->fecha_factura }}</p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1"><strong>Concepto: </strong><span
                            class="badge rounded-pill bg-label-info">{{ $item->respuesta_st }}</span></p>
                    <p class="mb-1"><strong>Item:</strong> {{ $item->articulo }}</p>
                    <p class="mb-1"><strong>Daño reportado:</strong> {{ $item->inconveniente }}</p>
                    <p class="mb-1"><strong>Causales:</strong> {{ $item->causales }}</p>
                </div>
                <div class="col-md-12 mt-3">
                    <p class="mb-1"><strong><i>Usuario creación: </strong> {{ $item->asesor }}</i></p>
                    <p class="mb-1"><strong>Tipo de servicio: </strong><span
                            class="badge rounded-pill bg-label-danger">{{ $item->tipo_servicio }}</span></p>
                </div>
            </div>
        </div>
        {{--  <div class="card-body" style="font-size: 16px">
            <div class="row">
                <div class="col-md-4">
                    <p class="mb-0"><strong>Item:</strong> {{ $item->articulo }}</p>
                </div>
                <div class="col-md-8">
                    <p class="mb-0"><strong>Daño reportado:</strong> {{ $item->inconveniente }}</p>
                </div>
            </div>
        </div> --}}
    @endforeach
    <div class="card-header">
        <div class="divider">
            <div class="divider-text">COMENTARIOS GENERALES</div>
        </div>
        @php
            echo $comment_g;
        @endphp
    </div>
    <div class="card-header">
        <div class="divider">
            <div class="divider-text">INFORMACIÓN DE VISITA / EVIDENCIAS</div>
            <div class="demo-inline-spacing">
                <button class="btn rounded-pill btn-secondary"
                    onclick="consultarInformacionEvidencias('visita','{{ $id_ost }}','{{ $info_st->estado }}')"
                    type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasStart"
                    aria-controls="offcanvasStart">
                    <span class="tf-icons bx bx-camera me-1"></span>Evidencias
                </button>
            </div>
        </div>
        @php
            echo $comentarios_v;
        @endphp
    </div>
    <div class="card-header divider">
        <div class="divider-text">CONCEPTO EMITIDO POR FÁBRICA</div>
    </div>
    <div class="card-body">
        <ul class="p-0 m-0">
            @foreach ($valoracion as $item)
                <li class="d-flex mb-4 pb-1">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">
                                {{ date('Y-m-d', strtotime($item->created_at)) . ' - ' . $item->observaciones }}</h6>
                            <small class="text-muted">{{ strtoupper($item->concepto) }}</small>
                        </div>
                        <div class="user-progress">
                            <small class="fw-medium">- {{ $item->responsable }}</small>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="card-header">
        <div class="divider">
            <div class="divider-text">INFORMACIÓN DE RECOGIDA / ELEMENTOS RECOGIDOS</div>
            <div class="demo-inline-spacing">
                <button class="btn rounded-pill btn-secondary"
                    onclick="consultarInformacionEvidencias('recogida','{{ $id_ost }}','{{ $info_st->estado }}')"
                    type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasStart"
                    aria-controls="offcanvasStart">
                    <span class="tf-icons bx bx-camera me-1"></span>Evidencias
                </button>
            </div>
        </div>
        @foreach ($recogida as $item)
            <div class="card">
                <div class="card-body">
                    <div class="card-title">{{ $item->elementos_recogidos }}</div>
                    <div class="card-text">{{ $item->observaciones_r }}</div>
                    <div class="mt-2 text-muted"><small>{{ $item->created_at }}</small></div>
                    <div class="text-muted">- <small>{{ $item->responsable }}</small></div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="card-header">
        <div class="divider">
            <div class="divider-text">INFORMACIÓN DE INGRESO / SALIDA DE TALLER</div>
            <div class="demo-inline-spacing">
                <button class="btn rounded-pill btn-secondary"
                    onclick="consultarInformacionEvidencias('taller_ingreso','{{ $id_ost }}','{{ $info_st->estado }}')"
                    type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasStart"
                    aria-controls="offcanvasStart">
                    <span class="tf-icons bx bx-camera me-1"></span>Evidencias ingreso
                </button>
                <button class="btn rounded-pill btn-danger"
                    onclick="consultarInformacionEvidencias('taller_reparado','{{ $id_ost }}','{{ $info_st->estado }}')"
                    type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasStart"
                    aria-controls="offcanvasStart">
                    <span class="tf-icons bx bx-camera me-1"></span>Evidencias reparado
                </button>
            </div>
        </div>
        <div class="row">
            @php
                $s_ = !empty($info_t->observaciones_salida) ? true : false;
            @endphp
            @if (!empty($info_t->orden_taller))
                <div class="col-md-{{ $s_ ? '6' : '12' }} mb-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Ingreso</div>
                            <span><strong>ORDEN TALLER: <u>{{ $info_t->orden_taller }}</u></strong></span>
                        </div>
                        <div class="card-body">
                            <div class="card-text">{{ $info_t->observaciones_ingreso }}</div>
                            <div class="mt-2 text-muted"><small>{{ $info_t->created_at }}</small></div>
                            <div class="text-muted"><small>{{ $info_t->estado }}</small></div>
                            <div class="text-muted">- <small>{{ $info_t->responsable_ingreso }}</small></div>
                        </div>
                    </div>
                </div>
                @if ($s_)
                    <div class="col-md-6 mb-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">Salida</div>
                                <div class="card-text">{{ $info_t->observaciones_salida }}</div>
                                <div class="mt-2 text-muted"><small>{{ $info_t->updated_at }}</small></div>
                                <div class="text-muted">- <small>{{ $info_t->responsable_salida }}</small></div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <div class="card-header">
        <div class="divider">
            <div class="divider-text">GESTIÓN REALIZADA EN TALLER</div>
        </div>
        @php
            echo $seguimientos;
        @endphp
    </div>
    <div class="card-header">
        <div class="divider">
            <div class="divider-text">RESPUESTA EMITIDA POR FÁBRICA</div>
        </div>
        @foreach ($carta_respuesta as $item)
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <p>Concepto: {{ strtoupper($item->concepto) }}</p>
                        @if (
                            ((Auth::user()->almacen == 'SERVICIO TECNICO FAB' ||
                                Auth::user()->almacen == 'FABRICA' ||
                                Auth::user()->almacen == 'PPAL') &&
                                Auth::user()->rol == '1' &&
                                $item->estado != 1) ||
                                Auth::user()->permisos == '4')
                            <button class="btn btn-sm btn-success"
                                onclick="apruebaCartaRespuestaFab('{{ $item->id_respuesta }}','{{ $id_ost }}')"><i
                                    class='bx bx-check'></i></button>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="card-title">Diagnóstico</div>
                            <div class="card-text">{{ $item->diagnostico }}</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="card-title">Solución</div>
                            <div class="card-text">{{ $item->solucion }}</div>
                        </div>
                    </div>
                    <div class="mt-2 text-muted"><small>{{ $item->created_at }}</small></div>
                    <div class="text-muted">- <small>{{ $item->responsable }}</small></div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="card-header divider">
        <div class="divider-text">DEFINICIÓN DEL SERVICIO TÉCNICO</div>
        <div class="demo-inline-spacing">
            <button class="btn rounded-pill btn-secondary" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offDocumentoSoporteSt" aria-controls="offDocumentoSoporteSt">
                <span class="tf-icons bx bx-camera me-1"></span>Documento soporte
            </button>
        </div>
    </div>
    <div class="card-body">
        @php
            echo $com_definir;
        @endphp
    </div>
    <div class="card-header divider">
        <div class="divider-text">FIN - SOLICITUD DE SERVICIO TÉCNICO</div>
    </div>
</div>

<div class="offcanvas offcanvas-start" style="min-width: 600px" tabindex="-1" id="offcanvasStart"
    aria-labelledby="offcanvasStartLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasStartLabel" class="offcanvas-title">Evidencias</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" id="img-evidencias-ost"></div>
</div>

<div class="offcanvas offcanvas-start" style="min-width: 850px" tabindex="-1" id="offDocumentoSoporteSt"
    aria-labelledby="offcanvasStartLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasStartLabel" class="offcanvas-title">Documento soporte de entrega</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @if (empty($url_def))
            @if ($info_st->estado == 'Definido')
                <form id="form-update-definir-ost" enctype="multipart/form-data">
                    <div class="input-group">
                        <input type="text" class="form-control" id="id_ost_definir" name="id_ost_definir"
                            value="{{ $info_st->id_st }}" hidden>
                        <input type="file" class="form-control" id="evidencias_doc_definir"
                            name="evidencias_doc_definir" aria-label="Upload" />
                        <button class="btn btn-outline-danger" type="button"
                            onclick="formUpdateDefinirOrdenServicio()">Cargar</button>
                    </div>
                </form>
            @endif
            <p class="mt-4">Aun no se ha realizado la entrega del producto al cliente</p>
        @else
            <iframe src="{{ asset($url_def) }}" frameborder="0" style="width: 100%; height: 620px"></iframe>
        @endif
    </div>
</div>

<div class="offcanvas offcanvas-top" tabindex="-1" id="infoEvidenciasTaller" aria-labelledby="offcanvasTopLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasTopLabel" class="offcanvas-title">Offcanvas Top</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <p>
            Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print,
            graphic or web designs. The passage is attributed to an unknown typesetter in the 15th
            century who is thought to have scrambled parts of Cicero's De Finibus Bonorum et Malorum
            for use in a type specimen book.
        </p>
        <button type="button" class="btn btn-primary me-2">Continue</button>
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
            Cancel
        </button>
    </div>
</div>
