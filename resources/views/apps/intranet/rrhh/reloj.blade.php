@extends('apps.intranet.plantilla.app')
@section('title')
    Recursos humanos
@endsection
@section('rrhh')
    bg-danger active
@endsection
@section('body')
    @php
        $baseUrl = env('APP_BASE_URL', 'http://localhost');
    @endphp
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Reloj fábrica</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-blue">Inicio</li>
                        <li class="breadcrumb-item active">RRHH</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header card-outline card-secondary">
                            <h3 class="card-title">Informes</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control float-right" id="reservation">
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item active">
                                    <div class="nav-link" style="cursor: pointer" onclick="buscarInformacionApi('1')">
                                        <i class="fas fa-inbox"></i> Ingresos diarios
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <div class="nav-link" style="cursor: pointer" onclick="buscarInformacionApi('2')">
                                        <i class="fas fa-inbox"></i> Permisos de salida
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <form autocomplete="off" id="form-info-operarios">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Operarios</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" name="cedula_operario" id="cedula_operario" placeholder="Cédula"
                                            aria-label="" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" onclick="Buscarinformacion()" type="button"><i
                                                    class="fas fa-search"></i> Buscar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="codigo_operario" id="codigo_operario" placeholder="Código">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="nombre" id="nombre" placeholder="Nombre">
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="seccion" id="seccion">
                                        <option value="">Seleccionar</option>
                                        <option value="MAQUINADO">MAQUINADO</option>
                                        <option value="ENSAMBLE">ENSAMBLE</option>
                                        <option value="LIJADO">LIJADO</option>
                                        <option value="PINTURA">PINTURA</option>
                                        <option value="TAPICERIA">TAPICERIA</option>
                                        <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                                        <option value="EMPAQUE">EMPAQUE</option>
                                        <option value="GENERALES DE PRODUCCION">GENERALES DE PRODUCCIÓN</option>
                                        <option value="GENERALES DE ADMINISTRACION">GENERALES DE ADMINISTRACIÓN</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="retirado" id="retirado">
                                        <option value="">Seleccionar...</option>
                                        <option value="2">Registrar</option>
                                        <option value="1">Inactivo</option>
                                        <option value="0">Activo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="float-right">
                                    <button type="button" onclick="ActualizarInformacionOperario()" class="btn btn-primary"><i
                                            class="far fa-envelope"></i> Actualizar</button>
                                </div>
                                <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Descartar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script>
        //Date range picker
        $('#reservation').daterangepicker({
            "locale": {
                "format": "YYYY-MM-DD",
                "separator": " a ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            }
        })

        buscarInformacionApi = (consulta) => {

            Swal.fire({
                position: 'top-end',
                icon: 'info',
                title: 'Consultando información...',
                showConfirmButton: false,
                timer: 10000
            })

            var fecha_i = $('#reservation').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var fecha_f = $('#reservation').data('daterangepicker').endDate.format('YYYY-MM-DD');

            var data = $.ajax({
                type: "POST",
                url: "{{ $baseUrl }}/app/public/api/reloj/rrhh/reportes",
                dataType: "json",
                data: {
                    consulta,
                    fecha_i,
                    fecha_f
                }
            })
            data.done((res) => {
                if (res.status == true) {
                    startInterval(res.id, '1');
                }
            })
            data.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Vuelve a intentarlo',
                    showConfirmButton: false,
                    timer: 2000
                })
            })
        }

        ConsultarInformacionApi = (cedula) => {
            return new Promise(resolve => {
                var data_s = $.ajax({
                    type: "POST",
                    url: "{{ $baseUrl }}/app/public/api/reloj/consultar/rrhh",
                    dataType: "json",
                    data: {
                        cedula
                    }
                });
                resolve(data_s);
            });
        }

        async function informacionApi(cedula) {
            var res = await ConsultarInformacionApi(cedula);
            if (res.status == true) {
                startInterval(res.id, '0');
            }
        }

        Buscarinformacion = () => {

            stopInterval()
            var cedula = $('#cedula_operario').val()

            Swal.fire({
                position: 'top-end',
                icon: 'info',
                title: 'Consultando información...',
                showConfirmButton: false,
                timer: 10000
            })

            document.getElementById('form-info-operarios').reset()
            $('#cedula_operario').val(cedula)
            $('#codigo_operario').val(cedula.slice(-4))
            informacionApi(cedula)
        }

        let intervalId;

        function startInterval(id, doc) {
            intervalId = setInterval(() => {
                var data = $.ajax({
                    type: "POST",
                    url: "{{ $baseUrl }}/app/public/api/reloj/consultar/respuesta",
                    dataType: "json",
                    data: {
                        id,
                        doc
                    }
                })
                data.done((res) => {
                    if (res.info === null) {
                        stopInterval();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'No hay información para este usuario',
                            showConfirmButton: false,
                            timer: 3000
                        })
                    } else {
                        if (res.status == true) {
                            stopInterval()

                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Información encontrada',
                                showConfirmButton: false,
                                timer: 1000
                            })

                            if (res.tipo !== undefined) {
                                if (res.tipo == 'doc') {
                                    window.location.href = "{{ $baseUrl }}/app/public/api/reloj/descargar/excel/" + res.id;
                                }
                            }

                            $('#nombre').val(res.info.info[0].nombre)
                            $('#seccion').val(res.info.info[0].seccion)
                            $('#retirado').val(res.info.info[0].retirado)
                        }
                    }
                })
            }, 1000);
        }

        function stopInterval() {
            clearInterval(intervalId);
        }

        ActualizarInformacionOperario = () => {

            Swal.fire({
                position: 'top-end',
                icon: 'info',
                title: 'Actualizando información...',
                showConfirmButton: false,
                timer: 10000
            })

            var formulario = new FormData(document.getElementById('form-info-operarios'));
            formulario.append('valor', 'valor');
            var datos = $.ajax({
                url: "{{ $baseUrl }}/app/public/api/reloj/consultar/rrhh/actualizar",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done((res) => {
                if (res.status == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Información actualizada',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            })
            datos.fail(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Vuelve a intentarlo',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        }
    </script>
@endsection
