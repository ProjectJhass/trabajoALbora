@extends('apps.intranet_fabrica.layout_fabrica.app')
@section('title')
    PQRS pendientes
@endsection
@section('menu-calidad')
    menu-open
@endsection
@section('menu-pqrs')
    menu-open
@endsection
@section('active-calidad')
    bg-danger active
@endsection
@section('active-pqrs')
    active
@endsection
@section('fabrica-body')
    @php
        $data = $data->first();
    @endphp
    <section class="content" style="background-color: #f4f6f9">
        <div class="container-fluid">
            <section class="content" style="width: 80%; margin: 1% 10%">
                <div class="container-fluid" style="padding: 7.5px">
                    <form id="respuesta-pqrs" name="formulario-pqrs" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-outline card-secondary">
                                    <div class="card-header">
                                        <div class="row text-center">
                                            <div class="col-md-6 mb-3" style="border: 1px solid; border-radius: 12px;">
                                                <div class="mt-1">
                                                    <img src="{{ asset('img/blanco.png') }}" width="50%"
                                                        alt="Logo Muebles Albura">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3" style="border: 1px solid; border-radius: 12px;">
                                                <h5><strong>PETICIONES, QUEJAS, RECLAMOS<br> Y SUGERENCIAS -
                                                        P.Q.R.S</strong></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="border: 1px solid; border-radius: 7px;">
                                                        <center>
                                                            CÓDIGO:RG-PRD-20
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="border: 1px solid; border-radius: 7px;">
                                                        <center>
                                                            VERSIÓN: 06
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="border: 1px solid; border-radius: 7px;">
                                                        <center>
                                                            PÁGINA: 1
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-7 col-sm-12 col-12">
                                                <div class="form-group" style=" margin-left:15%; text-align:justify;">
                                                    El deseo de petición, queja, reclamo y sugerencia presentada por
                                                    el
                                                    interesado , será atendido de manera oportuna como compromiso
                                                    hacia
                                                    nuestros clientes por parte de Muebles Albura.
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <center>
                                                    <label for="id">Consecutivo:</label>
                                                    <input type="text" id="id" name="id"
                                                        value="{{ $data->id }}" style="border: none; width:15%"
                                                        disabled=""> <br>

                                                    <label for="fecha">Fecha:</label>
                                                    <input type="text" id="fecha" name="{{ $data->fecha }}"
                                                        value="2024-06-17" style="border: none; width:35%" disabled="">
                                                </center>
                                            </div>

                                        </div>
                                        <div class="row" style="margin-top: 2%;">
                                            <div class="col-md-12">
                                                <div class="form-group"
                                                    style="border: 1px solid; border-radius: 7px; padding:1%;">
                                                    <center>
                                                        <strong>
                                                            DATOS PERSONALES
                                                        </strong>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nombres">Nombres</label>
                                                    <input type="text" class="form-control" id="nombres" name="nombres"
                                                        value="{{ $data->nombres }}" disabled="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="apellidos">Apellidos</label>
                                                    <input type="text" class="form-control" id="apellidos"
                                                        name="apellidos" value="{{ $data->apellidos }}" disabled="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cargo">cargo</label>
                                                    <input type="text" class="form-control" id="cargo" name="cargo"
                                                        value="{{ $data->cargo }}" disabled="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        value="{{ $data->email }}" autocomplete="off" disabled="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 2%;">
                                            <div class="col-md-12">
                                                <div class="form-group"
                                                    style="border: 1px solid; border-radius: 7px; padding:1%;">
                                                    <center>
                                                        <strong>
                                                            SOLICITUD
                                                        </strong>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tipo">Tipo</label>
                                                    <input type="text" class="form-control" id="tipo"
                                                        name="tipo" value="{{ $data->tipo_solicitud }}"
                                                        disabled="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lugar">Lugar</label>
                                                    <input type="text" class="form-control" id="lugar"
                                                        name="lugar" value="{{ $data->lugar }}" disabled="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="hora">Hora</label>
                                                    <input type="text" class="form-control" id="hora"
                                                        name="hora" value="{{ $data->hora }}" disabled="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 2%;">
                                            <div class="col-md-12">
                                                <div class="form-group"
                                                    style="border: 1px solid; border-radius: 7px; padding:1%;">
                                                    <center>
                                                        <strong>
                                                            descripcion DE LA SOLICITUD
                                                        </strong>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <textarea class="form-control" id="descripcion" name="descripcion" disabled="">{{ $data->descripcion }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 2%;">
                                            <div class="col-md-12">
                                                <div class="form-group"
                                                    style="border: 1px solid; border-radius: 7px; padding:1%;">
                                                    <center>
                                                        <strong>
                                                            CARGA DE ANEXOS
                                                        </strong>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            @if (count($data->infoAnexos) > 0)
                                                @foreach ($data->infoAnexos as $anexo)
                                                    <a href="../storage/archivos/{{ $anexo->nombre }}"
                                                        target="_blank">{{ $anexo->nombre }}</a>
                                                    <hr>
                                                @endforeach
                                            @else
                                                No hay archivos adjuntos para esta solicitud.
                                            @endif
                                        </div>
                                        <div class="row" style="margin-top: 2%;">
                                            <div class="col-md-12">
                                                <div class="form-group"
                                                    style="border: 1px solid; border-radius: 7px; padding:1%;">
                                                    <center>
                                                        <strong>
                                                            RESPUESTA A LA P.Q.R.S
                                                        </strong>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    @if (count($data->infoRespuestas) > 0)
                                                        @php
                                                            $respuesta = $data->infoRespuestas->first();
                                                        @endphp
                                                        <textarea readonly cols="30" class="form-control" rows="10">{{ $respuesta->respuesta }}</textarea>
                                                    @else
                                                        <textarea class="form-control" cols="30" rows="5" id="respuesta" name="respuesta"
                                                            placeholder="Escriba su respuesta."></textarea>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if (count($data->infoRespuestas) == 0)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <center>
                                                        <button id="responderSolicitudBtn" type="button" class="btn btn-danger"
                                                            style="margin-top: 2%;"
                                                            onclick="responderSolicitud()">Enviar
                                                            respuesta
                                                        </button>
                                                    </center>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-md-8 col-sm-8 col-8">
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-4">
                                                <img src="{{ asset('img/copia_controlada_sgc.png') }}"
                                                    alt="Copia Controlada S.G.C" width="90%">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </section>
@endsection
<script>
    function responderSolicitud() {
        toastr.info('Enviando respuesta');
        $("body").css("cursor", "progress");
        var btn = document.getElementById('responderSolicitudBtn');
        btn.disabled = true;
        var respuesta = $("#respuesta").val()
        var id = $("#id").val()
        var data = $.ajax({
            type: "post",
            url: window.location.href,
            dataType: "json",
            data: {
                respuesta,
                id
            }
        })
        data.done((res) => {
            if(res.status == true){
                toastr.success('Respuesta guardada y enviada correctamente')
                $("body").css("cursor", "default");
            }
            btn.hidden = true;
            $("#respuesta").attr('disabled', true);
        })
        data.fail((err) => {
            toastr.error('Hubo un problema al responder la solicitud')
            $("body").css("cursor", "default");
            btn.disabled = false;
        })
    }
</script>
