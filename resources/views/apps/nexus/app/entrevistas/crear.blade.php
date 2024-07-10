@extends('apps.nexus.plantilla.app')
@section('c.entrevista')
    active
@endsection
@section('head')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        #top-tab-list {
            margin-bottom: 0px !important;
        }
    </style>

    <style type="text/css">
        body {
            background: #ECF0F1;
        }

        .wrapper {
            width: 54px;
            height: 25px;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-left: -27px;
            margin-top: -10px;
        }

        #preloader_1 {
            position: relative;
        }

        #preloader_1 span {
            display: block;
            bottom: 0px;
            width: 9px;
            height: 5px;
            background: #9b59b6;
            position: absolute;
            -webkit-animation: preloader_1 1.5s infinite ease-in-out;
            -moz-animation: preloader_1 1.5s infinite ease-in-out;
            -o-animation: preloader_1 1.5s infinite ease-in-out;
            animation: preloader_1 1.5s infinite ease-in-out;

        }

        #preloader_1 span:nth-child(2) {
            left: 11px;
            -webkit-animation-delay: .2s;
            -moz-animation-delay: .2s;
            -o-animation-delay: .2s;
            animation-delay: .2s;
        }

        #preloader_1 span:nth-child(3) {
            left: 22px;
            -webkit-animation-delay: .4s;
            -moz-animation-delay: .4s;
            -o-animation-delay: .4s;
            animation-delay: .4s;
        }

        #preloader_1 span:nth-child(4) {
            left: 33px;
            -webkit-animation-delay: .6s;
            -moz-animation-delay: .6s;
            -o-animation-delay: .6s;
            animation-delay: .6s;
        }

        #preloader_1 span:nth-child(5) {
            left: 44px;
            -webkit-animation-delay: .8s;
            -moz-animation-delay: .8s;
            -o-animation-delay: .8s;
            animation-delay: .8s;
        }

        @-webkit-keyframes preloader_1 {
            0% {
                height: 5px;
                -webkit-transform: translateY(0px);
                -moz-transform: translateY(0px);
                -o-transform: translateY(0px);
                transform: translateY(0px);
                background: #9b59b6;
            }

            25% {
                height: 25px;
                -webkit-transform: translateY(15px);
                -moz-transform: translateY(15px);
                -o-transform: translateY(15px);
                transform: translateY(15px);
                background: #09F;
            }

            50% {
                height: 5px;
                -webkit-transform: translateY(0px);
                -moz-transform: translateY(0px);
                -o-transform: translateY(0px);
                transform: translateY(0px);
                background: #9b59b6;
            }

            100% {
                height: 5px;
                -webkit-transform: translateY(0px);
                background: #9b59b6;
            }
        }

        @-webkit-keyframes preloader_1 {
            0% {
                height: 5px;
                -webkit-transform: translateY(0px);
                -moz-transform: translateY(0px);
                -o-transform: translateY(0px);
                transform: translateY(0px);
                background: #9b59b6;
            }

            25% {
                height: 25px;
                -webkit-transform: translateY(15px);
                -moz-transform: translateY(15px);
                -o-transform: translateY(15px);
                transform: translateY(15px);
                background: #09F;
            }

            50% {
                height: 5px;
                -webkit-transform: translateY(0px);
                -moz-transform: translateY(0px);
                -o-transform: translateY(0px);
                transform: translateY(0px);
                background: #9b59b6;
            }

            100% {
                height: 5px;
                -webkit-transform: translateY(0px);
                background: #9b59b6;
            }
        }

        @-webkit-keyframes preloader_1 {
            0% {
                height: 5px;
                -webkit-transform: translateY(0px);
                -moz-transform: translateY(0px);
                -o-transform: translateY(0px);
                transform: translateY(0px);
                background: #9b59b6;
            }

            25% {
                height: 25px;
                -webkit-transform: translateY(15px);
                -moz-transform: translateY(15px);
                -o-transform: translateY(15px);
                transform: translateY(15px);
                background: #09F;
            }

            50% {
                height: 5px;
                -webkit-transform: translateY(0px);
                -moz-transform: translateY(0px);
                -o-transform: translateY(0px);
                transform: translateY(0px);
                background: #9b59b6;
            }

            100% {
                height: 5px;
                -webkit-transform: translateY(0px);
                background: #9b59b6;
            }
        }

        @-webkit-keyframes preloader_1 {
            0% {
                height: 5px;
                -webkit-transform: translateY(0px);
                -moz-transform: translateY(0px);
                -o-transform: translateY(0px);
                transform: translateY(0px);
                background: #9b59b6;
            }

            25% {
                height: 25px;
                -webkit-transform: translateY(15px);
                -moz-transform: translateY(15px);
                -o-transform: translateY(15px);
                transform: translateY(15px);
                background: #09F;
            }

            50% {
                height: 5px;
                -webkit-transform: translateY(0px);
                -moz-transform: translateY(0px);
                -o-transform: translateY(0px);
                transform: translateY(0px);
                background: #9b59b6;
            }

            100% {
                height: 5px;
                -webkit-transform: translateY(0px);
                background: #9b59b6;
            }
        }
    </style>
@endsection
@section('body')
    {{--     <div id="preloader_1">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div> --}}
    <form id="form-wizard1" autocomplete="off" class="mt-5 was-validated">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <ul id="top-tab-list" class="p-0 row list-inline">
                            <li id="infoPersonal" class="col-md-2 text-start active">
                                <a href="javascript:void();">
                                    <div class="iq-icon me-3">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <span class="dark-wizard">Paso 1</span>
                                </a>
                            </li>
                            <li id="infoFamiliar" class="col-md-2 text-start">
                                <a href="javascript:void();">
                                    <div class="iq-icon me-3">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <span class="dark-wizard">Paso 2</span>
                                </a>
                            </li>
                            <li id="infoPregPersonal" class="col-md-2 text-start">
                                <a href="javascript:void();">
                                    <div class="iq-icon me-3">
                                        <i class="fas fa-user-shield"></i>
                                    </div>
                                    <span class="dark-wizard">Paso 3</span>
                                </a>
                            </li>
                            <li id="infoEducacion" class="col-md-2 text-start">
                                <a href="javascript:void();">
                                    <div class="iq-icon me-3">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                    <span class="dark-wizard">Paso 4</span>
                                </a>
                            </li>
                            <li id="experienciaLaboral" class="col-md-2 text-start">
                                <a href="javascript:void();">
                                    <div class="iq-icon me-3">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <span class="dark-wizard">Paso 5</span>
                                </a>
                            </li>
                            <li id="conocimientoEmpresa" class="col-md-2 text-start">
                                <a href="javascript:void();">
                                    <div class="iq-icon me-3">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <span class="dark-wizard">Fin</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <fieldset>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-center">Información básica y de contacto</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label>Proceso</label>
                                        <input type="text" name="info_b_c1" id="info_b_c1" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label>Sede</label>
                                        <select name="info_b_c2" id="info_b_c2" class="form-control" required>
                                            <option value="">Seleccionar...</option>
                                            <option value="1">Muebles Albura - Fábrica</option>
                                            <option value="2">Muebles Albura - Principal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label>Fecha</label>
                                        <input type="date" value="{{ date('Y-m-d') }}" readonly class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="">Cédula</label>
                                    <input type="number" name="info_b_c3" id="info_b_c3" required class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Cédula validación</label>
                                    <input type="number" onkeyup="validarCedulas(this.value)" name="cedula_validacion" id="cedula_validacion" required
                                        class="form-control">
                                    <span id="msj-error" class="text-danger" hidden><small>Las cédulas no coinciden</small></span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Nombres</label>
                                    <input type="text" name="info_b_c4" id="info_b_c4" required class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Apellidos</label>
                                    <input type="text" name="info_b_c5" id="info_b_c5" required class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Departamento</label>
                                    <select class="form-control" name="info_b_c6" id="info_b_c6" onchange="buscarCiudadDpto(this.value)" required>
                                        <option value="">Seleccionar...</option>
                                        @foreach ($departamentos as $item)
                                            <option value="{{ $item->id_depto }}">{{ $item->depto }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Ciudad</label>
                                    <select class="form-control" name="info_b_c7" id="info_b_c7" required>
                                        <option value="">Seleccionar...</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Barrio</label>
                                    <input type="text" name="info_b_c8" id="info_b_c8" required class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Dirección</label>
                                    <input type="text" name="info_b_c9" id="info_b_c9" required class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Fecha de nacimiento</label>
                                    <input type="date" name="info_b_c10" id="info_b_c10" required class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Edad</label>
                                    <input type="text" name="info_b_c11" id="info_b_c11" onclick="calcularEdad()" required class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Cargo al que aspira</label>
                                    <input type="text" name="info_b_c12" id="info_b_c12" required class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Tipo de vivienda</label>
                                    <select name="info_b_c13" id="info_b_c13" class="form-control" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="Arrendada">Arrendada</option>
                                        <option value="Propia">Propia</option>
                                        <option value="De un familiar">De un familiar</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Libreta militar</label>
                                    <input type="text" name="info_b_c14" id="info_b_c14" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Clase</label>
                                    <select name="info_b_c15" id="info_b_c15" class="form-control">
                                        <option value="">Seleccionar...</option>
                                        <option value="Primera clase">Primera clase</option>
                                        <option value="Segunda clase">Segunda clase</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Distrito</label>
                                    <input type="text" name="info_b_c16" id="info_b_c16" class="form-control">
                                </div>
                            </div>
                            <h5 class="text-center mt-4 mb-3">Dotación</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Talla de camisa</label>
                                    <input type="text" class="form-control" name="info_b_c17" id="info_b_c17">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Talla de pantalón</label>
                                    <input type="text" class="form-control" name="info_b_c18" id="info_b_c18">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Talla de zapatos</label>
                                    <input type="text" class="form-control" name="info_b_c19" id="info_b_c19">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" name="next" hidden id="etapa1" class="btn btn-primary next action-button float-end"
                                value="Next">Siguiente
                                paso</button>
                            <button type="button" class="btn btn-primary float-end" onclick="validarInformacionFormEntrevista('etapa1')">Siguiente
                                paso</button>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="card">
                        <div class="card-header">
                            <div class="text-center">
                                <h5 class="text-center">Aspectos familiares <i class="fas fa-plus-circle text-danger" style="cursor: pointer"
                                        onclick="generarInformacionFamiliar()"></i></h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <input type="text" name="cantidad_parentescos" id="cantidad_parentescos" hidden>
                            <div class="info-general-parentescos" id="informacionFamiliarEntrevista"></div>
                        </div>
                        <div class="card-footer">
                            <button type="button" name="next" hidden id="etapa2" class="btn btn-primary next action-button float-end"
                                value="Next">Siguiente</button>
                            <button type="button" name="previous" class="btn btn-dark previous action-button-previous float-end me-1"
                                value="Previous">Anterior</button>
                            <button type="button" class="btn btn-primary float-end" onclick="validarInformacionFormEntrevista('etapa2')">Siguiente
                                paso</button>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="card">
                        <div class="card-header">
                            <div class="text-center">
                                <h5 class="text-center">Aspectos personales</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($aspectos as $item)
                                    @if ($item->seccion == 1)
                                        <div class="col-md-12 mb-3">
                                            <label for="">{{ $item->aspecto }}</label>
                                            <input type="text" name="asp_p{{ $item->id_aspecto }}" id="asp_p{{ $item->id_aspecto }}"
                                                class="form-control" required>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" name="next" hidden id="etapa3" class="btn btn-primary next action-button float-end"
                                value="Next">Siguiente</button>
                            <button type="button" name="previous" class="btn btn-dark previous action-button-previous float-end me-1"
                                value="Previous">Anterior</button>
                            <button type="button" class="btn btn-primary float-end" onclick="validarInformacionFormEntrevista('etapa3')">Siguiente
                                paso</button>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="card">
                        <div class="card-header">
                            <div class="text-center">
                                <h5 class="text-center">Nivel educativo y profesional</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Educación básica (Primaria)</label>
                                    <input type="text" class="form-control" name="educacion1" id="educacion1" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Educación media (Secundaria)</label>
                                    <input type="text" class="form-control" name="educacion2" id="educacion2" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Educación superior (Técnica, Tecnológica, Profesional)</label>
                                    <input type="text" class="form-control" name="educacion3" id="educacion3">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Complementaria (Diplomados, Cursos, Seminarios)</label>
                                    <input type="text" class="form-control" name="educacion4" id="educacion4">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" name="next" hidden id="etapa4" class="btn btn-primary next action-button float-end"
                                value="Next">Siguiente</button>
                            <button type="button" name="previous" class="btn btn-dark previous action-button-previous float-end me-1"
                                value="Previous">Anterior</button>
                            <button type="button" class="btn btn-primary float-end" onclick="validarInformacionFormEntrevista('etapa4')">Siguiente
                                paso</button>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="card">
                        <div class="card-header">
                            <div class="text-center">
                                <h5 class="text-center">Experiencia laboral <i class="fas fa-plus-circle text-danger" style="cursor: pointer"
                                        onclick="generarInformacionExpLaboral()"></i></h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <input type="text" name="txtCantExpLab" id="txtCantExpLab" hidden class="form-control">
                            <ul class="list-group list-group-flush" id="infoGeneralExperienciaLaboral"></ul>
                        </div>
                        <div class="card-footer">
                            <button type="button" name="next" hidden id="etapa5" class="btn btn-primary next action-button float-end"
                                value="Next">Siguiente</button>
                            <button type="button" name="previous" class="btn btn-dark previous action-button-previous float-end me-1"
                                value="Previous">Anterior</button>
                            <button type="button" class="btn btn-primary float-end" onclick="validarInformacionFormEntrevista('etapa5')">Siguiente
                                paso</button>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="card">
                        <div class="card-header">
                            <div class="text-center">
                                <h5 class="text-center">Aspectos empresariales</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($aspectos as $item)
                                    @if ($item->seccion == 2)
                                        <div class="col-md-12 mb-3">
                                            <label for="">{{ $item->aspecto }}</label>
                                            <input type="text" name="asp_e{{ $item->id_aspecto }}" id="asp_e{{ $item->id_aspecto }}"
                                                class="form-control" required>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" name="previous" class="btn btn-dark previous action-button-previous float-end me-1"
                                value="Previous">Anterior</button>
                            <button type="button" class="btn btn-primary float-end"
                                onclick="validarInformacionFormEntrevista('etapa6')">Terminar</button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </form>
@endsection
@section('footer')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        formatterRangoFecha = (id) => {
            var start = moment().subtract(29, 'days');
            var end = moment();

            moment.locale('es');

            function cb(start, end) {
                $('#dateRangePlanner' + id + ' input').val(start.format('YYYY-MM-D') + ' hasta ' + end.format('YYYY-MM-D'));
            }

            $('#dateRangePlanner' + id).daterangepicker({
                startDate: start,
                endDate: end,
                locale: {
                    format: 'DD/MM/YYYY',
                    applyLabel: 'Aplicar',
                    cancelLabel: 'Cancelar',
                    fromLabel: 'Desde',
                    toLabel: 'Hasta',
                    customRangeLabel: 'Personalizado',
                    daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
                        'Noviembre', 'Diciembre'
                    ],
                    firstDay: 1
                },
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
                    'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
                    'Este mes': [moment().startOf('month'), moment().endOf('month')],
                    'Último mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

            $('#dateRangePlanner' + id).on('apply.daterangepicker', function(ev, picker) {
                // buscarInformacionCortes()
            });
        }

        buscarCiudadDpto = (id_depto) => {
            if (id_depto.length > 0) {
                var datos = $.ajax({
                    url: "{{ route('search.ciudad.nexus') }}",
                    type: "post",
                    dataType: "json",
                    data: {
                        id_depto
                    }
                });
                datos.done((res) => {
                    notificacion("Información encontrada", "success", 3000)
                    document.getElementById('info_b_c7').innerHTML = res.info
                })
            } else {
                document.getElementById('info_b_c7').innerHTML = ""
            }
        }

        validarCedulas = (valor) => {
            var cedula = document.getElementById('info_b_c3').value
            if (cedula.length > 0) {
                if (valor != cedula) {
                    document.getElementById('msj-error').hidden = false
                } else {
                    document.getElementById('msj-error').hidden = true
                }
            }
        }

        calcularEdad = () => {
            var fechaNacimiento = $("#info_b_c10").val()

            var nacimiento = new Date(fechaNacimiento);
            var hoy = new Date();

            var edad = hoy.getFullYear() - nacimiento.getFullYear();
            var mes = hoy.getMonth() - nacimiento.getMonth();
            if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
                edad--;
            }

            $("#info_b_c11").val(edad);
        }

        generarInformacionFamiliar = () => {
            const container = document.getElementById('informacionFamiliarEntrevista');
            const divCount = container.childElementCount + 1;
            const newDiv = document.createElement('div');
            newDiv.classList.add('row', 'mb-3');
            newDiv.id = `info-parentesco-${divCount}`;

            newDiv.innerHTML = `
                                <div class="col-md-4">
                                    <label for="">Nombre y apellidos</label>
                                    <input type="text" name="nombre_p_e${divCount}" id="nombre_p_e${divCount}" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Parentesco</label>
                                    <input type="text" name="parentesco_e${divCount}" id="parentesco_e${divCount}" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Edad</label>
                                    <input type="text" name="edad_p_e${divCount}" id="edad_p_e${divCount}" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Ocupación</label>
                                    <div class="input-group">
                                        <input type="text" name="ocupacion_p_e${divCount}" id="ocupacion_p_e${divCount}" class="form-control" required>
                                        <button class="btn btn-outline-danger delete-info-parentesco" type="button" id="button-addon2"><i class="fas fa-user-times"></i></button>
                                    </div>
                                    
                                </div>
                                `;

            newDiv.querySelector('.delete-info-parentesco').addEventListener('click', () => {
                container.removeChild(newDiv);
                updateIdentifiersEspe(container);
            });

            container.appendChild(newDiv);
            $("#cantidad_parentescos").val(divCount)
        }

        updateIdentifiersEspe = (container) => {
            const children = container.children;
            for (let i = 0; i < children.length; i++) {
                const div = children[i];
                div.id = `info-parentesco-${i + 1}`;
                const nombre_p_e = div.querySelector('input[name^="nombre_p_e"]');
                nombre_p_e.name = `nombre_p_e${i + 1}`;
                nombre_p_e.id = `nombre_p_e${i + 1}`;

                const parentesco_e = div.querySelector('input[name^="parentesco_e"]');
                parentesco_e.name = `parentesco_e${i + 1}`;
                parentesco_e.id = `parentesco_e${i + 1}`;

                const edad_p_e = div.querySelector('input[name^="edad_p_e"]');
                edad_p_e.name = `edad_p_e${i + 1}`;
                edad_p_e.id = `edad_p_e${i + 1}`;

                const ocupacion_p_e = div.querySelector('input[name^="ocupacion_p_e"]');
                ocupacion_p_e.name = `ocupacion_p_e${i + 1}`;
                ocupacion_p_e.id = `ocupacion_p_e${i + 1}`;
            }
            $("#cantidad_parentescos").val(children.length)
        }

        generarInformacionExpLaboral = () => {
            const container = document.getElementById('infoGeneralExperienciaLaboral');
            const divCount = container.childElementCount + 1;
            const newDiv = document.createElement('li');
            newDiv.classList.add('list-group-item', 'mb-3');
            newDiv.id = `lista-${divCount}`;

            newDiv.innerHTML = `
                                <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <label for="">Empresa</label>
                                            <div class="input-group">
                                                <button class="btn btn-outline-danger delete-info-exp" type="button"><i class="fas fa-user-times"></i></button>
                                                <input type="text" class="form-control" name="exp_lab_e${divCount}" id="exp_lab_e${divCount}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label for="">Cargo</label>
                                            <input type="text" name="exp_lab_c${divCount}" id="exp_lab_c${divCount}" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label for="">Periodo</label>
                                            <div id="dateRangePlanner${divCount}">
                                                <input class="form-control" name="exp_lab_fech${divCount}" id="exp_lab_fech${divCount}" value="{{ date('Y-m-d') . ' hasta ' . date('Y-m-d') }}" required></input> <b class="caret"></b>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="">Funciones</label>
                                            <textarea name="exp_lab_f${divCount}" id="exp_lab_f${divCount}" class="form-control" cols="30" rows="2" required></textarea>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="">Motivo retiro</label>
                                            <textarea name="exp_lab_m${divCount}" id="exp_lab_m${divCount}" class="form-control" cols="30" rows="2" required></textarea>
                                        </div>
                                    </div>
                                `;

            newDiv.querySelector('.delete-info-exp').addEventListener('click', () => {
                container.removeChild(newDiv);
                updateInfoExperienciaLab(container);
            });

            container.appendChild(newDiv);
            formatterRangoFecha(divCount)
            $("#txtCantExpLab").val(divCount)
        }

        updateInfoExperienciaLab = (container) => {
            const children = container.children;
            for (let i = 0; i < children.length; i++) {
                const div = children[i];
                div.id = `lista-${i + 1}`;

                const exp_lab_e = div.querySelector('input[name^="exp_lab_e"]');
                exp_lab_e.name = `exp_lab_e${i + 1}`;
                exp_lab_e.id = `exp_lab_e${i + 1}`;

                const exp_lab_c = div.querySelector('input[name^="exp_lab_c"]');
                exp_lab_c.name = `exp_lab_c${i + 1}`;
                exp_lab_c.id = `exp_lab_c${i + 1}`;

                const exp_lab_fech = div.querySelector('input[name^="exp_lab_fech"]');
                exp_lab_fech.name = `exp_lab_fech${i + 1}`;
                exp_lab_fech.id = `exp_lab_fech${i + 1}`;

                const exp_lab_f = div.querySelector('textarea[name^="exp_lab_f"]');
                exp_lab_f.name = `exp_lab_f${i + 1}`;
                exp_lab_f.id = `exp_lab_f${i + 1}`;

                const exp_lab_m = div.querySelector('textarea[name^="exp_lab_m"]');
                exp_lab_m.name = `exp_lab_m${i + 1}`;
                exp_lab_m.id = `exp_lab_m${i + 1}`;
            }
            $("#txtCantExpLab").val(children.length)
        }

        let recognition = null;
        let isRecognizing = false;

        escribirConocimientoEmpresa = () => {

            const resultInput = document.getElementById('asp_e1');

            if (!recognition) {
                recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
                recognition.lang = 'es-ES'; // Configura el idioma, en este caso español

                recognition.onstart = () => {
                    console.log('Iniciando reconocimiento de voz...');
                    isRecognizing = true;
                };

                recognition.onspeechend = () => {
                    console.log('Detenido debido a pausa en el habla.');
                    recognition.stop();
                };

                recognition.onresult = (event) => {
                    const transcript = event.results[0][0].transcript;
                    resultInput.value += transcript + ' ';
                };

                recognition.onnomatch = () => {
                    console.log('No se reconoció la voz.');
                };

                recognition.onerror = (event) => {
                    console.log('Error en el reconocimiento de voz:', event.error);
                    if (event.error === 'no-speech' && isRecognizing) {
                        recognition.start(); // Reiniciar reconocimiento si no hay habla
                    }
                };

                recognition.onend = () => {
                    if (isRecognizing) {
                        console.log('Reiniciando reconocimiento de voz...');
                        recognition.start();
                    }
                };
            }
            recognition.start();
        }

        function stopRecognition() {
            if (recognition) {
                isRecognizing = false;
                recognition.stop();
                console.log('Reconocimiento de voz detenido manualmente.');
            }
        }

        validarInformacionFormEntrevista = (etapa) => {
            var depto = document.getElementById("info_b_c6");
            var nom_depto = depto.options[depto.selectedIndex].text;

            var ciudad = document.getElementById("info_b_c7");
            var nom_ciudad = ciudad.options[ciudad.selectedIndex].text;

            var formulario = new FormData(document.getElementById('form-wizard1'));
            formulario.append('etapa', etapa);
            formulario.append('departamento', nom_depto);
            formulario.append('ciudad', nom_ciudad);

            var datos = $.ajax({
                url: "{{ route('validar.info.entrevista') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done(function(res) {
                if (res.status == true) {
                    if (etapa == "etapa6") {
                        guardarInformacionEntrevistaRealizada()
                    } else {
                        $("#" + etapa).click()
                    }
                }
                if (res.status == false) {
                    notificacion(res.mensaje, "error", 5000)
                }
            })
        }

        guardarInformacionEntrevistaRealizada = () => {
            notificacion("Guardando entrevista realizada, por favor espere...", "info", 6000)

            var depto = document.getElementById("info_b_c6");
            var nom_depto = depto.options[depto.selectedIndex].text;

            var ciudad = document.getElementById("info_b_c7");
            var nom_ciudad = ciudad.options[ciudad.selectedIndex].text;

            var formulario = new FormData(document.getElementById('form-wizard1'));
            formulario.append('departamento', nom_depto);
            formulario.append('ciudad', nom_ciudad);

            var datos = $.ajax({
                url: "{{ route('almacenar.info.entrevista') }}",
                type: "post",
                dataType: "json",
                data: formulario,
                cache: false,
                contentType: false,
                processData: false
            });
            datos.done(function(res) {
                if (res.status == true) {
                    notificacion(res.mensaje, "success", 3000)
                    setTimeout(() => {
                        window.location.reload()
                    }, 1000);
                }
            })
        }
    </script>
@endsection
