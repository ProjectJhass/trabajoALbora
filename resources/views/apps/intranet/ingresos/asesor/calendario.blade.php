@extends('apps.intranet.plantilla.app')
@section('title')
    Calendario
@endsection
@section('calendar')
    bg-danger active
@endsection
@section('head')
    <style>
        label {
            color: rgb(116, 116, 116);
            font-size: 13px;
        }
    </style>
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Calendario</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Calendario</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3" hidden>
                    <div class="sticky-top mb-3">

                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <h4 class="card-title">Usuarios agregados</h4>
                            </div>
                            <div class="card-body">
                                <div id="external-events" class="overflow-auto" style="max-width: 300px; max-height: 320px;">
                                    <div class="external-event" data-url="" data-evento="1" data-zona="" data-cedula=""
                                        style="background-color: rgb(10, 136, 138); border-color: rgb(10, 136, 138); color: rgb(255, 255, 255); position: relative;">
                                    </div>
                                    <div class="checkbox" hidden>
                                        <label for="drop-remove">
                                            <input type="checkbox" id="drop-remove" checked>
                                            remove after drop
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Agregar reunión general</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3" hidden>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="A">
                                            <label class="form-check-label" for="inlineRadio1">Asesor</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="R"
                                                checked>
                                            <label class="form-check-label" for="inlineRadio2">Reunión</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3" id="formulario-agregar-nuevo-registro">
                                        <div class="btn-group" style="width: 100%; margin-bottom: 10px;" hidden>
                                            <ul class="fc-color-picker" id="color-chooser">
                                                <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Nombre de la reunión</label>
                                            <input type="text" class="form-control" name="new-event" id="new-event">
                                        </div>
                                        <div class="form-group" id="url-reunion-evento">
                                            <label for="">Url de la reunión</label>
                                            <input type="text" class="form-control" name="url-event" id="url-event">
                                        </div>
                                        <div class="input-group">
                                            <button id="add-new-event" type="button" class="btn btn-danger">Agregar Información</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-sm btn-danger" id="btnAbrirModalFirmarDescanso" onclick="modalFirmarDescansosDom()">Firmar descanso</button>
                                <a href="{{ route('h.firmas.asesor') }}" type="button" class="btn btn-secondary">Certificados</a>
                            </div>
                        </div>
                        <div class="col-md-9 mb-2 text-center">
                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <i class="fas fa-stop" style="color: rgb(10, 136, 138);"></i>&nbsp; Descanso
                                </div>
                                <div class="form-check form-check-inline">
                                    <i class="fas fa-stop" style="color: rgb(245, 105, 84);"></i>&nbsp; Dominical
                                </div>
                                <div class="form-check form-check-inline">
                                    <i class="fas fa-stop" style="color: rgb(220, 53, 69);"></i>&nbsp; Reunión
                                </div>
                                <div class="form-check form-check-inline">
                                    <i class="fas fa-stop" style="color: rgb(255, 193, 7);"></i>&nbsp; Comp. mes ant
                                </div>
                                <div class="form-check form-check-inline">
                                    <i class="fas fa-stop" style="color: rgb(40, 167, 69);"></i>&nbsp; Comp. prox mes
                                </div>
                                <div class="form-check form-check-inline">
                                    <i class="fas fa-stop" style="color: rgb(0, 123, 255);"></i>&nbsp; Comp. adelantado
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalFirmarDescansos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Firmar descansos compensatorios</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formInfoFirmarDescanso" method="post" class="was-validated">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="">Cédula</label>
                                    <input type="text" value="{{ Auth::user()->id }}" readonly class="form-control" name="cedula" id="cedula">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Nombre</label>
                                    <input type="text" value="{{ Auth::user()->nombre }}" readonly class="form-control" name="nombre"
                                        id="nombre">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Departamento</label>
                                    <select class="form-control" onchange="searchInfoCiudades(this.value)" name="departamento" id="departamento"
                                        required>
                                        <option value="">Seleccionar...</option>
                                        @foreach ($deptos as $item)
                                            <option value="{{ $item->id_depto }}" data-depto="{{ $item->depto }}">{{ $item->depto }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Ciudad</label>
                                    <select class="form-control" name="ciudad" id="ciudad" required></select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Centro de experiencia</label>
                                    <select class="form-control" name="almacen" id="almacen" required>
                                        <option value="">Seleccionar...</option>
                                        @foreach ($almacen as $item)
                                            <option value="{{ $item->almacen }}">{{ $item->almacen }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Dominical laborado</label>
                                    <select class="form-control" name="dominical_laborado" id="dominical_laborado" required></select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Día descanso compensatorio</label>
                                    <select class="form-control" name="dia_compensado" id="dia_compensado" required></select>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="">Observaciones</label>
                                    <input type="text" class="form-control" name="observaciones" id="observaciones">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar formulario</button>
                        <button type="button" class="btn btn-danger" onclick="validarFieldsDescanso()">Firmar descanso compensatorio</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalTomarFotografia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <label for="">Dispositivo</label>
                                <select name="listaDeDispositivos" id="listaDeDispositivos" class="form-control"></select>
                            </div>
                            <div class="card-body text-center">
                                <video muted="muted" id="video" style="width: 80%;"></video>
                                <canvas id="canvas" style="display: none;"></canvas>
                            </div>
                            <div class="card-footer text-center">
                                <button type="button" id="boton" class="btn btn-danger">Tomar fotografía</button>
                                <button type="button" id="cerrarModalFotoGrafia" class="btn btn-secondary" data-dismiss="modal">Cerrar
                                    ventana</button>
                                <p id="estado"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="actualizar-programacion-calendario">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Información del evento <span id="estadoFirmaDominical"></span> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="was-validated" id="formulario-actualizar-info-prog-cal" autocomplete="off">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Nombre</label>
                                    <input type="text" readonly class="form-control" id="nombre_prog_cal" name="nombre_prog_cal">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Fecha inicio</label>
                                    <input type="date" readonly class="form-control" id="fecha_i_prog_cal" name="fecha_i_prog_cal">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Fecha final</label>
                                    <input type="date" readonly class="form-control" id="fecha_f_prog_cal" name="fecha_f_prog_cal">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCity">Evento</label>
                                    <select readonly name="tipo_evento_prog_cal" id="tipo_evento_prog_cal" class="form-control">
                                        <option value="">Seleccionar...</option>
                                        <option value="1">Descanso</option>
                                        <option value="2">Dominical</option>
                                        <option value="4">Compensatorio mes anterior</option>
                                        <option value="5">Compensatorio próximo mes</option>
                                        <option value="6">Compensatorio adelantado</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputState">Asesor quien reemplaza</label>
                                    <input type="text" readonly class="form-control" name="cedula_reemplaza_prog" id="cedula_reemplaza_prog">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress2">Observación</label>
                                <textarea readonly name="observacion_evento_cal" class="form-control" id="observacion_evento_cal" placeholder="Observaciones de la programación"
                                    cols="30" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-danger" id="btnFirmarDesdeModal" onclick="firmarFechaDescansoModal()"><i
                                class="fas fa-edit"></i> Firmar fecha</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar información</button>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('footer')
    <script>
        firmarFechaDescansoModal = () => {
            var fecha = $("#fecha_i_prog_cal").val()
            var evento = $("#tipo_evento_prog_cal").val()

            $("#actualizar-programacion-calendario").modal("hide")
            $("#btnAbrirModalFirmarDescanso").click()

            setTimeout(() => {
                if (evento == 1) {
                    $('#dia_compensado option[data-fecha="' + fecha + '"]').prop('selected', true);
                }
                if (evento == 2) {
                    $('#dominical_laborado option[data-fecha="' + fecha + '"]').prop('selected', true);
                }
            }, 1000);
        }

        $(() => {
            /* initialize the external events
                        -----------------------------------------------------------------*/
            function ini_events(ele, url, accion) {
                ele.each(function() {

                    var eventObject = {
                        title: $.trim($(this).text()),
                        url: url,
                        accion: accion
                    }

                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject)

                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex: 1070,
                        revert: true, // will cause the event to go back to its
                        revertDuration: 0 //  original position after the drag
                    })

                })
            }

            ini_events($('#external-events div.external-event'), '', '')

            /* initialize the calendar
             -----------------------------------------------------------------*/
            var date = new Date()
            var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear()

            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendar.Draggable;

            var containerEl = document.getElementById('external-events');
            var checkbox = document.getElementById('drop-remove');
            var calendarEl = document.getElementById('calendar');

            // initialize the external events
            // -----------------------------------------------------------------

            new Draggable(containerEl, {
                itemSelector: '.external-event',
                eventData: function(eventEl) {
                    return {
                        title: eventEl.innerText,
                        url: $(eventEl).attr('data-url'),
                        evento: $(eventEl).attr('data-evento'),
                        cedula_u: $(eventEl).attr('data-cedula'),
                        zona: $(eventEl).attr('data-zona'),
                        backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                        borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                        textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
                    };
                }
            });

            var calendar = new Calendar(calendarEl, {

                headerToolbar: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },
                locales: 'es',
                themeSystem: 'bootstrap',
                //Random default events
                events: [
                    <?php foreach($eventos as $key => $value){ ?> {
                        id: '{{ $value->id_evento }}',
                        title: '<?php echo $value->nombre_evento; ?>',
                        start: '<?php echo $value->fecha_i; ?>',
                        end: '<?php echo $value->fecha_f; ?>',
                        backgroundColor: '<?php echo $value->color; ?>', //red
                        borderColor: '<?php echo $value->border_color; ?>', //red
                        url: '<?php echo $value->url; ?>',
                        extendedProps: {
                            cedula_u: '',
                            evento: '<?php echo $value->tipo_evento; ?>',
                            obs: '<?php echo $value->observaciones; ?>',
                            ced_reem: '<?php echo $value->cedula_reemplaza; ?>',
                            nom_reem: '<?php echo $value->nombre_reemplaza; ?>',
                            fecha_i: '<?php echo $value->fecha_i; ?>',
                            fecha_f: '<?php echo date('Y-m-d', strtotime($value->fecha_f . '-1 days')); ?>',
                            bloqueado: '<?php echo $value->bloqueado; ?>',
                            firmar: '<?php echo $value->firmar; ?>'
                        },
                        allDay: true
                    },
                    <?php } ?>
                ],
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar !!!
                eventClick: function(info) {
                    if (info.event._def.extendedProps.bloqueado == '0') {
                        if ((info.event._def.extendedProps.evento) !== undefined && (info.event._def.extendedProps.evento) != 3) {
                            $('#actualizar-programacion-calendario').modal('show');
                            $('#id_prog_cal').val(info.event._def.publicId);
                            $('#nombre_prog_cal').val(info.event._def.title);
                            $('#fecha_i_prog_cal').val(info.event._def.extendedProps.fecha_i);
                            $('#fecha_f_prog_cal').val(info.event._def.extendedProps.fecha_f);
                            $('#url_prog_cal').val(info.event._def.url);
                            $('#tipo_evento_prog_cal').val(info.event._def.extendedProps.evento);
                            $('#cedula_reemplaza_prog').val(info.event._def.extendedProps.nom_reem);
                            $('#observacion_evento_cal').val(info.event._def.extendedProps.obs);

                            var firmar_ = info.event._def.extendedProps.firmar
                            if (firmar_ == "firmado") {
                                var title = '<span class="badge badge-success">Fecha firmada</span>';
                                document.getElementById("btnFirmarDesdeModal").hidden = true
                            } else {
                                var title = '<span class="badge badge-danger">Fecha sin firmar</span>';
                                var mes_ = (m + 1);
                                mes_ = mes_ > 9 ? mes_ : "0" + mes_;
                                var hoy_ = y + "-" + mes_ + "-" + d;
                                if (info.event._def.extendedProps.fecha_i > hoy_) {
                                    document.getElementById("btnFirmarDesdeModal").hidden = true
                                } else {
                                    document.getElementById("btnFirmarDesdeModal").hidden = false
                                }
                            }
                            $("#estadoFirmaDominical").html(title)
                        }
                    }
                }
            });

            calendar.render();

            var currColor = '#dc3545'
            $('#color-chooser > li > a').click(function(e) {
                e.preventDefault()
                currColor = $(this).css('color')
                $('#add-new-event').css({
                    'background-color': currColor,
                    'border-color': currColor,
                })
            });
            $('#add-new-event').click(function(e) {
                e.preventDefault()
                var val = $('#new-event').val()
                var url = $('#url-event').val();
                var tipo = $('input:radio[name=inlineRadioOptions]:checked').val();
                switch (tipo) {
                    case 'A':
                        var tipo_ = '1';

                        break;
                    case 'R':
                        var tipo_ = '2';

                        break;

                    default:
                        var tipo_ = '2';
                        break;
                }

                if (val.length == 0) {
                    return
                }
                var event = $('<div />');

                event.css({
                    'background-color': currColor,
                    'border-color': currColor,
                    'color': '#fff',
                }).addClass('external-event')

                event.attr('data-url', url);
                event.attr('data-evento', '3');
                event.attr('data-zona', {{ Auth::user()->zona }});

                event.text(val);

                $('#external-events').prepend(event)
                ini_events(event, url, tipo_)
                $('#new-event').val('')
                $('#url-event').val('')
            });
        });

        modalFirmarDescansosDom = () => {

            $("#modalFirmarDescansos").modal("show")

            var datos = $.ajax({
                type: "post",
                url: "{{ route('datos.descansodom') }}",
                dataType: "json",
                data: {
                    dato: 1
                }
            })
            datos.done((res) => {
                $("#dominical_laborado").html(res.dominicales)
                $("#dia_compensado").html(res.descansos)
            })
        }

        searchInfoCiudades = (valor) => {
            var datos = $.ajax({
                url: "{{ Route('ciudades.consultar') }}",
                type: "POST",
                dataType: "json",
                data: {
                    id: valor
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    $('#ciudad').html(res.ciudad);
                }
            });
        }

        tomarFotografiaDescanso = () => {

            document.getElementById("boton").hidden = false;
            $("#cerrarModalFotoGrafia").text("Cerrar ventana")

            function tieneSoporteUserMedia() {
                return !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator
                    .webkitGetUserMedia || navigator.msGetUserMedia)
            }

            function _getUserMedia() {
                return (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator
                    .webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);
            }

            // Declaramos elementos del DOM
            const $video = document.querySelector("#video"),
                $canvas = document.querySelector("#canvas"),
                $boton = document.querySelector("#boton"),
                $estado = document.querySelector("#estado"),
                $listaDeDispositivos = document.querySelector("#listaDeDispositivos");

            // La función que es llamada después de que ya se dieron los permisos
            // Lo que hace es llenar el select con los dispositivos obtenidos
            const llenarSelectConDispositivosDisponibles = () => {

                navigator
                    .mediaDevices
                    .enumerateDevices()
                    .then(function(dispositivos) {
                        const dispositivosDeVideo = [];
                        dispositivos.forEach(function(dispositivo) {
                            const tipo = dispositivo.kind;
                            if (tipo === "videoinput") {
                                dispositivosDeVideo.push(dispositivo);
                            }
                        });

                        // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
                        if (dispositivosDeVideo.length > 0) {
                            // Llenar el select
                            dispositivosDeVideo.forEach(dispositivo => {
                                const option = document.createElement('option');
                                option.value = dispositivo.deviceId;
                                option.text = dispositivo.label;
                                $listaDeDispositivos.appendChild(option);
                                console.log("$listaDeDispositivos => ", $listaDeDispositivos)
                            });
                        }
                    });
            }

            (function() {
                // Comenzamos viendo si tiene soporte, si no, nos detenemos
                if (!tieneSoporteUserMedia()) {
                    alert("Lo siento. Tu navegador no soporta esta característica");
                    $estado.innerHTML = "Parece que tu navegador no soporta esta característica. Intenta actualizarlo.";
                    return;
                }
                //Aquí guardaremos el stream globalmente
                let stream;


                // Comenzamos pidiendo los dispositivos
                navigator
                    .mediaDevices
                    .enumerateDevices()
                    .then(function(dispositivos) {
                        // Vamos a filtrarlos y guardar aquí los de vídeo
                        const dispositivosDeVideo = [];

                        // Recorrer y filtrar
                        dispositivos.forEach(function(dispositivo) {
                            const tipo = dispositivo.kind;
                            if (tipo === "videoinput") {
                                dispositivosDeVideo.push(dispositivo);
                            }
                        });

                        // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
                        // y le pasamos el id de dispositivo
                        if (dispositivosDeVideo.length > 0) {
                            // Mostrar stream con el ID del primer dispositivo, luego el usuario puede cambiar
                            mostrarStream(dispositivosDeVideo[0].deviceId);
                        }
                    });



                const mostrarStream = idDeDispositivo => {
                    _getUserMedia({
                            video: {
                                // Justo aquí indicamos cuál dispositivo usar
                                deviceId: idDeDispositivo,
                            }
                        },
                        function(streamObtenido) {
                            // Aquí ya tenemos permisos, ahora sí llenamos el select,
                            // pues si no, no nos daría el nombre de los dispositivos
                            llenarSelectConDispositivosDisponibles();

                            // Escuchar cuando seleccionen otra opción y entonces llamar a esta función
                            $listaDeDispositivos.onchange = () => {
                                // Detener el stream
                                if (stream) {
                                    stream.getTracks().forEach(function(track) {
                                        track.stop();
                                    });
                                }
                                // Mostrar el nuevo stream con el dispositivo seleccionado
                                mostrarStream($listaDeDispositivos.value);
                            }

                            // Simple asignación
                            stream = streamObtenido;

                            // Mandamos el stream de la cámara al elemento de vídeo
                            $video.srcObject = stream;
                            $video.play();

                            //Escuchar el click del botón para tomar la foto
                            $boton.addEventListener("click", function() {

                                document.getElementById("boton").hidden = true;
                                $("#cerrarModalFotoGrafia").text("Tomar nuevamente")

                                //Pausar reproducción
                                $video.pause();

                                //Obtener contexto del canvas y dibujar sobre él
                                let contexto = $canvas.getContext("2d");
                                $canvas.width = $video.videoWidth;
                                $canvas.height = $video.videoHeight;

                                contexto.clearRect(0, 0, $canvas.width, $canvas.height);

                                contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

                                let foto = $canvas.toDataURL(); //Esta es la foto, en base 64

                                var datos_ = $.ajax({
                                    type: "POST",
                                    url: "{{ route('guardar.foto') }}",
                                    dataType: "json",
                                    data: encodeURIComponent(foto),

                                });

                                datos_.done((res) => {
                                    if (res.status == true) {
                                        sendInfoGeneralFormDescanso(res.name, res.url)
                                    }
                                })
                            });
                        },
                        function(error) {
                            console.log("Permiso denegado o error: ", error);
                            $estado.innerHTML = "No se puede acceder a la cámara, o no diste permiso.";
                        });
                }
            })();
        }

        validarFieldsDescanso = () => {
            var depto = $("#departamento").val()
            var ciudad = $("#ciudad").val()
            var almacen = $("#almacen").val()
            var dominical = $("#dominical_laborado").val()
            var descanso = $("#dia_compensado").val()
            if (depto.length > 0 && ciudad.length > 0 && almacen.length > 0) {
                if (dominical.length > 0 || descanso.length > 0) {
                    $("#modalTomarFotografia").modal("show")
                    tomarFotografiaDescanso()
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Debes seleccionar por lo menos una fecha',
                        showConfirmButton: false,
                        timer: 2000,
                        toast: true
                    });
                }
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Revisa la información y vuelve a intentar',
                    showConfirmButton: false,
                    timer: 2000,
                    toast: true
                });
            }
        }

        sendInfoGeneralFormDescanso = (name, url) => {

            Swal.fire({
                position: 'top-end',
                icon: 'warning',
                title: 'Guardando información, por favor espere...',
                showConfirmButton: false,
                timer: 10000,
                toast: true
            });

            var dataDepto = $('#departamento option:selected').data('depto');

            var formData = new FormData(document.getElementById('formInfoFirmarDescanso'));
            formData.append('img', name);
            formData.append('url', url);
            formData.append('depto', dataDepto);

            var datos = $.ajax({
                url: "{{ route('guardar.info.firma') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
            })
            datos.done((res) => {

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: '¡BIEN! Información guardada exitosamente',
                    showConfirmButton: false,
                    timer: 2000,
                    toast: true
                });

                setTimeout(() => {
                    window.location.reload()
                }, 1500);
            })
        }
    </script>
@endsection
