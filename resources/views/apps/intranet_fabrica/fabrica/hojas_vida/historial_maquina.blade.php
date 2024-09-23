@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    Solicitudes Mtto
@endsection
@section('menu-mtto')
    menu-open
@endsection
@section('active-mtto')
    bg-danger active
@endsection
@section('hojas-de-vida')
    active
@endsection
@section('tables-bootstrap-css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hojas_de_vida.css') }}">
@endsection
@section('fabrica-body')
    @php
        $info_g = $historialMaquina->first();
        $maq =
            strpos($info_g->maquina ?? '', '-') !== false
                ? explode('-', $info_g->maquina ?? '')
                : $info_g->maquina ?? '';
        $maquina_ = is_array($maq) ? trim($maq[0]) . '-' . trim($maq[1]) : $maq ?? '';
    @endphp
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{ route('hojas.vida') }}" style="font-size: 30px">
                        <i class="far fa-arrow-alt-circle-left" style="color: #ff0000;"></i>
                    </a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('hojas.vida') }}">Historial</a></li>
                        <li class="breadcrumb-item active">hojas de vida</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="card card-outline card-danger p-0 m-0">
            <div class="card-header">
                <div class="row text-center">
                    <div class="col-md-6 mb-3" style="border: 1px solid; border-radius: 12px;">
                        <img src="{{ asset('img/BLANCO.png') }}" width="50%" alt="">
                    </div>
                    <div class="col-md-6 mb-3" style="border: 1px solid; border-radius: 12px;">
                        <h5><strong>HOJAS DE VIDA <br> MÁQUINAS-EQUIPOS-HERRAMIENTAS</strong></h5>
                    </div>
                    <div class="col-md-4" style="border: 1px solid; border-radius: 12px;">
                        <strong>CÓDIGO: RG-MTO-05</strong>
                    </div>
                    <div class="col-md-4" style="border: 1px solid; border-radius: 12px;">
                        <strong>VERSIÓN: 04</strong>
                    </div>
                    <div class="col-md-4" style="border: 1px solid; border-radius: 12px;">
                        <strong>PÁGINA: 1</strong>
                    </div>
                </div>
                <hr>
            </div>
        </div>
        <div class="card card-outline card-danger">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex justify-content-center w-100">
                    <h3 class="card-title"><strong>Maquina: {{ $maquina_ }}</strong></h3>
                </div>
                <div class="card-tools">
                    <div style="padding: 5px; color: black; font-weight: bold; text-align: center;">
                        Copia Controlada <br> S.G.C
                    </div>
                </div>
            </div>
            <div class="card-body" style="display: block;">
                <div class="d-flex justify-content-between">
                    <button class="btn btn-danger shadow" data-toggle="modal"
                        onclick="$('#filtroFechasMaquina').modal('toggle')"><i class="fas fa-filter"></i>
                        Filtrar</button>
                    <button class="btn btn-danger shadow" data-toggle="modal"
                        onclick="$('#documentoFechasMaquina').modal('toggle')"><i class="fas fa-print"></i>
                        Informes</button>
                    <button onclick="mostrarHistorial('{{ route('mostrar.mantenimiento') }}', '{{ $referencia }}')"
                        class="btn btn-danger shadow" data-toggle="modal" data-target="#staticBackdrop"><i
                            class="fas fa-stopwatch"></i> Realizados</button>
                </div>
                <hr>
                <div class="row">
                    {{-- procedimientos realizados --}}
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-12" id="procedimientos_realizdos">
                                @foreach ($historialMaquina as $historial)
                                    <div class="post">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm"
                                                src="{{ asset('img/mantenimiento.png') }}" alt="user image">
                                            <span class="username">
                                                <div><b>Descripción del requerimiento: </b> <b
                                                        class="text-primary">{{ $historial->solicitud }}</b></div>
                                            </span>
                                            <span class="description">
                                                <b>Responsable: </b>{{ $historial->responsable_s }} <br>
                                                <b>Fecha: </b>{{ $historial->fecha_solicitud }}
                                            </span>
                                        </div>
                                        <div class="pl-5">
                                            <p style="margin-bottom: 0">
                                                <b>Solución</b> <br>
                                                {{ $historial->respuesta_solicitud }}
                                            </p>
                                            <span class="description mt-3" style="font-size: 13px;">
                                                Responsable: {{ $historial->responsable_respuesta }} <br>
                                                Fecha: {{ $historial->fecha_respuesta }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- chat comentarios --}}
        <button id="openChat" class="btn btn-danger  back-to-top" onclick="abrirChat()">
            <i class="fas fa-comment"></i> Comentarios
        </button>

        <div class="card chat-modal" id="chatModal">
            <div class="card-header row">
                <div class="col-6">
                    <h5>Comentarios</h5>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <a type="button" id="closeChat" onclick="cerrarChat()">
                        <i class="fas fa-times-circle" style="color: #ff0000; font-size: 25px"></i>
                    </a>
                </div>
            </div>
            <div class="card-body" id="chatComentarioBody">
                <div class="col-12 col-md-12" id="divComantarios">
                    @foreach ($comentarios as $comentario)
                        <div class="direct-chat-text m-0 mb-2" id="comentario">
                            {{ $comentario->comentario }}
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer" style="background-color: white">
                <form id="agregarComaentarios">
                    @csrf
                    <input type="hidden" id="id_maquina" name="id_maquina" value="{{ $referencia }}">
                    <div class="row">
                        <div class="form-group col-11">
                            <input type="text" class="form-control form-control-border border-width-2" id="comentario"
                                name="comentario" placeholder="Escribir un comentario">
                        </div>
                        <div class="col-1 mt-2 d-flex justify-content-end">
                            <a type="button" title="Guardar Comentario" onclick="guardarComentario()"
                                style="cursor: pointer;"><i class="far fa-paper-plane pt-2"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" style="font-family: sans-serif">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color: whitesmoke;">
                    <h5 class="modal-title " id="mantenices_ready">Historial de mantenimientos programados</h5>
                    <button onclick="format()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="historial_mantenimientos" style="color: #697a8d;">
                        <div class="modal-footer" class="row">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                    class="fa-solid fa-circle-xmark"></i>Cerrar</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="filtroFechasMaquina" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filtrar información por fecha</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="row" id="filtrarProcedimientos">
                        @csrf
                        <input type="hidden" value="{{ $referencia }}" name="referencia">
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlInput1">Fecha Inicial:</label>
                            <input type="date" class="form-control form-control-sm" id="fechaInicial"
                                name="fechaInicial">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlInput1">Fecha Final:</label>
                            <input type="date" class="form-control form-control-sm" id="fechaFinal"
                                name="fechaFinal">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger shadow" onclick="procedimientosPorFechas()"><i
                            class="fas fa-search"></i> Filtrar por
                        fecha</button>
                    <a href="{{ route('historial.maquina', ['referencia' => $referencia]) }}" type="button"
                        class="btn btn-danger shadow"><i class="fas fa-history"></i> Mostrar todo</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="documentoFechasMaquina" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="exampleModalLabel">Documento SGC por fecha</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="row" id="documentoPlanificadoMantt">
                        @csrf
                        <input type="hidden" value="{{ $referencia }}" id="referencia_documento_sgc"
                            name="referencia">
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlInput1">Fecha Inicial:</label>
                            <input type="date" class="form-control form-control-sm" id="fechaInicial_documento_sgc"
                                name="fechaInicial">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlInput1">Fecha Final:</label>
                            <input type="date" class="form-control form-control-sm" id="fechaFinal_documento_sgc"
                                name="fechaFinal">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger shadow" onclick="procedimientoImpresionDocumento()"><i
                            class="fas fa-print"></i> Imprimir documento</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function procedimientosPorFechas() {
            let formulario = document.getElementById('filtrarProcedimientos');
            let formData = new FormData(formulario);
            $.ajax({
                url: "{{ route('historial.fechas') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#filtroFechasMaquina").modal("toggle")
                    formulario.reset()
                    $('#procedimientos_realizdos').html(response.historialMaquina);
                },
                error: function(error) {
                    Swal.fire({
                        text: error.responseJSON.mensaje,
                        icon: "error",
                        showConfirmButton: false,
                        position: "top-end",
                        timer: 5000,
                        toast: true,
                    });
                }
            })

        }

        function mostrarHistorial(url, referencia) {

            let fecha_i = document.getElementById("fechaInicial").value;
            let fecha_f = document.getElementById("fechaFinal").value;

            if (fecha_i != '' && fecha_f != '') {

                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "json",
                    data: {
                        referencia: referencia,
                        fecha_i: fecha_i,
                        fecha_f: fecha_f
                    },

                }).done(function(res) {
                    if (res) {
                        let title_ready = "Mantenimientos realizados entre " + fecha_i + " Y " + fecha_f;
                        document.getElementById('mantenices_ready').innerHTML = title_ready;
                        let contenidos = document.getElementById("historial_mantenimientos");
                        contenidos.innerHTML = res.contenido;
                    }
                });

            } else {
                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "json",
                    data: {
                        referencia: referencia,
                    },

                }).done(function(res) {

                    if (res) {
                        let contenidos = document.getElementById("historial_mantenimientos");
                        contenidos.innerHTML = res.contenido;
                    }
                });
            }
        }

        function format() {
            document.getElementById("mantenices_ready").innerHTML = 'Historial de mantenimientos programados.';
            document.getElementById("fechaInicial").value = '';
            document.getElementById("fechaFinal").value = '';
        }

        function guardarComentario() {
            let formulario = document.getElementById('agregarComaentarios');
            let formData = new FormData(formulario);
            $.ajax({
                url: "{{ route('guardar.comentario') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    var nuevoElemento = $('<div>', {
                        'class': 'direct-chat-text m-0 mb-2',
                        'id': 'comentario',
                        'text': response.comentario
                    });
                    $('#divComantarios').append(nuevoElemento);
                    $("#agregarComaentarios")[0].reset();
                    Swal.fire({
                        text: "Se agrego correctamente",
                        icon: "success",
                        showConfirmButton: false,
                        position: "top-end",
                        timer: 5000,
                        toast: true,
                    });
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

        function abrirChat() {
            var chatModal = document.getElementById('chatModal');
            if (chatModal.style.display === 'block') {
                chatModal.style.display = 'none';
            } else {
                chatModal.style.display = 'block';
            }
        }

        function cerrarChat() {
            document.getElementById('chatModal').style.display = 'none';
        }

        const procedimientoImpresionDocumento = () => {

            let referencia = $('#referencia_documento_sgc').val();
            let fecha_inicial = $('#fechaInicial_documento_sgc').val();
            let fecha_final = $('#fechaFinal_documento_sgc').val();

            var url_p =
                `{{ route('intranet_fabrica.mantenimientos.hojas_de_vida.maquinas', ['referencia' => 'REFERENCIA_MAQUINA', 'fechaInicial' => 'FECHA_INI', 'fechaFinal' => 'FECHA_FIN']) }}`
            url_p = url_p.replace("REFERENCIA_MAQUINA", referencia)
            url_p = url_p.replace("FECHA_INI", fecha_inicial)
            url_p = url_p.replace("FECHA_FIN", fecha_final)
            var ventana = window.open(url_p, `SOLICITUDES_DE_MANTENIMIENTO_MAQUINA_${ referencia }`);

            ventana.onload = function() {
                ventana.print();
            };

            ventana.addEventListener("afterprint", function(event) {
                ventana.close();
            });
        }
    </script>
@endsection
