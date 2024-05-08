@extends('apps.intranet.plantilla.app')
@section('title')
    Ingresos y Salidas
@endsection
@section('menu-ingresos')
    menu-open
@endsection
@section('section-menu')
    bg-danger active
@endsection
@section('dominicales')
    bg-secondary active
@endsection
@section('body')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Dominicales y descansos</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">Ingresos y salidas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="sticky-top mb-3">
                        <div class="card card-outline card-danger">
                            <div class="card-body">
                                <form method="post">
                                    @csrf
                                    <div class="form-row align-items-center">
                                        <div class="col-sm-12 my-1">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Zona</div>
                                                </div>
                                                <select name="buscar_zona" id="buscar_zona" onchange="BuscarInfoZona()" class="form-control"
                                                    id="inlineFormInputGroupUsername">
                                                    <option value="{{ $zona_ }}">{{ $zona_ == '1' ? 'Centro' : 'Norte' }}</option>
                                                    <option value="1">Centro</option>
                                                    <option value="2">Norte</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" hidden id="enviar-infor-zona">Enviar</button>
                                </form>
                            </div>
                        </div>

                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <h4 class="card-title">Usuarios agregados</h4>
                                <div class="card-tools">
                                    <i class="fas fa-ban text-danger" style="cursor:pointer;" title="Bloquear información del calendario"
                                        onclick="BloquearCalendario()"></i>
                                </div>
                            </div>
                            <div class="card-body">

                                <input class="form-control mb-4" autocomplete="off" type="text" id="searchInput" placeholder="Buscar...">
                                <!-- the events -->
                                <!-- class="overflow-auto" style="max-width: 300px; max-height: 250px;" -->
                                <div id="external-events" class="overflow-auto" style="max-width: 300px; max-height: 320px;">
                                    @foreach ($asesores as $item)
                                        <div class="external-event" data-url="" data-evento="1" data-zona="{{ $item->zona }}"
                                            data-cedula="{{ $item->id }}"
                                            style="background-color: rgb(10, 136, 138); border-color: rgb(10, 136, 138); color: rgb(255, 255, 255); position: relative;">
                                            {{ $item->nombre }}</div>
                                    @endforeach
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
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12 mb-2">
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


        <div class="modal fade" id="actualizar-programacion-calendario">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title">Información del evento</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="was-validated" id="formulario-actualizar-info-prog-cal" autocomplete="off">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6" hidden>
                                    <label for="inputEmail4">id</label>
                                    <input type="text" class="form-control" id="id_prog_cal" name="id_prog_cal">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Nombre</label>
                                    <input type="text" class="form-control" id="nombre_prog_cal" name="nombre_prog_cal">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Fecha inicio</label>
                                    <input type="date" class="form-control" id="fecha_i_prog_cal" name="fecha_i_prog_cal">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Fecha final</label>
                                    <input type="date" class="form-control" id="fecha_f_prog_cal" name="fecha_f_prog_cal">
                                </div>
                            </div>
                            <div class="form-group" hidden>
                                <label for="inputAddress">Url <small>(Para reunión general)</small> </label>
                                <input type="text" class="form-control" id="url_prog_cal" name="url_prog_cal"
                                    placeholder="https://meet.google.com/udd-nkrg-ujr">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCity">Evento</label>
                                    <select name="tipo_evento_prog_cal" id="tipo_evento_prog_cal" class="form-control">
                                        <option value="">Seleccionar...</option>
                                        <option value="1">Descanso</option>
                                        <option value="2">Dominical</option>
                                        <!-- <option value="3">Reunión</option> -->
                                        <option value="4">Compensatorio mes anterior</option>
                                        <option value="5">Compensatorio próximo mes</option>
                                        <option value="6">Compensatorio adelantado</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputState">Asesor quien reemplaza</label>
                                    <select name="cedula_reemplaza_prog" id="cedula_reemplaza_prog" class="form-control">
                                        <option value="/">Seleccionar...</option>
                                        <?php foreach ($asesores_ as $key => $val) { ?>
                                        <option value="<?php echo $val->id . '/' . $val->nombre; ?>"><?php echo $val->nombre; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress2">Observación</label>
                                <textarea name="observacion_evento_cal" class="form-control" id="observacion_evento_cal" placeholder="Observaciones de la programación"
                                    cols="30" rows="1"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer left-content-between">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar información</button>
                        <button type="button" class="btn btn-danger" onclick="EliminarEventoCalendario()">Eliminar evento</button>
                        <button type="button" class="btn btn-success" onclick="ActualilzarEventoCalendario()">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('footer')
    <script>
        // Función para filtrar asesores
        function filterEvents() {
            var searchText = document.getElementById('searchInput').value.toLowerCase();
            var events = document.querySelectorAll('.external-event');

            events.forEach(function(event) {
                var eventName = event.textContent.toLowerCase();
                if (eventName.includes(searchText)) {
                    event.style.display = 'block';
                } else {
                    event.style.display = 'none';
                }
            });
        }
        document.getElementById('searchInput').addEventListener('input', filterEvents);
    </script>

    <script>
        $(function() {

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
                            bloqueado: '<?php echo $value->bloqueado; ?>'
                        },
                        allDay: true
                    },
                    <?php } ?>
                ],
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar !!!
                eventReceive: function(info) {

                    var fecha_calendario = ObtenerFechaSeleccionada(info.event._instance.range.end);

                    var datos = $.ajax({
                        type: "POST",
                        url: window.location.href + "/nuevo-evento",
                        dataType: "json",
                        data: {
                            cedula_u: info.event._def.extendedProps.cedula_u,
                            nombre_e: info.event._def.title,
                            fecha_i: fecha_calendario,
                            url: info.event._def.url,
                            color: info.event._def.ui.backgroundColor,
                            evento: info.event._def.extendedProps.evento,
                            zona: info.event._def.extendedProps.zona
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    datos.done((res) => {
                        if (res.status == true) {
                            if ((info.event._def.ui.backgroundColor) == 'rgb(220, 53, 69)') {
                                info.draggedEl.parentNode.removeChild(info.draggedEl);
                            }
                            location.reload();
                        }
                    });
                    datos.fail(() => {
                        Swal.fire(
                            'ERROR!',
                            'Hubo un problema al procesar la solicitud',
                            'error'
                        )
                    });
                },
                eventChange: function(info) {
                    if (info.event._def.extendedProps.bloqueado == '0') {
                        var id_evento = info.event._def.publicId;
                        var date_i = info.event._instance.range.start;
                        var date_f = info.event._instance.range.end;

                        var fecha_i = ObtenerFechaSeleccionada(date_i);
                        var fecha_f = ObtenerFechaSeleccionada(date_f);

                        var datos = $.ajax({
                            type: "POST",
                            url: window.location.href + "/actualizar-fecha-evento",
                            dataType: "json",
                            data: {
                                id_evento,
                                fecha_i,
                                fecha_f
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }

                        });
                        datos.done((res) => {
                            if (res.status == true) {
                                location.reload();
                            }
                        });
                        datos.fail(() => {
                            Swal.fire(
                                'ERROR!',
                                'Hubo un problema al procesar la solicitud',
                                'error'
                            )
                        });
                    } else {
                        location.reload();
                    }
                },
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
                            $('#cedula_reemplaza_prog').val(info.event._def.extendedProps.ced_reem + "/" + info.event._def
                                .extendedProps.nom_reem);
                            $('#observacion_evento_cal').val(info.event._def.extendedProps.obs);
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
            })
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
            })
        });

        BuscarInfoZona = () => {
            $('#enviar-infor-zona').click();
        }

        EliminarEventoCalendario = () => {
            var id_evento = $('#id_prog_cal').val();
            var datos = $.ajax({
                type: "POST",
                url: window.location.href + "/eliminar-evento",
                dataType: "json",
                data: {
                    id_evento
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            datos.done((res) => {
                if (res.status == true) {
                    Swal.fire(
                        'BIEN!',
                        'Evento eliminado',
                        'success'
                    )
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            });
            datos.fail(() => {
                Swal.fire(
                    'ERROR!',
                    'Hubo un problema al procesar la solicitud',
                    'error'
                )
            });
        }

        ActualilzarEventoCalendario = () => {
            var formData = new FormData(document.getElementById('formulario-actualizar-info-prog-cal'));
            formData.append("valor", "valor");

            var datos = $.ajax({
                url: window.location.href + "/actualizar-evento",
                type: "post",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });

            datos.done((res) => {
                if (res.status == true) {
                    Swal.fire(
                        'BIEN!',
                        res.mensaje,
                        'success'
                    )
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
                if (res.status == false) {
                    Swal.fire(
                        'ERROR!',
                        res.mensaje,
                        'error'
                    )
                }
            });
            datos.fail(() => {
                toastr.error('ERROR: Hubo un problema al procesar la solicitud');
            });
        }

        ObtenerFechaSeleccionada = (date) => {
            var year = date.getFullYear();
            var month = date.getMonth() + 1;
            var dia = date.getDate();
            if (month < 10) {
                month = "0" + month;
            }
            if (dia < 10) {
                dia = "0" + dia;
            }

            return fecha_calendario = year + "-" + month + "-" + dia;
        }

        $("input[name=inlineRadioOptions]").change(function() {
            var valor = $(this).val();
            switch (valor) {
                case 'A':
                    document.getElementById('formulario-agregar-nuevo-registro').hidden = false;
                    document.getElementById('url-reunion-evento').hidden = true;
                    break;
                case 'R':
                    document.getElementById('formulario-agregar-nuevo-registro').hidden = false;
                    document.getElementById('url-reunion-evento').hidden = false;
                    break;

                default:
                    document.getElementById('formulario-agregar-nuevo-registro').hidden = true;
                    document.getElementById('url-reunion-evento').hidden = true;
                    break;
            }
        });

        BloquearCalendario = () => {
            Swal.fire({
                title: 'Estás seguro de bloquear?',
                text: "No podrás reversar esta operación!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, bloquear',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var datos = ConfirmarBloqueo();
                    datos.done((res) => {
                        if (res.status == true) {
                            Swal.fire(
                                'Bloqueado!',
                                res.mensaje,
                                'success'
                            )
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                        if (res.status == false) {
                            Swal.fire(
                                'ERROR!',
                                res.mensaje,
                                'error'
                            )
                        }
                    });
                    datos.fail(() => {
                        Swal.fire(
                            'ERROR!',
                            'Hubo un problema al procesar la solicitud',
                            'error'
                        )
                    });
                }
            })
        }

        ConfirmarBloqueo = () => {
            var datos = $.ajax({
                type: "POST",
                url: window.location.href + "/bloquear-eventos",
                dataType: "json",
                data: {
                    evento: '1'
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            return datos;
        }
    </script>
@endsection
